<?php

namespace App\Models;

use App\Models\Answer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $table = 'discussion_question';

    protected $fillable = [
        'user_id',
        'question',
        'total_like',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function getQuestionTotalLikeAttribute()
    {
        return $this->likes()->count();
    }

    // public function getTotalCommentAttribute()
    // {
    //     return $this->comments()->count();
    // }
}
