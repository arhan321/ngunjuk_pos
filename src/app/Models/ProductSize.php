<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class ProductSize extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'hpp',
        'hpp_description',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'hpp' => 'integer',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
