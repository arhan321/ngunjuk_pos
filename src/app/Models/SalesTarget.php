<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTarget extends Model
{
    protected $fillable = [
        'month',
        'target_revenue',
        'target_gross_profit',
        'target_net_profit',
        'note',
    ];

    protected $casts = [
        'month' => 'date',
        'target_revenue' => 'integer',
        'target_gross_profit' => 'integer',
        'target_net_profit' => 'integer',
    ];
}