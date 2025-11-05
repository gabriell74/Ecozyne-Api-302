<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\TrashTransaction;
use App\Models\WasteBankSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteBank extends Model
{
    protected $table = 'waste_bank';

    protected $fillable = [
        'waste_bank_submission_id',
    ];

    public function wasteBankSubmission(): BelongsTo
    {
        return $this->belongsTo(WasteBankSubmission::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function trashTransaction(): HasMany
    {
        return $this->hasMany(TrashTransaction::class);
    }
}