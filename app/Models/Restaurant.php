<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table = 'restaurant';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'main_image_URL'
    ];
    
    /*
    protected $casts = [
        'images' => 'array',
    ];*/
    
    /**
     * Relationship with images table.
     *
     */
    public function images(){
        return $this->hasMany('App\Models\RestaurantImage');
    }
}
