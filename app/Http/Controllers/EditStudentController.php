<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EditStudentRequest;

class EditStudentController extends Controller {

  function __construct() {
    // constructor
  }

  // update student
  public function edit(EditStudentRequest $request) {
    // validate user input

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

}
