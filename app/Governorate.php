<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{

    protected $table = 'governorates';
    public $timestamps = true;
    protected $fillable = array('governorate_name', 'price');

    public function cities()
    {
        return $this->hasMany('App\City');
    }

}