<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    
    protected $guarded = [];


    public function video()
    {
        return $this->belongsTo('App\models\Video');
    }

    public function summary()
    {
        return $this->belongsTo('App\models\Video');
    }
}
