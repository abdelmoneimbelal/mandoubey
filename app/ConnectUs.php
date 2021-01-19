<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectUs extends Model
{

    protected $table = 'connect_us';
    public $timestamps = true;
    protected $fillable = array('type', 'content', 'image', 'client_id', 'delegate_id');

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function delegate()
    {
        return $this->belongsTo('App\Delegate');
    }

}