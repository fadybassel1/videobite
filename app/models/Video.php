<?php

namespace App\models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function summaries()
    {
        return $this->hasMany('App\models\Summary');
    }

    public function summary()
    {
        return $this->hasOne('App\models\Summary',"id","active_summary");
    }

    public function timestamps()
    {
        return $this->hasMany('App\models\Timestamp');
    }

    public function keywords()
    {
        return $this->hasMany('App\models\Keyword');
    }

    public function requests()
    {
        return $this->hasMany('App\models\Request');
    }
}
