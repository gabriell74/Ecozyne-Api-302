<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'discussion_question';

    protected $fillable = [
        'id',
        'user_id',
        'question',
        'total_like',
    ];
}
