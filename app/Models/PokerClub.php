<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokerClub extends Model
{
    protected $table = 'poker_club';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'icon','by_in',
        'stack','levels'
    ];
}
