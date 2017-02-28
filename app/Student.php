<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function comment() {
      return $this->hasOne('App\Comment');
    }

    public function records() {
      return $this->hasMany('App\Record');
    }

    public function components() {
      return $this->hasMany('App\Component');
    }
  
    public function scores() {
      return $this->hasMany('App\Score');
    }
  
    public function messages() {
      return $this->hasMany('App\Message');
    }
}
