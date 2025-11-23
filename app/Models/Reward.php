<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reward extends Model
{
    protected $table = 'reward';

    protected $fillable = [
        'reward_name',
        'description',
        'photo',
        'stock',
        'unit_point',
    ];

    public function exchangeTransactions(): HasMany
    {
        return $this->hasMany(ExchangeTransaction::class);
    }
}