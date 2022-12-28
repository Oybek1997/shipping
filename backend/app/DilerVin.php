<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DilerVin extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'dil_id',
        'vin',
        'date_time',
        'tabno',
        'status',
    ];
}
