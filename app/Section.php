<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model 
{

    protected $table = 'sections';
    public $timestamps = true;
    protected $fillable = array('name');

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

}