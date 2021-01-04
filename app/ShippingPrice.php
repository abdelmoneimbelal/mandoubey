<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingPrice extends Model 
{

    protected $table = 'shipping_price';
    public $timestamps = true;
    protected $fillable = array('lat', 'long', 'weight', 'count');

}