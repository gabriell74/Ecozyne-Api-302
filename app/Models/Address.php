<?php

namespace App\Models;

use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $table = 'address';
    
    protected $fillable = [
        'kelurahan_id',
        'address',
        'postal_code',
    ];
}
