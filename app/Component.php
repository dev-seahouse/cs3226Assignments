<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function scores() {
      return $this->hasMany('App\Score');
    }
}
