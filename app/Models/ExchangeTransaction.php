<?php

namespace App\Models;

use App\Models\Exchange;
use App\Models\Reward;
use Illuminate\Database\Eloquent\Model;

class ExchangeTransaction extends Model
{
    protected $table = 'exchange_registration';
    
    protected $fillable = [
        'exchange_id',
        'reward_id',
        'amount',
        'unit_point',
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
