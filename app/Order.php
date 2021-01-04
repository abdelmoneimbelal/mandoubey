<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('lat', 'lat2', 'long', 'long2', 'address', 'address2', 'phone', 'delivery_method_id', 'name', 'title', 'payment_method', 'type', 'section_id', 'weight', 'count', 'price', 'notes', 'shipping_price', 'image', 'client_id', 'delegate_id', 'pin_code', 'delivery_number', 'status', 'acceptable');

    public function clients()
    {
        return $this->belongsTo('App\Client');
    }

    public function notifications()
    {
        return $this->hasMany('App\Order');
    }

    public function deliveryMethod()
    {
        return $this->belongsTo('App\DeliveryMethod');
    }

    public function sections()
    {
        return $this->belongsTo('App\Section');
    }

    public function delegates()
    {
        return $this->belongsTo('App\Delegate');
    }

}