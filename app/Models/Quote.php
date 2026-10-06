<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quote extends Model
{
    protected $fillable = [
        'project_type',
        'total_energy_wh',
        'energy_with_margin_wh',
        'max_simultaneous_power_w',
        'peak_power_w',
        'recommended_battery_wh',
        'recommended_battery_ah',
        'battery_voltage',
        'recommended_inverter_w',
        'recommended_solar_w',
        'recommended_pack_id',
    ];

    protected $casts = [
        'total_energy_wh' => 'float',
        'energy_with_margin_wh' => 'float',
        'max_simultaneous_power_w' => 'float',
        'peak_power_w' => 'float',
        'recommended_battery_wh' => 'float',
        'recommended_battery_ah' => 'float',
        'recommended_inverter_w' => 'float',
        'recommended_solar_w' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }

    public function recommendedPack(): BelongsTo
    {
        return $this->belongsTo(Pack::class, 'recommended_pack_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
