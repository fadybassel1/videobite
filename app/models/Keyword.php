<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
    protected $guarded = [];


    public function video()
    {
        return $this->belongsTo('App\models\Video');
    }
}
