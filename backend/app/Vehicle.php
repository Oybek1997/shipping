<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'vin',
        'tabno',
        'status',
        'sector',
        'row',
        'tcd_date',
    ];
}
