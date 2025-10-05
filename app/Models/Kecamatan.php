<?php

namespace App\Models;

use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'id',
        'kecamatan',
    ];

    public function kelurahan(): HasMany
    {
        return $this->hasMany(Kelurahan::class);
    }
}