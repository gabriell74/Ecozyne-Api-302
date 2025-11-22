<?php

namespace App\Models;

use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model
{
    protected $table = 'address';
    
    protected $fillable = [
        'kelurahan_id',
        'address',
        'postal_code',
    ];

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function community(): HasOne
    {
        return $this->hasOne(Community::class);
    }
}
