<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circular extends Model
{
    public function Event(){
        return $this->belongsTo('App\Event');
    }

    public function Comment(){
        return $this->hasMany('App\Comment');
    }

    public function volunteers(){
        return $this->belongsToMany('App\Volunteer');
    }
}
