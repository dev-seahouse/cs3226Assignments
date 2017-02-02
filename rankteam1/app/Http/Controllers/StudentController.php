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
    return view('detail')->with('student', json_encode($this->getStudent($id)))->with('top_student', json_encode(session('students')[0]));
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
      
      $MC_COMPONENTS = array(
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4),
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4)
      );
      
      $TC_COMPONENTS = array(
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4),
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4)
      );
      
      $HW_COMPONENTS = array(
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4),
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4)
      );
      
      $BS_COMPONENTS = array(
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4),
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4)
      );
      
      $KS_COMPONENTS = array(
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4),
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4)
      );
      
      $AC_COMPONENTS = array(
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4),
        rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4), rand(0,4)
      );
      
      $MC = array_sum($MC_COMPONENTS);
      $TC = array_sum($TC_COMPONENTS);
      $SPE = $MC + $TC;
      $HW = array_sum($HW_COMPONENTS);
      $BS = array_sum($BS_COMPONENTS);
      $KS = array_sum($KS_COMPONENTS);
      $AC = array_sum($AC_COMPONENTS);
      $DIL = $HW + $BS + $KS + $AC;
      $SUM = $SPE + $DIL;
      
      array_push($students , array(
        "ID" => $i,
        "FLAG" => $flag[array_rand($flag)],
        "GENDER" => $gender[array_rand($gender)],
        "NAME" => "Student ".$i,
        "NICK" => "Nick ".$i,
        "MC" => $MC,
        "MC_COMPONENTS" => $MC_COMPONENTS,
        "TC" => $TC,
        "TC_COMPONENTS" => $TC_COMPONENTS,
        "SPE" => $SPE,
        "HW" => $HW,
        "HW_COMPONENTS" => $HW_COMPONENTS,
        "BS" => $BS,
        "BS_COMPONENTS" => $BS_COMPONENTS,
        "KS" => $KS,
        "KS_COMPONENTS" => $KS_COMPONENTS,
        "AC" => $AC,
        "AC_COMPONENTS" => $AC_COMPONENTS,
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