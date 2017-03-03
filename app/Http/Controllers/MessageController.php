<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller {

  function __construct() {
    // constructor
  }

  public function studentView($id) {
    $messages = \App\Message::where('student_id', $id)->get();

    return view('message')
      ->with('messages', $messages)
      ->with('id', $id);
  }

  public function adminView() {
    $messages = \App\Student::with('messages')
      ->join('messages', 'students.id', '=', 'messages.student_id')
      ->select(\DB::raw('students.name, messages.*'))
      ->orderBy('reply')
      ->get();

    return view('message')
      ->with('messages', $messages);
  }

  public function editMessage(Request $request) {
    // validate user input
    $rules = array(
      'message' => 'required|max:255'
    );

    $messages = array(
      'message.required' => 'Message cannot be blank',
      'message.max' => 'Message can only have max :max characters'
    );

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput();
    }

    \DB::transaction(function () use ($request) {
      // retrieve all inputs from form request
      $stud_id = $request->input('id');
      $message = $request->input('message');
      $msgCount = $request->input('messageCount');
      $student = \App\Student::where('id', $stud_id)->firstOrFail();

      // if msgCount == 0, create new Message
      if ($msgCount == 0) {
        $msg = new \App\Message;
        $msg->student()->associate($student);
        $msg->message = $message;
        $msg->save();
      }
      // else, update existing Message
      else {
        $msg = \App\Message::where('student_id', $stud_id)->firstOrFail();
        $msg->message = $message;
        $msg->reply = '';
        $msg->save();
      }
    });

    $feedback = 'You have successfully submitted your message.';
    \Session::flash('message', $feedback);
    return redirect()->route('studentMessages', ['id' => \Auth::user()->student_id]);

  }

  public function editReplies(Request $request) {
    // validate user input
    $msgCount = $request->input('messageCount');
    $validator = Validator::make($request->all(), $this->getRules($msgCount), $this->getMessages($msgCount));

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withInput();
    }

    \DB::transaction(function () use ($request) {
      $msgCount = $request->input('messageCount');
      for ($i = 1; $i <= $msgCount; $i++) {
        $message = \App\Message::where('id', $request->input('id'.$i))->firstOrFail();
        $message->reply = $request->input('reply'.$i);
        $message->save();
      }
    });

    $feedback = 'You have successfully submitted your replies.';
    \Session::flash('message', $feedback);
    return redirect()->route('adminMessages');

  }

  private function getRules($msgCount) {
    $rules = array();
    for ($i=1; $i<=$msgCount; $i++) {
      $rules['reply'.$i] = 'max:255';
    }

    return $rules;
  }

  private function getMessages($msgCount) {
    $messages = array();
    for ($i=1; $i<=$msgCount; $i++) {
      $messages['reply'.$i.'.max'] = 'Replies can only have max :max characters';
    }

    return $messages;
  }

}