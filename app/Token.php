<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = array('client_id', 'delegate_id', 'type', 'token');

    public function clients()
    {
        return $this->belongsTo('App\Client');
    }

    public function delegates()
    {
        return $this->belongsTo('App\Delegate');
    }

}