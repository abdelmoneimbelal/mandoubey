<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'content', 'order_id', 'delegate_id', 'client_id');

    public function orders()
    {
        return $this->belongsTo('App\Order');
    }

    public function clients()
    {
        return $this->belongsTo('App\Client');
    }

    public function delegates()
    {
        return $this->belongsTo('App\Delegate');
    }

}