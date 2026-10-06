<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pack extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price_per_day',
        'deposit',
        'energy_capacity_wh',
        'continuous_power_w',
        'surge_power_w',
        'recommended_uses',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'deposit' => 'decimal:2',
        'recommended_uses' => 'array',
        'is_active' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'pack_products')
            ->withPivot('quantity');
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class, 'recommended_pack_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }
}
