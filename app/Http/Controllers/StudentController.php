<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;
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
    return \App\Score::with('student')
      ->join('students', 'students.id', '=', 'scores.student_id')
      ->select(\DB::raw('students.name, week, SUM(score) as progress'))
      ->groupBy('student_id', 'week')
      ->get();
  }

  public function deleteStudent($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    \File::delete(base_path() . '/public/img/student/' . $student->profile_pic);
    $student->delete();
    return redirect()->route('index');
  }

  public function editAllStudent(Request $request, $section) {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';

    $week = preg_replace('/[^0-9]/', '', $section);
    $component = preg_replace('/[0-9]+/', '', $section); //remove integer

    $studentCount = $request->input('studentCount');

    $sectionRule = null;
    switch ($component) {
      case "MC":
        $sectionRule = $mcRule;
        break;
      case "HW":
        $sectionRule = $hwRule;
        break;
      case "BS":
        $sectionRule = $bsRule;
        break;
      case "KS":
        $sectionRule = $ksRule;
        break;           
      default:
        $sectionRule = "error";
    }    
    $rules = array();

    for ($i = 1; $i <= $studentCount; $i++){

      $new_rule = array();
      if ($section == 'TC1') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if ($section == 'TC2') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if ($section == 'AC1' || $section == 'AC2') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if ($section == 'AC3' || $section == 'AC4') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^([0-3]|x)$/']);
      else if ($section == 'AC5' || $section == 'AC6' || $section == 'AC8')
        $new_rule = array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if ($section == 'AC7') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^([0-6]|x)$/']);
      else {
        $new_rule = array($section."_".$i => ['required', $sectionRule]);
      }
      $rules = array_merge($rules, $new_rule);
    }

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return back() 
        ->withErrors($validator)
        ->withInput();
    }

    // update scores
    for ($i = 1; $i <= $studentCount; $i++) {
      $student_id = $request->input($i);

      $score = \App\Score::where('student_id', $student_id)->where('component', $component)->where('week', $week)->first();
      $inputScore = $request->input($section.'_'.$i);
      if ($inputScore == 'x.y' || $inputScore == 'x' || $inputScore == 'xy.z') $inputScore = null;
      $score->score = $inputScore;
      $score->save();
    }
    
    // need to update components

    return redirect()->route('index');
  }

  public function editSection($section) {
    $component = preg_replace('/[0-9]+/', '', $section); //remove integer

    $week = preg_replace('/[^0-9]/', '', $section);

    $students = \App\Score::with('student')
      ->where('scores.week', $week)
      ->where('scores.component', $component)
      ->orderBy('student_id', 'ASC')
      ->get();

    return view('editSection')->with('section',$section)->with('students',$students)->with('component',$component)->with('week',$week);
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
      ->select(\DB::raw('students.name, week, SUM(score) as progress'))
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
      ->select(\DB::raw('students.name, week, SUM(score) as progress'))
      ->groupBy('student_id', 'week')
      ->get();

    $data = array("currentStudent" => $currentStudent, "topStudent" => $topStudent);

    return $data;
  }

}
?>
