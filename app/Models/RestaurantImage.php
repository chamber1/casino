<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantImage extends Model
{
    protected $table = 'restaurant_images';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'restaurant_id','menu_image_URL'
    ];
    
    /**
     * Back Relationship with restaurant table.
     *
     */
    public function restaurant(){
        return $this->belongsTo('App\Models\Restaurant');
    }
}
