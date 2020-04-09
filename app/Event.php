<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function Organization(){
        return $this->belongsTo('App\Organization');
    }

    public function Circular(){
        return $this->hasMany('App\Circular');
    }

    public function EventPhoto(){
        return $this->hasMany('App\EventPhoto');
    }
}
