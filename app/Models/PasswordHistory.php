<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordHistory extends Model
{
    use HasFactory;

    protected $table = 'user_password_history';

    protected $fillable = ['user_id', 'password_hash'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
