<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'icon',
        'description',
        'features',
        'base_rate',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'base_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}