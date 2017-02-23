<?php
namespace App\Http\Controllers;
use \Carbon\Carbon;

class ViewController extends Controller {

  function __construct() {
    // constructor
  }

  // show index view
  public function index() {
    $students = \App\Student::with('components')
      ->join('components', 'students.id', '=', 'components.student_id')
      ->select(\DB::raw('students.*, mc + tc + hw + bs + ks + ac as total'))
      ->orderBy('total', 'DESC')
      ->get();
    $last_updated = \App\DatabaseUtil::get_last_updated();
    $friendly_last_updated = Carbon::createFromTimestamp(strtotime($last_updated))->diffForHumans();

    return view('index')->with('students', $students)
      ->with('last_updated',$friendly_last_updated);;
  }

  // show detail view
  public function detail($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    $components = \App\Component::where('student_id', $id)->firstOrFail();
    $scores_arr = $this->putScoresIntoArray(\App\Student::with('scores')->where('id', $id)->first());
    $comments = \App\Comment::where('student_id', $id)->firstOrFail();
    $records = \App\Record::where('student_id', $id)
      ->leftJoin('achievements', 'records.achievement_id', '=', 'achievements.id')
      ->select(\DB::raw('records.id as rId, achievements.id as aId, points, title, max_points'))
      ->orderBy('aId')->get();

    return view('detail')->with('student', $student)
      ->with('components', $components)
      ->with('scores_arr', $scores_arr)
      ->with('comment', $comments->comment)
      ->with('records', $records);
  }

  // show edit student view
  public function editStudent($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    $scores_arr = $this->putScoresIntoArray(\App\Student::with('scores')->where('id', $id)->first());
    $sum = array_sum($scores_arr['MC']) + array_sum($scores_arr['TC']) + array_sum($scores_arr['HW'])
      + array_sum($scores_arr['BS']) + array_sum($scores_arr['KS'])  + array_sum($scores_arr['AC']);
    $comment = \App\Comment::where('student_id', $id)->first()->comment;

    return view('edit')->with('student', $student)
      ->with('scores_arr', $scores_arr)
      ->with('sum', $sum)
      ->with('comment', $comment);
  }

  // show create student view
  public function createStudent() {
    return view('create');
  }

  // show help view
  public function help() {
    return view('help');
  }

  // show login view
  public function login() {
    return view('login');
  }

  // show achievement view
  public function achievement() {
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
  
  public function progress() {
    return view('progress');
  }

  // process all the scores of 1 student and store in array
  private function putScoresIntoArray($student) {
    $scores_arr = array(
      'MC' => array(0,0,0,0,0,0,0,0,0),
      'TC' => array(0,0),
      'HW' => array(0,0,0,0,0,0,0,0,0,0),
      'BS' => array(0,0,0,0,0,0,0,0,0),
      'KS' => array(0,0,0,0,0,0,0,0,0,0,0,0),
      'AC' => array(0,0,0,0,0,0,0,0)
    );

    foreach ($student->scores as $scores) {
      $comp = $scores->component;
      $index = $scores->week - 1;
      $score = $scores->score;

      if ($score != NULL) {
        $scores_arr[$comp][$index] = (string) $score;
      } else {
        switch($comp) {
          case 'MC':
          case 'HW':
            $display = 'x.y';
            break;
          case 'TC':
            $display = 'xy.z';
            break;
          default:
            $display = 'x';
        }
        $scores_arr[$comp][$index] = $display;
      }
    }
    return $scores_arr;
  }

}