<?php

namespace App\Models;

use App\Models\Reward;
use App\Models\Exchange;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExchangeTransaction extends Model
{
    protected $table = 'exchange_transaction';
    
    protected $fillable = [
        'exchange_id',
        'reward_id',
        'amount',
        'total_unit_point',
    ];

    public function exchange(): BelongsTo
    {
        return $this->belongsTo(Exchange::class);
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }
}
