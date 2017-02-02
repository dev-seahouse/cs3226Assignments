<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class StudentController extends Controller {
  
  // show index view
  public function index() {
    session()->flush();
    
    if (session('students') == null) {
      session()->put('students', $this->generateStudents());
    }
    
    return view('index')->with('students', json_encode(session('students')));
  } 
  
  // show detail view
  public function detail($id) { 
    return view('detail')->with('student', json_encode($this->getStudent($id)));
  }
  
  // show help view
  public function help() { 
    return view('help');
  }
  
  // show login view
  public function login() { 
    return view('login');
  }
  
  private function getStudent($id) {
    for($i = 0; $i < count(session('students')); $i++) {
      if (session('students')[$i]["ID"] == $id) {
        return session('students')[$i];
      }
    }
    
    return "Not found";
  }
  
  private function generateStudents() {
    $students = array();
    
    for ($i = 1; $i <= 50; $i++) {
      $flag = array("CHN", "IDN", "SGP", "VNM", "MYS");
      $gender = array("M", "F");
      $MC = rand(1,10);
      $TC = rand(1,10);
      $SPE = $MC + $TC;
      $HW = rand(1,10);
      $BS = rand(1,10);
      $KS = rand(1,10);
      $AC = rand(1,10);
      $DIL = $HW + $BS + $KS + $AC;
      $SUM = $SPE + $DIL;
      
      array_push($students , array(
        "ID" => $i,
        "FLAG" => $flag[array_rand($flag)],
        "GENDER" => $gender[array_rand($gender)],
        "NAME" => "Student ".$i,
        "NICK" => "Nick ".$i,
        "MC" => $MC,
        "TC" => $TC,
        "SPE" => $SPE,
        "HW" => $HW,
        "BS" => $BS,
        "KS" => $KS,
        "AC" => $AC,
        "DIL" => $DIL,
        "SUM" => $SUM
      ));
    }
    
    usort($students, function ($a, $b) {
      return $a["SUM"] < $b["SUM"];
    });
    
    return $students;
  }
}
?>