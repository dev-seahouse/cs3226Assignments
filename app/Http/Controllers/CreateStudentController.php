<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateStudentController extends Controller {

  function __construct() {
    // constructor
  }

  public function create(Requests\CreateStudentRequest $request) {

    //------ Extra Challenge B: Add Image --------------
    // filename set as {nick}.{ext}
    $profile_picName =  $request->input('nick') . '.' . $request->file('profile_pic')->getClientOriginalExtension();
	  $data = $request->input('fileURL');
	  list($type, $data) = explode(';', $data);
	  list(, $data)      = explode(',', $data);
	  $data = base64_decode($data);

	  file_put_contents((base_path().'/public/img/student/'.$profile_picName), $data);
    // save image file to public folder
    //$request->file('profile_pic')->move(base_path() . '/public/img/student/', $profile_picName);
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

    \Session::flash('message', 'You have successfully added <strong>'.$request->input('name').'</strong> to the rank list.');
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
}
