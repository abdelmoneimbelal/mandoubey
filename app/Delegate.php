<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Delegate extends Authenticatable
{

    protected $table = 'delegates';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'whatsapp', 'phone', 'password', 'type', 'governorate_id', 'id_front', 'id_back', 'photo', 'status', 'delivery_method_id', 'api_token', 'terms');

    public function governorate()
    {
        return $this->belongsTo('App\Governorate');
    }

    public function deliveryMethod()
    {
        return $this->belongsTo('App\DeliveryMethod');
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

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    protected $hidden = [
        'password', 'api_token',
    ];
}