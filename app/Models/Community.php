<?php

namespace App\Models;

use App\Models\User;
use App\Models\Point;
use App\Models\Address;
use App\Models\Exchange;
use App\Models\WasteBankSubmission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Community extends Model
{
    protected $table = 'community';

    protected $fillable = [
        'user_id',
        'address_id',
        'photo',
        'phone_number',
        'name',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function exchanges(): HasMany
    {
        return $this->hasMany(Exchange::class);
    }

    public function point(): HasOne
    {
        return $this->hasOne(Point::class);
    }

    public function wasteBankSubmission(): HasOne
    {
        return $this->hasOne(WasteBankSubmission::class);
    }
}
