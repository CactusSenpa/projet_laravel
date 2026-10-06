<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'reference',
        'description',
        'power_w',
        'voltage_v',
        'capacity_wh',
        'capacity_ah',
        'surge_power_w',
        'daily_price',
        'deposit',
        'quantity',
        'image',
        'is_active',
    ];

    protected $casts = [
        'daily_price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'capacity_ah' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function packs(): BelongsToMany
    {
        return $this->belongsToMany(Pack::class, 'pack_products')
            ->withPivot('quantity');
    }

    public function reservationProducts(): HasMany
    {
        return $this->hasMany(ReservationProduct::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->quantity > 0;
    }
}
