<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class OperationalCost extends Model
{
    protected $fillable = [
        'name',
        'category',
        'amount',
        'cost_date',
        'is_active',
        'note',
        'cost_type',
    ];

    protected $casts = [
        'amount' => 'integer',
        'cost_date' => 'date',
        'is_active' => 'boolean',
    ];
}
