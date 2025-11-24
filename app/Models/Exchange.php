<?php

namespace App\Models;

use App\Models\Community;
use App\Models\ExchangeTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exchange extends Model
{
    protected $table = 'exchange';

    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'community_id',
        'exchange_status',
    ];

    public function getExchangeStatusLabelAttribute(): string
    {
        return match ($this->exchange_status) {
            self::STATUS_PENDING  => 'Menunggu',
            self::STATUS_APPROVED => 'Disetujui',
            self::STATUS_REJECTED => 'Ditolak',
            default               => 'Tidak Diketahui'
        };
    }


    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function exchangeTransactions(): HasMany
    {
        return $this->hasMany(ExchangeTransaction::class);
    }
}