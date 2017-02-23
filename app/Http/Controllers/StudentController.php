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
    return \App\Score::with('student')
      ->join('students', 'students.id', '=', 'scores.student_id')
      ->select(\DB::raw('students.name, week, SUM(score) as progress'))
      ->groupBy('student_id', 'week')
      ->get();
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

  // show edit view
  public function edit($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    $scores_arr = $this->storeScoresIntoArray(\App\Student::with('scores')->where('id', $id)->first());
    $sum = array_sum($scores_arr['MC']) + array_sum($scores_arr['TC']) + array_sum($scores_arr['HW'])
      + array_sum($scores_arr['BS']) + array_sum($scores_arr['KS'])  + array_sum($scores_arr['AC']);
    $comment = \App\Comment::where('student_id', $id)->first()->comment;

    return view('edit')->with('student', $student)
      ->with('scores_arr', $scores_arr)
      ->with('sum', $sum)
      ->with('comment', $comment);
  }
  public function editStudent(Request $request) {
    // validate user input
    $validator = Validator::make($request->all(), $this->getEditFormRules(), $this->getEditFormMessages());

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput();
    }

    \DB::transaction(function () use ($request) {
      // retrieve all inputs from form request
      $id = $request->input('id');
      $nick = $request->input('nick');
      $name = $request->input('name');
      $kattis = $request->input('kattis');
      $mc_scores = $this->putFormValuesInArray('MC', 9, $request);
      $tc_scores = $this->putFormValuesInArray('TC', 2, $request);
      $hw_scores = $this->putFormValuesInArray('HW', 10, $request);
      $bs_scores = $this->putFormValuesInArray('BS', 9, $request);
      $ks_scores = $this->putFormValuesInArray('KS', 12, $request);
      $ac_scores = $this->putFormValuesInArray('AC', 8, $request);
      $comments = $request->input('comments');

      // update student
      $student = \App\Student::find($id);
      $student->nick = $nick;
      // rename old profile pic
      $oldProPic = $student->profile_pic;
      $newProPic = $nick.'.png';
      \File::move(base_path().'/public/img/student/'.$oldProPic, base_path().'/public/img/student/'.$newProPic);
      $student->profile_pic = $newProPic;
      $student->name = $name;
      $student->kattis = $kattis;
      $student->save();
      // update individual scores
      $this->updateCompScoresOfStudent($id, 'MC', $mc_scores, 'x.y');
      $this->updateCompScoresOfStudent($id, 'TC', $tc_scores, 'xy.z');
      $this->updateCompScoresOfStudent($id, 'HW', $hw_scores, 'x.y');
      $this->updateCompScoresOfStudent($id, 'BS', $bs_scores, 'x');
      $this->updateCompScoresOfStudent($id, 'KS', $ks_scores, 'x');
      $this->updateCompScoresOfStudent($id, 'AC', $ac_scores, 'x');
      // update components sum
      $components = \App\Component::where('student_id', $id)->firstOrFail();
      $components->mc = array_sum($mc_scores);
      $components->tc = array_sum($tc_scores);
      $components->hw = array_sum($hw_scores);
      $components->bs = array_sum($bs_scores);
      $components->ks = array_sum($ks_scores);
      $components->ac = array_sum($ac_scores);
      $components->save();
      // update comment
      $comment = \App\Comment::where('student_id', $id)->firstOrFail();
      $comment->comment = $comments;
      $comment->save();
      // update records table
      $this->updateRecordsOfStudent($id, $ac_scores, $student);
    });

    return redirect()->route('index');
  }

  // Helper method for editStudent
  private function updateRecordsOfStudent($id, $ac_scores, $student) {
    $records = \App\Record::where('student_id', $id);
    $records->delete();
    for ($i = 1; $i <= 8; $i++) {
      if ($ac_scores[$i] != 'x') {
        $newRecord = new \App\Record;
        $achievement = \App\Achievement::find($i);
        $newRecord->student()->associate($student);
        $newRecord->achievement()->associate($achievement);
        $newRecord->points = $ac_scores[$i];
        $newRecord->save();
      }
    }

  }

  // Helper method for editStudent
  private function updateCompScoresOfStudent($id, $comp, $compScores, $xyz) {
    $scores = \App\Score::where('student_id', $id)->where('component', $comp)->orderBy('week')->get();
    foreach($scores as $score) {
      $newScore = $compScores[$score->week];
      if ($newScore == $xyz) {
        $newScore = NULL;
      }
      $singleScore = \App\Score::find($score->id);
      $singleScore->score = $newScore;
      $singleScore->save();
    }
  }

  // Helper method for editStudent
  private function putFormValuesInArray($comp, $numOfComp, $request) {
    $arr = array();
    for($i=1; $i<=$numOfComp; $i++) {
      $arr[$i] = $request->input($comp.$i);
    }

    return $arr;
  }

  public function deleteStudent($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    \File::delete(base_path() . '/public/img/student/' . $student->profile_pic);
    $student->delete();
    return redirect()->route('index');
  }

  public function editAllStudent(Request $request,$section) {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';

    $week=preg_replace("/[^0-9]/","",$section);
    $component = preg_replace('/[0-9]+/', '', $section); //remove interger
    
    $studentCount=$request->input('studentCount');

    $sectionRule=null;
    switch ($component) {
        case "MC":
            $sectionRule=$mcRule;
            break;
        case "HW":
            $sectionRule=$hwRule;
            break;
        case "BS":
            $sectionRule=$bsRule;
            break;
        case "KS":
            $sectionRule=$ksRule;
            break;           
        default:
            $sectionRule="error";
    }    
    $rules=array();



    for($i=1;$i<=$studentCount;$i++){

      $new_rule=array();
      if($section=='TC1')$new_rule=array($section."_".$i => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if($section=='TC2')$new_rule=array($section."_".$i => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if($section=='AC1' || $section=='AC2')$new_rule=array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if($section=='AC3' || $section=='AC4')$new_rule=array($section."_".$i => ['required', 'regex:/^([0-3]|x)$/']);
      else if($section=='AC5' || $section=='AC6' || $section=='AC8')$new_rule=array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if($section=='AC7')$new_rule=array($section."_".$i => ['required', 'regex:/^([0-6]|x)$/']);
      else{
        $new_rule=array($section."_".$i => ['required',$sectionRule]);
      }
      $rules=array_merge($rules, $new_rule);
    }
    $validator = Validator::make($request->all(), $rules);
    // print_r($rules);
    if ($validator->fails()) {
      return back() 
             ->withErrors($validator)
             ->withInput();
    }else{

      $students = \App\Student::with('components')
          ->join('components', 'students.id', '=', 'components.student_id')
          ->select('name',\DB::raw(' mc + tc + hw + bs + ks + ac as sum'),'students.id')
          ->orderBy('sum','DESC')
          ->get();
      $foreach_count=1;
      foreach($students as $student){
        $score=\App\Score::where('component','=',$component)->where('week','=',$week)->where('student_id','=',$student->id)->first();
        $inputScore=$request->input($section."_".$foreach_count);
        if($inputScore=='x.y' || $inputScore=='x' || $inputScore=='x.yz')$inputScore=null;
        $score->score= $inputScore;
        $score->save();
        $foreach_count=$foreach_count+1;
      }  
      return redirect()->route('index');       
    }      
  }

  public function editSection($section) {
    $component = preg_replace('/[0-9]+/', '', $section); //remove interger
    $week=preg_replace("/[^0-9]/","",$section);


    $studentCount=\App\Student::get()->count();
  
    $students = \App\Student::with('components')
              ->join('components', 'students.id', '=', 'components.student_id')
              ->select('name',\DB::raw(' mc + tc + hw + bs + ks + ac as sum'),'students.id')
              ->orderBy('sum','DESC')
              ->get();

    $sectionScore=array();
    $test=null;
    foreach($students as $student){
      $currentStudentSectionScore=\App\Score::where('component','=',$component)->where('week','=',$week)->where('student_id','=',$student->id)->select('score','component')->get();
      $test= $currentStudentSectionScore;
      array_push($sectionScore,$currentStudentSectionScore);
    }
    return view('editSection')->with('section',$section)->with('students',$students)->with('sectionScore',$sectionScore)->with('studentCount',$studentCount)->with('component',$component)->with('week',$week)->with('test',$test);

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

  private function getEditFormRules() {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      // MC rules
      'MC1' => ['required', $mcRule], 'MC2' => ['required', $mcRule], 'MC3' => ['required', $mcRule], 
      'MC4' => ['required', $mcRule], 'MC5' => ['required', $mcRule], 'MC6' => ['required', $mcRule],
      'MC7' => ['required', $mcRule], 'MC8' => ['required', $mcRule], 'MC9' => ['required', $mcRule],
      // TC rules
      'TC1' => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/'],
      'TC2' => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/'],
      // HW rules
      'HW1' => ['required', $hwRule], 'HW2' => ['required', $hwRule], 'HW3' => ['required', $hwRule], 
      'HW4' => ['required', $hwRule], 'HW5' => ['required', $hwRule], 'HW6' => ['required', $hwRule],
      'HW7' => ['required', $hwRule], 'HW8' => ['required', $hwRule], 'HW9' => ['required', $hwRule],
      'HW10' => ['required', $hwRule],
      // BS rules
      'BS1' => ['required', $bsRule], 'BS2' => ['required', $bsRule], 'BS3' => ['required', $bsRule],
      'BS4' => ['required', $bsRule], 'BS5' => ['required', $bsRule], 'BS6' => ['required', $bsRule],
      'BS7' => ['required', $bsRule], 'BS8' => ['required', $bsRule], 'BS9' => ['required', $bsRule],
      // KS rules
      'KS1' => ['required', $ksRule], 'KS2' => ['required', $ksRule], 'KS3' => ['required', $ksRule],
      'KS4' => ['required', $ksRule], 'KS5' => ['required', $ksRule], 'KS6' => ['required', $ksRule], 
      'KS7' => ['required', $ksRule], 'KS8' => ['required', $ksRule], 'KS9' => ['required', $ksRule],
      'KS10' => ['required', $ksRule], 'KS11' => ['required', $ksRule], 'KS12' => ['required', $ksRule],
      // AC rules
      'AC1' => ['required', 'regex:/^(0|1|x)$/'], 'AC2' => ['required', 'regex:/^(0|1|x)$/'],
      'AC3' => ['required', 'regex:/^([0-3]|x)$/'], 'AC4' => ['required', 'regex:/^([0-3]|x)$/'],
      'AC5' => ['required', 'regex:/^(0|1|x)$/'], 'AC6' => ['required', 'regex:/^(0|1|x)$/'],
      'AC7' => ['required', 'regex:/^([0-6]|x)$/'], 'AC8' => ['required', 'regex:/^(0|1|x)$/'],
    );

    return $rules;
  }

  private function getEditFormMessages() {
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
      'TC1.required' => 'Midterm Team Contest score is required, or set as "xy.z"',
      'TC1.regex' => 'Midterm Team Contest score should be between 0 to 10.5',
      'TC2.required' => 'Final Team Contest score is required, or set as "xy.z"',
      'TC2.regex' => 'Final Team Contest score should be between 0 to 13.5',
    );

    return $messages;
  }

}
?>
