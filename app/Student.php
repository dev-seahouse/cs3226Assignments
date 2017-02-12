<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
  // get all components belonging to student
  public function components(){
    return $this->hasMany('App\Component', 'student_id');
  }
}
