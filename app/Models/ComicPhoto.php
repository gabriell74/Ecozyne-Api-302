<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComicPhoto extends Model
{
    protected $table = 'comic_photo';

    protected $fillable = [
        'comic_id',
        'comic_page',
        'photo',
    ];

    public function comic(): BelongsTo
    {
        return $this->belongsTo(Comic::class);
    }
}
