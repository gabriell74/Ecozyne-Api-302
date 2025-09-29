<?php

namespace App\Models;

use App\Models\Community;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'point';

    protected $fillable = [
        'community_id',
        'point',
        'expired_point',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}