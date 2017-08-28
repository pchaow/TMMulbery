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

    protected $casts = [
        'map' => 'array',
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'map', 'password', 'identity', 'contact_number', 'address', 'postal_code', 'province_id', 'amphure_id', 'district_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function amphure()
    {
        return $this->belongsTo(Amphure::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function plants()
    {
        return $this->hasMany(Plant::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sellOrders()
    {
        return $this->hasMany(Order::class)->where('type', '=', 'sell');

    }

    public function buyOrders()
    {
        return $this->hasMany(Order::class)->where('type', '=', 'buy');
    }


    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
}
