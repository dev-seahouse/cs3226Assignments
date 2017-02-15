<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    public function student() {
      return $this->belongsTo('App\Student');
    }
    
    public function component() {
      return $this->belongsTo('App\Component');
    }
}
