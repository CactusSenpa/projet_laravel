<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'cancelled', 'completed'];

    protected $fillable = [
        'user_id',
        'quote_id',
        'pack_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'cin',
        'project_type',
        'start_date',
        'end_date',
        'location',
        'address',
        'delivery_required',
        'delivery_fee',
        'status',
        'estimated_price',
        'deposit_amount',
        'customer_message',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'delivery_required' => 'boolean',
        'delivery_fee' => 'decimal:2',
        'estimated_price' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(ReservationProduct::class);
    }

    public function days(): int
    {
        return reservation_days($this->start_date, $this->end_date);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'pending',
            'confirmed' => 'confirmed',
            'cancelled' => 'cancelled',
            'completed' => 'completed',
            default => $this->status,
        };
    }
}
