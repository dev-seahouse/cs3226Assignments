<?php
namespace App\Http\Controllers;

class MessageController extends Controller {

  function __construct() {
    // constructor
  }
  
  public function studentView($id) {
    return view('message');
  }
  
  public function adminView() {
    return view('message');
  }
  
}