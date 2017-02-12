<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function component_type()
    {
        return $this->belongsTo('App\ComponentType');
    }

    public function component_name(){
        return $this->component_type()->name;
    }

    public function scores(){
      return $this->hasMany('App\Score');
    }

    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}
