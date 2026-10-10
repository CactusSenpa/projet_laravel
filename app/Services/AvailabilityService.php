<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Pack;
use App\Models\Product;
use App\Models\Reservation;
use App\Models\ReservationProduct;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;

class AvailabilityService
{
    /**
     * Compute total reserved units of a product on a specific date from confirmed reservations
     * (both direct reservations and packs that include this product).
     */
    public function getReservedQuantityForProductOnDate(Product|int $product, CarbonInterface|string $date): int
    {
        $productId = $product instanceof Product ? $product->id : (int) $product;
        $dateStr = $date instanceof CarbonInterface ? $date->toDateString() : (string) $date;

        // Direct product reservations that are confirmed
        $directQty = (int) ReservationProduct::query()
            ->where('product_id', $productId)
            ->whereHas('reservation', function ($q) use ($dateStr) {
                $q->where('status', 'confirmed')
                    ->whereDate('start_date', '<=', $dateStr)
                    ->whereDate('end_date', '>=', $dateStr);
            })
            ->sum('quantity');

        // Pack reservations that include this product that are confirmed
        $packReservations = Reservation::query()
            ->whereNotNull('pack_id')
            ->where('status', 'confirmed')
            ->whereDate('start_date', '<=', $dateStr)
            ->whereDate('end_date', '>=', $dateStr)
            ->with('pack.products')
            ->get();

        $packQty = 0;
        foreach ($packReservations as $reservation) {
            if ($reservation->pack) {
                $component = $reservation->pack->products->firstWhere('id', $productId);
                if ($component) {
                    $packQty += (int) ($component->pivot->quantity ?? 1);
                }
            }
        }

        return $directQty + $packQty;
    }

    public function isProductAvailableOnDate(Product $product, CarbonInterface|string $date, int $requestedQty = 1): bool
    {
        $reserved = $this->getReservedQuantityForProductOnDate($product, $date);

        return ($product->quantity - $reserved) >= $requestedQty;
    }

    public function isProductAvailable(Product $product, CarbonInterface $start, CarbonInterface $end, int $requestedQty = 1): bool
    {
        $period = CarbonPeriod::create($start, $end);

        foreach ($period as $date) {
            if (! $this->isProductAvailableOnDate($product, $date, $requestedQty)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns an array of Y-m-d date strings that are fully booked / out of stock
     * for the given product and quantity.
     *
     * @return array<int, string>
     */
    public function getUnavailableDatesForProduct(Product $product, int $requestedQty = 1): array
    {
        $today = now()->toDateString();

        // 1. Confirmed direct reservations overlapping today or future
        $directReservations = Reservation::query()
            ->where('status', 'confirmed')
            ->where('end_date', '>=', $today)
            ->whereHas('products', fn ($p) => $p->where('product_id', $product->id))
            ->get(['start_date', 'end_date']);

        // 2. Confirmed pack reservations containing this product
        $packReservations = Reservation::query()
            ->where('status', 'confirmed')
            ->where('end_date', '>=', $today)
            ->whereHas('pack.products', fn ($p) => $p->where('products.id', $product->id))
            ->get(['start_date', 'end_date']);

        $all = $directReservations->concat($packReservations);
        if ($all->isEmpty()) {
            return [];
        }

        $datesToCheck = [];
        foreach ($all as $res) {
            $period = CarbonPeriod::create(
                max($today, $res->start_date->toDateString()),
                $res->end_date->toDateString()
            );
            foreach ($period as $d) {
                $datesToCheck[$d->toDateString()] = true;
            }
        }

        $unavailableDates = [];
        foreach (array_keys($datesToCheck) as $dateStr) {
            if (! $this->isProductAvailableOnDate($product, $dateStr, $requestedQty)) {
                $unavailableDates[] = $dateStr;
            }
        }

        sort($unavailableDates);

        return $unavailableDates;
    }

    public function isPackAvailableOnDate(Pack $pack, CarbonInterface|string $date): bool
    {
        $pack->loadMissing('products');
        $dateStr = $date instanceof CarbonInterface ? $date->toDateString() : (string) $date;

        // Check if the pack itself is already booked
        $packBooked = Reservation::query()
            ->where('pack_id', $pack->id)
            ->where('status', 'confirmed')
            ->whereDate('start_date', '<=', $dateStr)
            ->whereDate('end_date', '>=', $dateStr)
            ->count();

        if ($packBooked >= 1) {
            return false;
        }

        // Check if any component product has insufficient stock
        foreach ($pack->products as $component) {
            $neededQty = (int) ($component->pivot->quantity ?? 1);
            $reserved = $this->getReservedQuantityForProductOnDate($component, $dateStr);
            if (($component->quantity - $reserved) < $neededQty) {
                return false;
            }
        }

        return true;
    }

    public function isPackAvailable(Pack $pack, CarbonInterface $start, CarbonInterface $end): bool
    {
        $period = CarbonPeriod::create($start, $end);

        foreach ($period as $date) {
            if (! $this->isPackAvailableOnDate($pack, $date)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns an array of Y-m-d date strings that are unavailable for the given pack.
     *
     * @return array<int, string>
     */
    public function getUnavailableDatesForPack(Pack $pack): array
    {
        $pack->loadMissing('products');
        $today = now()->toDateString();

        // 1. Direct reservations of this pack
        $packReservations = Reservation::query()
            ->where('pack_id', $pack->id)
            ->where('status', 'confirmed')
            ->where('end_date', '>=', $today)
            ->get(['start_date', 'end_date']);

        // 2. Reservations of any component product of this pack
        $componentIds = $pack->products->pluck('id')->all();
        $componentReservations = Reservation::query()
            ->where('status', 'confirmed')
            ->where('end_date', '>=', $today)
            ->where(function ($q) use ($componentIds) {
                $q->whereHas('products', fn ($p) => $p->whereIn('product_id', $componentIds))
                    ->orWhereHas('pack.products', fn ($p) => $p->whereIn('products.id', $componentIds));
            })
            ->get(['start_date', 'end_date']);

        $all = $packReservations->concat($componentReservations);
        if ($all->isEmpty()) {
            return [];
        }

        $datesToCheck = [];
        foreach ($all as $res) {
            $period = CarbonPeriod::create(
                max($today, $res->start_date->toDateString()),
                $res->end_date->toDateString()
            );
            foreach ($period as $d) {
                $datesToCheck[$d->toDateString()] = true;
            }
        }

        $unavailableDates = [];
        foreach (array_keys($datesToCheck) as $dateStr) {
            if (! $this->isPackAvailableOnDate($pack, $dateStr)) {
                $unavailableDates[] = $dateStr;
            }
        }

        sort($unavailableDates);

        return $unavailableDates;
    }

    public function syncReservation(Reservation $reservation): void
    {
        $reservation->loadMissing(['pack.products', 'products.product']);
        $period = CarbonPeriod::create($reservation->start_date, $reservation->end_date);

        if ($reservation->pack_id && $reservation->pack) {
            foreach ($period as $date) {
                $isAvailable = $this->isPackAvailableOnDate($reservation->pack, $date);
                Availability::query()->updateOrCreate(
                    [
                        'pack_id' => $reservation->pack_id,
                        'date' => $date->toDateString(),
                    ],
                    [
                        'product_id' => null,
                        'quantity_total' => 1,
                        'quantity_reserved' => $isAvailable ? 0 : 1,
                        'quantity_available' => $isAvailable ? 1 : 0,
                    ]
                );
            }
        }

        foreach ($reservation->products as $resProduct) {
            $product = $resProduct->product;
            if (! $product) {
                continue;
            }

            foreach ($period as $date) {
                $reservedQty = $this->getReservedQuantityForProductOnDate($product, $date);

                Availability::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'date' => $date->toDateString(),
                    ],
                    [
                        'pack_id' => null,
                        'quantity_total' => $product->quantity,
                        'quantity_reserved' => $reservedQty,
                        'quantity_available' => max(0, $product->quantity - $reservedQty),
                    ]
                );
            }
        }
    }
}
