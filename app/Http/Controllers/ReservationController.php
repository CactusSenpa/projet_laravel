<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Pack;
use App\Models\Quote;
use App\Models\Reservation;
use App\Services\AvailabilityService;
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
        $pack = $request->filled('pack') ? Pack::query()->find($request->integer('pack')) : null;
        $quote = $request->filled('quote') ? Quote::query()->find($request->integer('quote')) : null;

        $governorates = [
            'Tunis', 'Ariana', 'Ben Arous', 'Manouba', 'Nabeul', 'Zaghouan',
            'Bizerte', 'Béja', 'Jendouba', 'Le Kef', 'Siliana', 'Sousse',
            'Monastir', 'Mahdia', 'Sfax', 'Kairouan', 'Kasserine', 'Sidi Bouzid',
            'Gabès', 'Médenine', 'Tataouine', 'Gafsa', 'Tozeur', 'Kébili',
        ];

        return view('reservations.create', compact('packs', 'pack', 'quote', 'governorates'));
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $pack = isset($data['pack_id']) ? Pack::query()->find($data['pack_id']) : null;
        $days = reservation_days(
            \Carbon\Carbon::parse($data['start_date']),
            \Carbon\Carbon::parse($data['end_date'])
        );

        $delivery = $request->boolean('delivery_required');
        $deliveryFee = $delivery ? (float) setting('delivery_fee', 30) : 0;
        $price = ($pack?->price_per_day ?? 0) * $days + $deliveryFee;

        $reservation = Reservation::query()->create([
            ...$data,
            'delivery_required' => $delivery,
            'delivery_fee' => $delivery ? $deliveryFee : null,
            'status' => 'pending',
            'estimated_price' => $price,
            'deposit_amount' => $pack?->deposit ?? 0,
        ]);

        if ($pack) {
            $this->availability->syncReservation($reservation);
        }

        return redirect()->route('reservation.success', $reservation);
    }

    public function success(Reservation $reservation): View
    {
        $reservation->load('pack');
        $message = $this->whatsappMessage($reservation);

        return view('reservations.success', [
            'reservation' => $reservation,
            'whatsappMessageUrl' => whatsapp_url($message),
        ]);
    }

    private function whatsappMessage(Reservation $reservation): string
    {
        $pack = $reservation->pack?->name ?? 'matériel à confirmer';

        return "Bonjour WattLoc, je souhaite confirmer ma demande de réservation n°{$reservation->id}.\n"
            ."Pack : {$pack}\n"
            ."Nom : {$reservation->customer_name}\n"
            ."Téléphone : {$reservation->customer_phone}\n"
            ."Dates : {$reservation->start_date->format('d/m/Y')} → {$reservation->end_date->format('d/m/Y')}\n"
            ."Lieu : {$reservation->location}\n"
            ."Total estimé : ".tnd($reservation->estimated_price);
    }
}
