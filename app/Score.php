<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    public function component(){
      return $this->hasOne('App\Component');
    }

    public function student(){
      return $this->belongTo('App\Student');
    }
}
