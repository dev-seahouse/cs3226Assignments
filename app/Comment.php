<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function student() {
      return $this->belongsTo('App\Student');
    }
}
