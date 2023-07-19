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

    /*public function categories(){
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }*/

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories', 'real_state_id', 'category_id');
    }
}
