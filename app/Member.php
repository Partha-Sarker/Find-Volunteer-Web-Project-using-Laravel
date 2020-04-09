<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function Organization(){
        return $this->belongsTo('App\Organization');
    }
}
