<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_size_id',
        'product_name',
        'size_name',
        'price',
        'hpp',
        'quantity',
        'subtotal',
        'total_hpp',
        'gross_profit',
        'note',
    ];

    protected $casts = [
        'price' => 'integer',
        'hpp' => 'integer',
        'quantity' => 'integer',
        'subtotal' => 'integer',
        'total_hpp' => 'integer',
        'gross_profit' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }
}