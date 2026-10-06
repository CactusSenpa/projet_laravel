<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Pack;
use App\Models\Reservation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AvailabilityService
{
    public function isPackAvailable(Pack $pack, Carbon $start, Carbon $end): bool
    {
        $confirmed = Reservation::query()
            ->where('pack_id', $pack->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('start_date', '<=', $end->toDateString())
            ->whereDate('end_date', '>=', $start->toDateString())
            ->count();

        return $confirmed < 1;
    }

    public function syncReservation(Reservation $reservation): void
    {
        if (! $reservation->pack_id) {
            return;
        }

        $period = CarbonPeriod::create($reservation->start_date, $reservation->end_date);

        foreach ($period as $date) {
            $reserved = Reservation::query()
                ->where('pack_id', $reservation->pack_id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->whereDate('start_date', '<=', $date->toDateString())
                ->whereDate('end_date', '>=', $date->toDateString())
                ->count();

            Availability::query()->updateOrCreate(
                [
                    'pack_id' => $reservation->pack_id,
                    'date' => $date->toDateString(),
                ],
                [
                    'product_id' => null,
                    'quantity_total' => 1,
                    'quantity_reserved' => $reserved,
                    'quantity_available' => max(0, 1 - $reserved),
                ]
            );
        }
    }
}
