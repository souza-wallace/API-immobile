<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'description', 'name', 'slug'
    ];
    

   /* public function realStates(){
        return $this->belongsToMany(RealState::class, 'real_state_categories');
    }*/

    public function realStates()
    {
        return $this->belongsToMany(RealState::class, 'real_state_categories', 'category_id', 'real_state_id');
    }
}
