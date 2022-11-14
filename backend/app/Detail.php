<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail extends Model
{
    use SoftDeletes;
    // protected $fillable = [
    //     'part',
    //     'part_name',
    //     'suplier',
    //     'source',
    //     'yetkazuvchi_employee_id',

    // ];
    public function masulemp()
    {
        return $this->hasOne('App\User', 'id', 'yetkazuvchi_employee_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'detail_id', 'id');
    }
}
