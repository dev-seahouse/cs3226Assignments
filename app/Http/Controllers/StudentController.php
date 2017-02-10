<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller {
  
  function __construct() { 
    $this->filePath = '../database/students.txt';
  } 
  
  // show index view
  public function index() {
    // $this->generateStudents());
    
    $students = $this->getStudentsFromDatabase();
    
    usort($students, function ($a, $b) {
      return $a["SUM"] < $b["SUM"];
    });
    
    return view('index')->with('students', json_encode($students));
  }

  // show detail view
  public function detail($id) {
    $student = $this->getStudent($id);
    
    if ($student == -1) {
      return view('error')->with('message', "The selected student does not exist!");
    } else {
      return view('detail')->with('student', json_encode($student));
    }
  }
  
  // show create view
  public function create() {
    return view('create');
  }
  
  public function createStudent(Request $request) {
    /*
    - The full name, nick name, and Kattis field should not be blank.
    - They must also have at least 5 characters and at most 30 characters. 
    - The Flag/Nationality Drop-Down List has to be selected. 
    - Display appropriate error messages if the data is not 
      validated properly upon submission (clicking the 'Create' button). 
    - The screenshot below is a simple way of displaying all error messages 
      at the top of the form. It is more user friendly to highlight fields 
      with error(s) and display an error message near its relevant field 
      and you are encouraged to do so.
    */
    $validator = Validator::make($request->all(), [
      'name' => 'required|min:5|max:30',
    ]);
    
    if ($validator->fails()) {
      return back()
             ->withErrors($validator)
             ->withInput();
    }
    
    $nick = $request->input('nick');
    $name = $request->input('name');
    $gender = $request->input('gender');
    $kattis = $request->input('kattis');
    $nationality = $request->input('nationality');

    $students = $this->getStudentsFromDatabase();
    usort($students, function ($a, $b) {
      return $a["ID"] > $b["ID"];
    });
    
    array_push($students , array(
        "ID" => end($students)['ID'] + 1,
        "FLAG" => $nationality,
        "GENDER" => $gender,
        "NAME" => $name,
        "NICK" => $nick,
        "KATTIS" => $kattis,
        "MC" => 0,
        "MC_COMPONENTS" => array(0,0,0,0,0,0,0,0,0,0,0,0),
        "TC" => 0,
        "TC_COMPONENTS" => array(0,0,0,0,0,0,0,0,0,0,0,0),
        "SPE" => 0,
        "HW" => 0,
        "HW_COMPONENTS" => array(0,0,0,0,0,0,0,0,0,0,0,0),
        "BS" => 0,
        "BS_COMPONENTS" => array(0,0,0,0,0,0,0,0,0,0,0,0),
        "KS" => 0,
        "KS_COMPONENTS" => array(0,0,0,0,0,0,0,0,0,0,0,0),
        "AC" => 0,
        "AC_COMPONENTS" => array(0,0,0,0,0,0,0,0,0,0,0,0),
        "DIL" => 0,
        "SUM" => 0
      ));
    
    $this->saveStudentsToDatabase($students);
    
    return redirect()->route('index');
  }
  
  // show edit view
  public function edit($id) {
    $student = $this->getStudent($id);
    
    if ($student == -1) {
      return view('error')->with('message', "The selected student does not exist!");
    } else {
      return view('edit')->with('student', json_encode($student));
    }
  }
  
  public function editStudent(Request $request) {
    /*
    - The full name, nick name, and Kattis field should not be blank.
    - They must also have at least 5 characters and at most 30 characters. 
    - The Flag/Nationality Drop-Down List has to be selected. 
    - Display appropriate error messages if the data is not 
      validated properly upon submission (clicking the 'Create' button). 
    - The screenshot below is a simple way of displaying all error messages 
      at the top of the form. It is more user friendly to highlight fields 
      with error(s) and display an error message near its relevant field 
      and you are encouraged to do so.
    */
    $validator = Validator::make($request->all(), [
      'name' => 'required|min:5|max:30|regex:/^[A-Za-z ]+$/',
      'mc_components' => ['regex:/^((([0-3]\.(0|5)|4\.0)|(x\.y)),){8}(([0-3]\.(0|5)|4\.0)|(x.y))$/'],
      'tc_components' => ['regex:/^(([0-9]|10)\.(0|5)|(xy\.z)),(([0-9]|1[0-3])\.(0|5)|(xy.z))$/'],
      'hw_components' => ['regex:/^(([0-1]\.(0|5)|(x.y)),){9}([0-1]\.(0|5)|(x\.y))$/'],
      'bs_components' => ['regex:/^((0|1|x),){8}((0|1|x))$/'],
      'ks_components' => ['regex:/^((0|1|x),){11}((0|1|x))$/'],
      'ac_components' => ['regex:/^((0|1|x),){2}(([0-3]|x),){2}((0|1|x),){3}((0|1|x))$/']
    ]);
    
    if ($validator->fails()) {
      return back()
             ->withErrors($validator)
             ->withInput();
    }
    
    $id = $request->input('id');
    $nick = $request->input('nick');
    $name = $request->input('name');
    $kattis = $request->input('kattis');
    $mc_components = explode(',', $request->input('mc_components'));
    $tc_components = explode(',', $request->input('tc_components'));
    $hw_components = explode(',', $request->input('hw_components'));
    $bs_components = explode(',', $request->input('bs_components'));
    $ks_components = explode(',', $request->input('ks_components'));
    $ac_components = explode(',', $request->input('ac_components'));
    
    $spe = array_sum($mc_components) + array_sum($tc_components);
    $dil = array_sum($hw_components) + array_sum($bs_components) + array_sum($ks_components) + array_sum($ac_components);
    
    $students = $this->getStudentsFromDatabase();
      
    foreach ($students as &$student) { //update by reference
      if ($student['ID'] == $id) {
        $student['NAME'] = $name;
        $student['NICK'] = $nick;
        $student['KATTIS'] = $kattis;
        $student['MC'] = array_sum($mc_components);
        $student['MC_COMPONENTS'] = $mc_components;
        $student['TC'] = array_sum($tc_components);
        $student['TC_COMPONENTS'] = $tc_components;
        $student['SPE'] = $spe;
        $student['HW'] = array_sum($hw_components);
        $student['HW_COMPONENTS'] = $hw_components;
        $student['BS'] = array_sum($bs_components);
        $student['BS_COMPONENTS'] = $bs_components;
        $student['KS'] = array_sum($ks_components);
        $student['KS_COMPONENTS'] = $ks_components;
        $student['AC'] = array_sum($ac_components);
        $student['AC_COMPONENTS'] = $ac_components;
        $student['DIL'] = $dil;
        $student['SUM'] = $spe + $dil;
      }
    }
    
    $this->saveStudentsToDatabase($students);
    
    return redirect()->route('index');
  }
  
  public function deleteStudent($id) {
    $students = $this->getStudentsFromDatabase();
    for ($i = 0; $i < count($students); $i++) {
      if ($students[$i]['ID'] == $id) {
        array_splice($students, $i, 1);
      }
    }
    $this->saveStudentsToDatabase($students);
    
    return redirect()->route('index');
  }

  // show help view
  public function help() {
    return view('help');
  }

  // show login view
  public function login() {
    return view('login');
  }

  public function getStudentData($id){
    $currentStudent = $this->getStudent($id);
    $topStudent = $this->getTopStudent();
    $data = array("currentStudent" => $currentStudent, "topStudent" => $topStudent);
    
    return response()->json($data);
  }

  private function getStudent($id) {
    $students = $this->getStudentsFromDatabase();
    for ($i = 0; $i < count($students); $i++) {
      if ($students[$i]['ID'] == $id) {
        return $students[$i];
      }
    }
    return -1; //error
  }
  
  private function getTopStudent() {
    $students = $this->getStudentsFromDatabase();
    return $students[0];
  }
  
  private function saveStudentsToDatabase($students) {
    $serializedData = serialize($students);
    file_put_contents($this->filePath, $serializedData);
  }
  
  private function getStudentsFromDatabase() {
    $recoveredData = file_get_contents($this->filePath);
    return unserialize($recoveredData);
  }
  
  // Faker
  private function generateStudents() {
    $faker = \Faker\Factory::create();

    $students = array();

    for ($i = 1; $i <= 50; $i++) {
      $nick = $faker->userName;
      
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
        "NICK" => $nick,
        "KATTIS" => $nick,
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
      return $a["ID"] > $b["ID"];
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
