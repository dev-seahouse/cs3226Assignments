<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;
class StudentController extends Controller {

  function __construct() {
    $this->filePath = '../database/students.txt';
  }

  public function testget() {
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

    //return \App\Student::all();
    return \App\Component::where('student_id', 50)->first();
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
    $scores_arr = $this->storeScoresIntoArray(\App\Student::with('scores')->where('id', $id)->first());
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

  // process all the scores of 1 student and store in array
  private function storeScoresIntoArray($student) {
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

  public function deleteStudent($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    \File::delete(base_path() . '/public/img/student/' . $student->profile_pic);
    $student->delete();
    return redirect()->route('index');
  }

  // show help view
  public function help() {
    return view('help');
  }

  // show login view
  public function login() {
    return view('login');
  }

  public function getStudentData($id) {
    $currentStudent = \App\Student::with('components')
      ->join('components', 'students.id', '=', 'components.student_id')
      ->where('student_id', $id)->firstOrFail();
    $topStudent = \App\Student::with('components')
      ->join('components', 'students.id', '=', 'components.student_id')
      ->select(\DB::raw('students.*, mc + tc + hw + bs + ks + ac as total'))
      ->orderBy('total', 'DESC')
      ->first();
    
    $data = array("currentStudent" => $currentStudent, "topStudent" => $topStudent);
    
    return response()->json($data);
  }

}
?>
