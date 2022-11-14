<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public function details()
    {
        return $this->belongsToMany(Detail::class, 'orders', 'vehicle_id', 'detail_id');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'vehicle_id', 'id');
    }
    public function trilerInfo()
    {
        return $this->hasMany('App\TrilerDriver', 'id', 'triler_driver_id');
    }
    public function warehouse()
    {
        return $this->hasOne('App\Warehouse', 'id', 'warehouse_id');
    }
    public function trimby()
    {
        return $this->hasOne('App\User', 'id', 'trim_by');
    }
    public function okby()
    {
        return $this->hasOne('App\User', 'id', 'ok_by');
    }
    public function printby()
    {
        return $this->hasOne('App\User', 'id', 'print_by');
    }
    public function sendby()
    {
        return $this->hasOne('App\User', 'id', 'send_by');
    }
    public function warehouseby()
    {
        return $this->hasOne('App\User', 'id', 'warehouse_by');
    }
    public function receiveby()
    {
        return $this->hasOne('App\User', 'id', 'receive_by');
    }
    public function finishby()
    {
        return $this->hasOne('App\User', 'id', 'finish_by');
    }
}
