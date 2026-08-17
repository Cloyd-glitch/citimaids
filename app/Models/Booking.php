<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'property_type',
        'rooms',
        'bathrooms',
        'deep_clean',
        'frequency',
        'scheduled_date',
        'scheduled_time',
        'address',
        'notes',
        'total',
        'status',
        'reference',
    ];

    protected $casts = [
        'deep_clean' => 'boolean',
        'scheduled_date' => 'date',
        'total' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}