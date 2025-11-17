<?php

namespace App\Models;

use App\Models\ActivityRegistration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    protected $table = 'activity';
    
    protected $fillable = [
        'title',
        'description',
        'photo',
        'location',
        'current_quota',
        'quota',
        'registration_start_date',
        'registration_due_date',
        'start_date',
        'due_date',
    ];

    public function activityRegistration(): HasMany
    {
        return $this->hasMany(ActivityRegistration::class);
    }
}
