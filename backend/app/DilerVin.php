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
        'tcd_time',
        'tabno',
    ];

    public function diler()
    {
        return $this->belongsTo(Diler::class, 'dil_id', 'id');
    }
}
