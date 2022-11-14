<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    // use SoftDeletes;
    protected $fillable = [
        'models',
        'pono',
        'vin',
        'ga_seq',
        'clr',
        'levl',
        'partnum',
        'partname',

    ];
}
