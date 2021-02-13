<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Model;

class ClientRegister extends Model {
    
    protected $table = 'client_register';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number', 'code',
        'attempts','status'
    ];
    
}
