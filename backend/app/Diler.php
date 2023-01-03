<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diler extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function dilervins()
    {
        return $this->hasOne('App\DilerVin', 'dil_id', 'dil_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
