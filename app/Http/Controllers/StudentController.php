<?php
namespace App\Http\Controllers;

class StudentController extends Controller {

  function __construct() {
    // constructor
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
    return \Auth::user()->role;
  }

  public function deleteStudent($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    $name = $student->name;
    \File::delete(base_path() . '/public/img/student/' . $student->profile_pic);
    $student->delete();
    \Session::flash('message', 'You have successfully deleted <strong>'.$name.'</strong> from the rank list.');
    return redirect()->route('index');
  }

  public function getStudentData($id) {
    $currentStudent = \App\Student::with('components')
      ->join('components', 'students.id', '=', 'components.student_id')
      ->where('student_id', $id)->firstOrFail();
    $topStudent = \App\Student::with('components')
      ->join('components', 'students.id', '=', 'components.student_id')
      ->select(\DB::raw('students.*, components.*, mc + tc + hw + bs + ks + ac as total'))
      ->orderBy('total', 'DESC')
      ->first();

    $data = array("currentStudent" => $currentStudent, "topStudent" => $topStudent);
    return $data;
  }

  public function getProgressData() {
    $nicks = \App\Student::all()->pluck('nick');
    $progressData = \App\Score::with('student')
      ->join('students', 'students.id', '=', 'scores.student_id')
      ->select(\DB::raw('students.nick, week, SUM(score) as progress'))
      ->groupBy('student_id', 'week')
      ->get();

    $data = array("nicks" => $nicks, "progressData" => $progressData);
    return $data;
  }

  public function getProgressDataById($id) {
    $currentStudent = \App\Score::with('student')
      ->where('student_id', $id)
      ->join('students', 'students.id', '=', 'scores.student_id')
      ->select(\DB::raw('students.nick, week, SUM(score) as progress'))
      ->groupBy('student_id', 'week')
      ->get();
    
    $topStudentId = \App\Student::with('components')
      ->join('components', 'students.id', '=', 'components.student_id')
      ->select(\DB::raw('students.*, mc + tc + hw + bs + ks + ac as total'))
      ->orderBy('total', 'DESC')
      ->first()->id;

    $topStudent = \App\Score::with('student')
      ->where('student_id', $topStudentId)
      ->join('students', 'students.id', '=', 'scores.student_id')
      ->select(\DB::raw('students.nick, week, SUM(score) as progress'))
      ->groupBy('student_id', 'week')
      ->get();

    $data = array("currentStudent" => $currentStudent, "topStudent" => $topStudent);
    return $data;
  }
  
}
?>
