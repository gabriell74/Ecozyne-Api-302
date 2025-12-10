<?php

namespace App\Models;

use App\Models\WasteBank;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrashTransaction extends Model
{
    protected $table = 'trash_transaction';

    protected $fillable = [
        'waste_bank_id',
        'user_id',
        'poin_earned',
        'trash_weight',
    ];

    public function wasteBank(): BelongsTo
    {
        return $this->belongsTo(WasteBank::class);
    }
}