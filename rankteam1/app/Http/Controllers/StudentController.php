<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class StudentController extends Controller {
  // show index view
  public function index() { 
    return view('index'); 
  } 
  
  // show detail view
  public function detail($id) { 
    return view('detail')->with('id'); 
  } 
}
?> // this ending line is optional