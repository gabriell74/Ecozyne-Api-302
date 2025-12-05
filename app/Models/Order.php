<?php

namespace App\Models;

use App\Models\Community;
use App\Models\WasteBank;
use App\Models\ProductTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'order';

    protected $fillable = [
        'community_id',
        'waste_bank_id',
        'status_order',
        'status_payment',
        'cancellation_reason',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function wasteBank(): BelongsTo
    {
        return $this->belongsTo(WasteBank::class);
    }

    public function productTransaction(): HasMany
    {
        return $this->hasMany(ProductTransaction::class);
    }
}