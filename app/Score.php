<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    public function component(){
      return $this->belongTo('App\Component');
    }
}
