<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateStudentController extends Controller {

  function __construct() {
    // constructor
  }
  
  public function create(Request $request) {
    $validator = Validator::make($request->all(), $this->getRules(), $this->getMessages());

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
  
  private function getRules() {
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'profile_pic' => 'required|mimes:png,jpeg|max:1000',
	  'nationality'=>'required|in:CHN,SGP,IDN,VNM,JPN,AUS,GER,OTH'
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
      'profile_pic.required' => 'Profile picture is required',
      'profile_pic.mimes' => 'Profile picture should be a PNG or JPG file',
      'profile_pic.max' => 'Profile picture should be smaller than 1000 KB',
	  'nationality.required' => 'Nationality cannot be blank',
	  'nationality.in' => 'Nationality should be of either Singaporean, Indonesian, Chinese, Vietnamese, Japanese, Australian, German or Others',
	  
    );

    return $messages;
  }
  
}