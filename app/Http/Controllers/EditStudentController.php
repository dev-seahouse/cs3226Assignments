<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditStudentController extends Controller {

  function __construct() {
    // constructor
  }
  
  // update student
  public function edit(Request $request) {
    // validate user input
    $validator = Validator::make($request->all(), $this->getRules($request->input('id')), $this->getMessages());

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
	  $ext = pathinfo($oldProPic, PATHINFO_EXTENSION);
      $newProPic = $nick.'.'.$ext;
      \File::move(base_path().'/public/img/student/'.$oldProPic, base_path().'/public/img/student/'.$newProPic);
      $student->profile_pic = $newProPic;
      $student->name = $name;
      $student->kattis = $kattis;
      $student->save();
      // update individual scores
      $this->updateCompScores($id, 'MC', $mc_scores, 'x.y');
      $this->updateCompScores($id, 'TC', $tc_scores, 'xy.z');
      $this->updateCompScores($id, 'HW', $hw_scores, 'x.y');
      $this->updateCompScores($id, 'BS', $bs_scores, 'x');
      $this->updateCompScores($id, 'KS', $ks_scores, 'x');
      $this->updateCompScores($id, 'AC', $ac_scores, 'x');
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
      $this->updateRecords($id, $ac_scores, $student);
    });
    
    \Session::flash('message', 'You have successfully updated <strong>'.$request->input('name').'\'s</strong> details.');
    return redirect()->route('index');
  }

  private function updateRecords($id, $ac_scores, $student) {
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

  private function updateCompScores($id, $comp, $compScores, $xyz) {
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

  private function putFormValuesInArray($comp, $numOfComp, $request) {
    $arr = array();
    for($i = 1; $i <= $numOfComp; $i++) {
      $arr[$i] = $request->input($comp.$i);
    }

    return $arr;
  }

  private function getRules($id) {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/|unique:students'.($id ? ',id,'.$id : ''),
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

  private function getMessages() {
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