<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{

    protected $table = 'delivery_methods';
    public $timestamps = true;
    protected $fillable = ['name', 'image'];

//    protected $appends = ['image_path'];

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function delegates()
    {
        return $this->belongsTo('App\DeliveryMethod');
    }

//    public function getImagePathAttribute()
//    {
//        return asset('/uploads/delivery_methods/' . $this->image);
//
//    }//end of get image path
}