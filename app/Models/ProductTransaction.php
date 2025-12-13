<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTransaction extends Model
{
    protected $table = 'product_transaction';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_price',
        'product_name',
        'order_customer',
        'order_phone_number',
        'order_address',
        'total_price',
        'amount',
    ];

    protected $casts = [
        'total_price' => 'integer',
        'amount' => 'integer',
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