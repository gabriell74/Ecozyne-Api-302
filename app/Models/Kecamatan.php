<?php

namespace App\Models;

use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'kecamatan',
    ];

    public function kelurahan(): HasMany
    {
        return $this->hasMany(Kelurahan::class);
    }
}