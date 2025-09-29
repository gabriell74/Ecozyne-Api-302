<?php

namespace App\Models;

use App\Models\Activity;
use App\Models\Community;
use Illuminate\Database\Eloquent\Model;

class ActivityRegistration extends Model
{
    protected $table = 'activity_registration';
    
    protected $fillable = [
        'activity_id',
        'community_id',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
