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

  // show create view
  public function create() {
    return view('create');
  }

  public function createStudent(Request $request) {
    $validator = Validator::make($request->all(), $this->getCreateFormRules(), $this->getCreateFormMessages());

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput();
    }

    //------ Extra Challenge B: Add Image --------------
    // filename set as {nick}.{ext}
    $profile_picName =  $request->input('nick') . '.' . $request->file('profile_pic')->getClientOriginalExtension();
    // save image file to public folder
    $request->file('profile_pic')->move(base_path() . '/public/img/student/', $profile_picName);
    //------ END Extra Challenge B ---------------------------------------

    \DB::transaction(function ($request) {
      //Create student
      global $request;
      $student = new \App\Student;
      $student->nationality = $request->input('nationality');
      $student->gender = 'Male'; //Change to read gender from input
      $student->profile_pic = $request->input('nick') . '.' . $request->file('profile_pic')->getClientOriginalExtension();
      $student->name = $request->input('name');
      $student->nick = $request->input('nick');
      $student->kattis = $request->input('kattis');
      $student->save();

      //Create comment
      $comment = new \App\Comment;
      $comment->student()->associate($student);
      $comment->save();

      //Create components
      $component = new \App\Component;
      $component->student()->associate($student);
      $component->save();

      //Create scores
      $this->create_scores("MC", 9, $student);
      $this->create_scores("TC", 2, $student);
      $this->create_scores("HW", 10, $student);
      $this->create_scores("BS", 9, $student);
      $this->create_scores("KS", 12, $student);
      $this->create_scores("AC", 8, $student);
    });

    return redirect()->route('index');
  }

  private function create_scores($component_name, $num_scores_in_component, $student){
    for ($i = 1; $i <= $num_scores_in_component; $i++) {
      $score = new \App\Score;
      $score->component = $component_name;
      $score->week = $i;
      $score->score = 0;
      $score->student()->associate($student);
      $score->save();
    }
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
  
  private function getCreateFormRules() {
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'profile_pic' => 'required|mimes:png,jpeg|max:1000',
	  'nationality'=>'required|in:CHN,SGP,IDN,VNM,JPN,AUS,GER,OTH'
    );

    return $rules;
  }

  private function getCreateFormMessages() {
    $messages = array(
      'name.regex' => 'Full name should only contain letters and space',
      'name.required' => 'Full name cannot be blank',
      'name.between' => 'Full name should be between :min - :max characters',
      'nick.regex' => 'Nick name should only contain alphanumeric characters and no space',
      'nick.required' => 'Nick name cannot be blank',
      'nick.between' => 'Nick name should be between :min - :max characters',
      'kattis.regex' => 'Kattis account should only contain alphanumeric characters and no space',
      'kattis.required' => 'Kattis account cannot be blank',
      'kattis.between' => 'Kattis account should be between :min - :max characters',
      'profile_pic.required' => 'Profile picture is required',
      'profile_pic.mimes' => 'Profile picture should be a PNG or JPG file',
      'profile_pic.max' => 'Profile picture should be smaller than 1000 KB',
	  'nationality.required' => 'Nationality cannot be blank',
	  'nationality.in' => 'Nationality should be of either Singaporean, Indonesian, Chinese, Vietnamese, Japanese, Australian, German or Others',
	  
    );

    return $messages;
  }

}
?>
