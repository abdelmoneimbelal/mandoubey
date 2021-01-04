<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{

    protected $table = 'clients';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'terms', 'password', 'pin_code', 'photo', 'id_front', 'id_back', 'status', 'type', 'ratings', 'api_token');

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function tokens()
    {
        return $this->hasMany('App\Token');
    }

    public function connectUs()
    {
        return $this->hasMany('App\ConnectUs');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    protected $hidden = [
        'password', 'api_token',
    ];
}