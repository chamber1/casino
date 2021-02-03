<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Client extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone', 'name','password'
    ];
    
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
      * Return a key value array, containing any custom claims to be added to the JWT.
      *
      * @return array
      */
     public function getJWTCustomClaims()
     {
         return [];
     }
}
