<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DilUser extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'dil_id',
        'user_id',
    ];

    public function diler()
    {
        return $this->belongsTo(Diler::class, 'dil_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
