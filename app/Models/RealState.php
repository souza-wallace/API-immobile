<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    protected $table = 'real_state';
    protected $fillable = [
        'title', 'description', 'content', 'price', 'bathrooms', 'properthy_area', 'total_properthy_area', 'slug'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
