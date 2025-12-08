<?php

namespace App\Models;

use App\Models\WasteBank;
use App\Models\ProductTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'waste_bank_id',
        'product_name',
        'description',
        'price',
        'stock',
        'photo',
    ];

    protected $casts = [
        'price' => 'float',
        'stock' => 'integer',
    ];

    public function wasteBank(): BelongsTo
    {
        return $this->belongsTo(WasteBank::class);
    }

    public function productTransaction(): HasMany
    {
        return $this->hasMany(ProductTransaction::class);
    }
}