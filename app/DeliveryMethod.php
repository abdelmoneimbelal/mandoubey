<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{

    protected $table = 'delivery_methods';
    public $timestamps = true;
    protected $fillable = array('name');

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function delegates()
    {
        return $this->belongsTo('App\DeliveryMethod');
    }

}