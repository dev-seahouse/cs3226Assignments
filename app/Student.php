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

    public function scores() {
      return $this->hasMany('App\Score');
    }

    public static function getRecordAndScore(){

    }
  
    public function getCompScores() {
      return \App\Score::where('student_id', $this->id)
                  ->selectRaw('SUM(score) as total')
                  ->groupBy('component_id')
                  ->get();
    }

     // For each student, retrieve comments AND records AND scores
    // return \App\Student::with('comment')->with('records')->with('scores')->get();

    // For each student, retrieve all achievements with description
    // return \App\Record::with(['student','achievement'])->get();

    // For each achievement, get the records. Able to list which student has the highest points
    // return \App\Achievement::with('records')->get();

    // For each student, retrieve all achievements with description
    // return \App\Record::with(['student','achievement'])->get();

    // For each student, retrieve all scores
    /*return \App\Score::with('component')
              ->join('components', 'components.id', '=', 'scores.component_id')
              ->get();*/
}
