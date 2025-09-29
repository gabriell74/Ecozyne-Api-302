<?php

namespace App\Models;

use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Model;

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
}
