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
    $faker = \Faker\Factory::create();
    
    $students = array();
    
    for ($i = 1; $i <= 50; $i++) {
      $MC_COMPONENTS = $this->generateComponent();
      $TC_COMPONENTS = $this->generateComponent();
      $HW_COMPONENTS = $this->generateComponent();
      $BS_COMPONENTS = $this->generateComponent();
      $KS_COMPONENTS = $this->generateComponent();
      $AC_COMPONENTS = $this->generateComponent();
      
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
        "FLAG" => $faker->randomElement($array = array("CHN", "IDN", "SGP", "VNM", "MYS")),
        "GENDER" => $faker->randomElement($array = array("M", "F")),
        "NAME" => $faker->name,
        "NICK" => $faker->userName,
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
  
  private function generateComponent() {
    $faker = \Faker\Factory::create();
    $data = array();
    
    for ($i = 0; $i < 12; $i++) {
      array_push($data, $faker->randomElement($array = array (rand(0,4),'x')));
    }
    
    return $data;
  }
}
?>