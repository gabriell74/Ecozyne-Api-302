<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    protected $table = 'product_transaction';

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'amount',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}