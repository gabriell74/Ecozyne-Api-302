<?php

namespace App\Models;

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

    protected $appends = ['total_like'/**'total_comment'*/, 'is_liked'];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

    public function getTotalLikeAttribute()
    {
        return $this->likes()->count();
    }

    // public function getTotalCommentAttribute()
    // {
    //     return $this->comments()->count();
    // }

    public function getIsLikedAttribute()
    {
        $user = Auth::user();
        if (!$user) return false;

        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
