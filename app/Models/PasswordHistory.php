<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    use HasFactory;

    protected $table = 'user_password_history';

    protected $fillable = ['user,id', 'password_hash'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
