<?php
namespace App\Http\Controllers;

class AchievementController extends Controller {

  function __construct() {
    // constructor
  }
 
  // show achievement view
  public function view() {
    $records = \App\Record::leftJoin('achievements', 'records.achievement_id', '=', 'achievements.id')
      ->rightJoin('students', 'records.student_id', '=', 'students.id')
      ->select(\DB::raw('records.id as rId, achievements.id as aId, students.id as sId, students.name, title, points'))
      ->orderBy('aId')
      ->orderBy('students.name')->get();
    $achievements = \App\Achievement::select(\DB::raw('id, title, max_points'))->get();
    
    return view('achievement')
      ->with('records', $records)
      ->with('achievements', $achievements);
  }
  
}