<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    public function User(){
        return $this->belongsTo('App\User');
    }

    public function circulars(){
        return $this->belongsToMany('App\Circular');
    }

    public function organizations(){
        return $this->belongsToMany('App\Organization')->withPivot('rating');
    }
}
