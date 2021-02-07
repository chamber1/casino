<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Model;

class ClientRegisterAttempt extends Model {
    
    protected $table = 'client_register_attempt';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number', 'code',
        'operation_hash','confirmed'
    ];
    
}
