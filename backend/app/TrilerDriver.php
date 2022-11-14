<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrilerDriver extends Model
{
    
    public $timestamps = false;
    public function trilerInfo()
    {
        return $this->hasMany('App\TrilerDriver', 'id', 'triler_driver_id');
    }
}
