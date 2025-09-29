<?php

namespace App\Models;

use App\Models\ActivityRegistration;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';
    
    protected $fillable = [
        'title',
        'description',
        'photo',
        'quota',
    ];

    public function activityRegistration(): HasMany
    {
        return $this->hasMany(ActivityRegistration::class);
    }
}
