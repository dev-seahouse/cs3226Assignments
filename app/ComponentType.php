<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
  public function components(){
     return $this->hasMany("App\Component", "component_t_id");
  }
}
