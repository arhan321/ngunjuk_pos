<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OperationalCostMonthlyAdjustment extends Model
{
    protected $fillable = [
        'operational_cost_id',
        'month',
        'year',
        'amount',
        'note',
        'is_deleted_for_month',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'amount' => 'integer',
        'is_deleted_for_month' => 'boolean',
    ];

    public function operationalCost(): BelongsTo
    {
        return $this->belongsTo(OperationalCost::class);
    }
}
