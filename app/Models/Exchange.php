<?php

namespace App\Models;

use App\Models\Community;
use App\Models\ExchangeTransaction;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    protected $table = 'exchange';

    protected $fillable = [
        'community_id',
        'exchange_status',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function exchangeTransactions(): HasMany
    {
        return $this->hasMany(ExchangeTransaction::class);
    }
}