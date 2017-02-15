<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    public function records() {
      return $this->hasMany('App\Record');
    }
}
