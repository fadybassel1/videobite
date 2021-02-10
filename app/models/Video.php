<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function summary()
    {
        return $this->hasMany('App\models\Summary');
    }

    public function timestamps()
    {
        return $this->hasMany('App\models\Timestamp');
    }
}
