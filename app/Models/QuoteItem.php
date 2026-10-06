<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuoteItem extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'quote_id',
        'appliance_id',
        'name',
        'power_w',
        'quantity',
        'duration_hours',
        'usage_period',
        'has_startup_surge',
        'startup_power_w',
        'energy_wh',
    ];

    protected $casts = [
        'has_startup_surge' => 'boolean',
        'duration_hours' => 'float',
        'energy_wh' => 'float',
    ];

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function appliance(): BelongsTo
    {
        return $this->belongsTo(Appliance::class);
    }
}
