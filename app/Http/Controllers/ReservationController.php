<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Pack;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Reservation;
use App\Services\AvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(private AvailabilityService $availability)
    {
    }

    public function create(Request $request): View
    {
        $packs = Pack::query()->where('is_active', true)->orderBy('name')->get();
        $products = Product::query()->where('is_active', true)->with('category')->orderBy('name')->get();

        $pack = $request->filled('pack') ? Pack::query()->find($request->integer('pack')) : null;
        $selectedProduct = $request->filled('product') ? Product::query()->find($request->integer('product')) : null;
        $quote = $request->filled('quote') ? Quote::query()->find($request->integer('quote')) : null;

        $initialUnavailableDates = [];
        if ($selectedProduct) {
            $initialUnavailableDates = $this->availability->getUnavailableDatesForProduct($selectedProduct);
        } elseif ($pack) {
            $initialUnavailableDates = $this->availability->getUnavailableDatesForPack($pack);
        }

        $governorates = [
            'Tunis', 'Ariana', 'Ben Arous', 'Manouba', 'Nabeul', 'Zaghouan',
            'Bizerte', 'Béja', 'Jendouba', 'Le Kef', 'Siliana', 'Sousse',
            'Monastir', 'Mahdia', 'Sfax', 'Kairouan', 'Kasserine', 'Sidi Bouzid',
            'Gabès', 'Médenine', 'Tataouine', 'Gafsa', 'Tozeur', 'Kébili',
        ];

        return view('reservations.create', compact('packs', 'pack', 'products', 'selectedProduct', 'quote', 'governorates', 'initialUnavailableDates'));
    }

    public function unavailableDates(Request $request): JsonResponse
    {
        $packId = $request->input('pack_id');
        $productId = $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $unavailableDates = [];

        if ($productId) {
            $product = Product::query()->find($productId);
            if ($product) {
                $unavailableDates = $this->availability->getUnavailableDatesForProduct($product, $quantity);
            }
        } elseif ($packId) {
            $pack = Pack::query()->find($packId);
            if ($pack) {
                $unavailableDates = $this->availability->getUnavailableDatesForPack($pack);
            }
        }

        return response()->json([
            'unavailable_dates' => $unavailableDates,
        ]);
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $pack = !empty($data['pack_id']) ? Pack::query()->find($data['pack_id']) : null;
        $product = !empty($data['product_id']) ? Product::query()->find($data['product_id']) : null;
        $productQuantity = max(1, (int) ($data['product_quantity'] ?? 1));

        $startDate = \Carbon\Carbon::parse($data['start_date']);
        $endDate = \Carbon\Carbon::parse($data['end_date']);

        // Check availability against confirmed bookings
        if ($product && ! $this->availability->isProductAvailable($product, $startDate, $endDate, $productQuantity)) {
            return back()->withInput()->withErrors([
                'start_date' => "Le matériel \"{$product->name}\" n'est plus disponible pour les dates sélectionnées (stock insuffisant ou déjà réservé). Veuillez choisir d'autres dates.",
            ]);
        }

        if ($pack && ! $this->availability->isPackAvailable($pack, $startDate, $endDate)) {
            return back()->withInput()->withErrors([
                'start_date' => "Le pack \"{$pack->name}\" n'est plus disponible pour les dates sélectionnées (déjà réservé). Veuillez choisir d'autres dates.",
            ]);
        }

        $days = reservation_days($startDate, $endDate);

        $delivery = $request->boolean('delivery_required');
        $deliveryFee = $delivery ? (float) setting('delivery_fee', 30) : 0;

        $dailyPrice = 0.0;
        $deposit = 0.0;

        if ($pack) {
            $dailyPrice += (float) $pack->price_per_day;
            $deposit += (float) $pack->deposit;
        }

        if ($product) {
            $dailyPrice += ((float) $product->daily_price) * $productQuantity;
            $deposit += ((float) $product->deposit) * $productQuantity;
        }

        $estimatedPrice = ($dailyPrice * $days) + $deliveryFee;

        $reservation = Reservation::query()->create([
            'user_id' => auth()->id() ?? null,
            'quote_id' => $data['quote_id'] ?? null,
            'pack_id' => $pack?->id,
            'customer_name' => $data['customer_name'],
            'customer_phone' => $data['customer_phone'],
            'customer_email' => $data['customer_email'] ?? null,
            'cin' => $data['cin'] ?? null,
            'project_type' => $data['project_type'] ?? null,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'location' => $data['location'],
            'address' => $data['address'] ?? null,
            'delivery_required' => $delivery,
            'delivery_fee' => $delivery ? $deliveryFee : null,
            'status' => 'pending',
            'estimated_price' => $estimatedPrice,
            'deposit_amount' => $deposit,
            'customer_message' => $data['customer_message'] ?? null,
        ]);

        if ($product) {
            $reservation->products()->create([
                'product_id' => $product->id,
                'quantity' => $productQuantity,
            ]);
        }

        $this->availability->syncReservation($reservation);

        return redirect()->route('reservation.success', $reservation);
    }

    public function success(Reservation $reservation): View
    {
        $reservation->load(['pack', 'products.product']);
        $message = $this->whatsappMessage($reservation);

        return view('reservations.success', [
            'reservation' => $reservation,
            'whatsappMessageUrl' => whatsapp_url($message),
        ]);
    }

    private function whatsappMessage(Reservation $reservation): string
    {
        $reservation->loadMissing(['pack', 'products.product']);

        $lines = ["Bonjour WattLoc, je souhaite confirmer ma demande de réservation n°{$reservation->id}."];

        if ($reservation->pack) {
            $lines[] = "Pack : {$reservation->pack->name}";
        }

        if ($reservation->products->isNotEmpty()) {
            $items = $reservation->products->map(function ($rp) {
                $name = $rp->product?->name ?? 'Produit';
                return ($rp->quantity > 1 ? "{$rp->quantity}× " : '').$name;
            })->implode(', ');
            $lines[] = "Matériel : {$items}";
        }

        if (! $reservation->pack && $reservation->products->isEmpty()) {
            $lines[] = "Matériel : À confirmer avec l'équipe";
        }

        $lines[] = "Nom : {$reservation->customer_name}";
        $lines[] = "Téléphone : {$reservation->customer_phone}";
        $lines[] = "Dates : {$reservation->start_date->format('d/m/Y')} → {$reservation->end_date->format('d/m/Y')}";
        $lines[] = "Lieu : {$reservation->location}";
        $lines[] = "Total estimé : ".tnd($reservation->estimated_price);
        $lines[] = "Caution : ".tnd($reservation->deposit_amount);
        $lines[] = "Merci de me confirmer la disponibilité.";

        return implode("\n", $lines);
    }
}
