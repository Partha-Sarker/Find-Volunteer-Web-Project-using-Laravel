<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPhoto extends Model
{
    public function Event(){
        return $this->belongsTo('App\Event');
    }
}
