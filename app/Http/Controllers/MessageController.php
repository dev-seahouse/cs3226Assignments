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
    $messages = \App\Message::all();

    return view('message')
      ->with('messages', $messages);
  }

  public function editMessage(Request $request) {
    // validate user input
    $validator = Validator::make($request->all(), $this->getRules(), $this->getMessages());

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

  }

  public function getRules() {
    $rules = array(
      'message' => 'required|between:5,500'
    );

    return $rules;
  }

  public function getMessages() {
    $messages = array(
      'message.required' => 'Message cannot be blank',
      'message.between' => 'Message should be between :min - :max characters'
    );

    return $messages;
  }

}