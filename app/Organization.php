<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function User(){
        return $this->belongsTo('App\User');
    }

    public function Event(){
        return $this->hasMany('App\Event');
    }

    public function Member(){
        return $this->hasMany('App\Member');
    }

    public function volunteers(){
        return $this->belongsToMany('App\Volunteer')->withPivot('rating');
    }
}
