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
  
    /*
    public function getCompScores() {
      return \App\Score::where('student_id', $this->id)
                  ->selectRaw('SUM(score) as total')
                  ->groupBy('component_id')
                  ->get();
    }
    */    
    
    public function getCompScores() {
      $mc = 0; $tc = 0; $hw = 0; $bs = 0; $ks = 0; $ac = 0;
      $scores = $this->scores;
      
      foreach ($scores as $scoreRow) {
        if ($scoreRow->component_id == 1)
          if ($scoreRow->score != null) $mc += $scoreRow->score;
        if ($scoreRow->component_id == 2)
          if ($scoreRow->score != null) $tc += $scoreRow->score;
        if ($scoreRow->component_id == 3)
          if ($scoreRow->score != null) $hw += $scoreRow->score;
        if ($scoreRow->component_id == 4)
          if ($scoreRow->score != null) $bs += $scoreRow->score;
        if ($scoreRow->component_id == 5)
          if ($scoreRow->score != null) $ks += $scoreRow->score;
        if ($scoreRow->component_id == 6)
          if ($scoreRow->score != null) $ac += $scoreRow->score;
      }
      
      $scoreArr = array(
        'mc' => $mc,
        'tc' => $tc,
        'hw' => $hw,
        'bs' => $bs,
        'ks' => $ks,
        'ac' => $ac,
        'spe' => $mc + $tc,
        'dil' => $hw + $bs + $ks + $ac,
        'sum' => $mc + $tc + $hw + $bs + $ks + $ac,
      );

      return $scoreArr;
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
