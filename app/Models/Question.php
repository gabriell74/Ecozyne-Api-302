<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $table = 'discussion_question';

    protected $fillable = [
        'id',
        'user_id',
        'question',
        'total_like',
    ];

    public function likes(): HasMany
{
    return $this->hasMany(Like::class);
}
}
