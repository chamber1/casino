<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Model;



class UserRegisterAttempt extends Model {
    
    
    protected $table = 'user_login_attempt';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number', 'code', 'attempt_count',
    ];
    
    
    
}
