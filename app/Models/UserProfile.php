<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';
    protected $fillable = ['name', ' email', 'password', 'phone', 'social_networks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

