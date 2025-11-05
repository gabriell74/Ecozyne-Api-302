<?php

namespace App\Models;

use App\Models\ComicPhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comic extends Model
{
    protected $table = 'comic';

    protected $fillable = [
        'comic_title',
        'cover_photo',
    ];

    public function comicPhotos(): HasMany
    {
        return $this->hasMany(ComicPhoto::class);
    }
}
