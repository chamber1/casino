<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $table = 'client_forgot_password';
    
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
