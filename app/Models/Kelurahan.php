<?php

namespace App\Models;

use App\Models\Kecamatan;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';

    protected $fillable = [
        'kecamatan_id',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}