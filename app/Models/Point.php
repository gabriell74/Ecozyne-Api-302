<?php

namespace App\Models;

use App\Models\Community;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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