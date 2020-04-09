<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function Circular(){
        return $this->belongsTo('App\Circular');
    }

    public function User(){
        return $this->belongsTo('App\User');
    }

}
