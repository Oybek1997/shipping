<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public function details()
    {
        return $this->hasOne('App\Detail', 'id', 'detail_id');
    }
    public function vehicles()
    {
        return $this->hasOne('App\Vehicle', 'id', 'vehicle_id');
    }
    public function sifatemp()
    {
        return $this->hasOne('App\User', 'id', 'sifat_employee_id');
    }
    public function taminotemp()
    {
        return $this->hasOne('App\User', 'id', 'taminot_employee_id');
    }
}
