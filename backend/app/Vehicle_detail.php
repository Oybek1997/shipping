<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle_detail extends Model
{
    use SoftDeletes;
    // protected $fillable = [
    //     'supplychain_employee_id',
    //     'quality_employee_id',
    //     'change',
    //     'color',
    //     'production_date',
    //     'vehicle_id',
    //     'detail_id',
    //     'delivery_date',

    // ];
    // public function details()
    // {
    //     return $this->hasMany('App\Detail', 'detail_id', 'id');
    // }
    // public function details()
    // {
    //     return $this->hasOne('App\Detail', 'id', 'detail_id');
    // }
    // public function vehicles()
    // {
    //     return $this->hasOne('App\Vehicle', 'id', 'vehicle_id');
    // }
    // public function vehicles()
    // {
    //     return $this->hasMany('App\Vehicle', 'vehicle_id', 'id');
    // }
}
