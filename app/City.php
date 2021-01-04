<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name', 'governorates', 'governrate_id');

    protected $primaryKey = 'governorate_id';

    public function governorates()
    {
        return $this->belongsTo('App\Governorate', 'governrate_id');
    }

}