<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    public function student() {
      return $this->belongsTo('App\Student');
    }
    
    public function achievement() {
      return $this->belongsTo('App\Achievement');
    }
}
