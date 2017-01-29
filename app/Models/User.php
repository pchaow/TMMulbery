<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'identity', 'contact_number', 'address', 'postal_code', 'province_id', 'amphure_id', 'district_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

//    public function setIdentityAttribute($value)
//    {
//        if (empty($value)) { // will check for empty string, null values, see php.net about it
//            $this->attributes['identity'] = NULL;
//        } else {
//            $this->attributes['identity'] = $value;
//        }
//    }
}
