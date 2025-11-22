<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';

    protected $fillable = [
        'id',
        'kecamatan_id',
        'kelurahan',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}