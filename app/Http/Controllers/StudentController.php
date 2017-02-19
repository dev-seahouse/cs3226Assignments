<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller {

  function __construct() {
    $this->filePath = '../database/students.txt';
  }

  public function testget() {
    // goal : to be able to do this: e.g.
      /*
       * @foreach ($students as $student)
            <tr>
                <td>$student->name</td>
                <td>$student->profile_pic</td>
                ......
                @foreach ($student->components() as $component)
                    <td>$component->getComponentSum()<td> // each component model have getComponentSumMethod
                ......
                $student->getDil() // getDil simply retrieve the component_sum fields from the components linked to student.
                $student->getSPE()
                $student->getBLABLA()
                $student->getSum() // simply a 1-5 inside student model that calls getSum() method inside each component linked to this student
            </tr>
          @endforeach
       *  then use javascript table sort to sort according to score sum
       *  $student model also provide methods for us to easily access data from other places. e.g $student->getAchievements()
       *  $student->getComponentScores($componentName || $componentID) allow us to retrieve array of scores for that component
       *  This can be done alternative through component model vis static method Component::getScoresForComponent($component_id || $component_name);
       */
    // For each student, retrieve comments AND records AND scores
    // return \App\Student::with('comment')->with('records')->with('scores')->get();

    // For each student, retrieve all achievements with description
    // return \App\Record::with(['student','achievement'])->get();

    // For each achievement, get the records. Able to list which student has the highest points
    // return \App\Achievement::with('records')->get();

    // For each student, retrieve all achievements with description
    // return \App\Record::with(['student','achievement'])->get();

    // For each student, retrieve all scores
    /*return \App\Score::with('component')
              ->join('components', 'components.id', '=', 'scores.component_id')
              ->get();*/

    //return \App\Student::all();

//    $students = \App\Student::all();
//
//    foreach ($students as $student) {
//      $student->total = $student->getCompScores();
//    }
//
//    return $students;
    return \App\Student::with('scores')->where('id', 56)->first();

  }

  // show index view
  public function index() {
    $studentsOld = $this->getStudentsFromDatabase();

    usort($studentsOld, function ($a, $b) {
      return $a["SUM"] < $b["SUM"];
    });

    /*
    //----------- Recode Lab 2 JS to PHP -----------------
    $maxArray = array(0,0,0,0,0,0,0,0,0);
    $sum = array();
    foreach($studentsOld as $student) {
      $maxArray[0] = max($maxArray[0], $student['MC']);
      $maxArray[1] = max($maxArray[1], $student['TC']);
      $maxArray[2] = max($maxArray[2], $student['SPE']);
      $maxArray[3] = max($maxArray[3], $student['HW']);
      $maxArray[4] = max($maxArray[4], $student['BS']);
      $maxArray[5] = max($maxArray[5], $student['KS']);
      $maxArray[6] = max($maxArray[6], $student['AC']);
      $maxArray[7] = max($maxArray[7], $student['DIL']);
      $maxArray[8] = max($maxArray[8], $student['SUM']);
      array_push($sum, $student['SUM']);
    }

    // this works on the precondition that there is at least 4 students and 4 different values of sum
    $sum = array_unique($sum);
    $first = $sum[0];
    array_splice($sum, 0, 1);
    $second = $sum[0];
    array_splice($sum, 0, 1);
    $third = $sum[0];
    array_splice($sum, 0, 1);
    $last = min($sum);
    */

    $students = \App\Student::with('components')
                  ->join('components', 'students.id', '=', 'components.student_id')
                  ->select(\DB::raw('students.*, mc + tc + hw + bs + ks + ac as total'))
                  ->orderBy('total', 'DESC')
                  ->get();

    return view('index')->with('studentsOld', json_encode($studentsOld))
                        ->with('students', $students);
                        //->with('maxArray', $maxArray)
                        //->with('first', $first)->with('second', $second)->with('third', $third)->with('last',$last);
  }

  // show detail view
  public function detail($id) {
    $student = \App\Student::where('id', $id)->first();
    $scores_arr = $this->storeScoresIntoArray(\App\Student::with('scores')->where('id', $id)->first());

    if ($student == null) {
      return view('error')->with('message', "The selected student does not exist!");
    } else {
      return view('detail')->with('student', $student)
                           ->with('scores_arr', $scores_arr);
    }
  }

  // process all the scores of 1 student and store in array
  private function storeScoresIntoArray($student) {
    $scores_arr = array(
      'MC' => array(0,0,0,0,0,0,0,0,0),
      'TC' => array(0,0),
      'HW' => array(0,0,0,0,0,0,0,0,0,0),
      'BS' => array(0,0,0,0,0,0,0,0,0),
      'KS' => array(0,0,0,0,0,0,0,0,0,0,0,0),
      'AC' => array(0,0,0,0,0,0,0,0)
    );

    foreach ($student->scores as $scores) {
      $comp = $scores->component;
      $index = $scores->week - 1;
      $score = $scores->score;

      if ($score != NULL) {
        $scores_arr[$comp][$index] = (string) $score;
      } else {
        switch($comp) {
          case 'MC':
          case 'HW':
            $display = 'x.y';
            break;
          case 'TC':
            $display = 'x.yz';
            break;
          default:
            $display = 'x';
        }
        $scores_arr[$comp][$index] = $display;
      }
    }
    return $scores_arr;
  }

  // show create view
  public function create() {
    return view('create');
  }

  public function createStudent(Request $request) {

    //--------- Extra Challenge C: Use Regex/Better Validation -------------------------
    // validation rules and messages, put here first
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'profile_pic' => 'required|mimes:png|max:1000',
    );
    $messages = array(
      'name.regex' => 'Full name should only contain letters and space.',
      'name.required' => 'Full name cannot be blank.',
      'name.between' => 'Full name should be between :min - :max characters.',
      'nick.regex' => 'Nick name should only contain alphanumeric characters and no space.',
      'nick.required' => 'Nick name cannot be blank.',
      'nick.between' => 'Nick name should be between :min - :max characters.',
      'kattis.regex' => 'Kattis account should only contain alphanumeric characters and no space.',
      'kattis.required' => 'Kattis account cannot be blank.',
      'kattis.between' => 'Kattis account should be between :min - :max characters.',
      'profile_pic.required' => 'Profile picture is required.',
      'profile_pic.mimes' => 'Profile picture should be a PNG file.',
      'profile_pic.max' => 'Profile picture should be smaller than 1000 KB.',
    );
    //---------------- END Extra Challenge C --------------------------------------------------------

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
      return back()
             ->withErrors($validator)
             ->withInput();
    }

    //------ Extra Challenge B: Add Image --------------
    // filename set as {nick}.{ext}
    $profile_picName =  $request->input('nick') . '.' . $request->file('profile_pic')->getClientOriginalExtension();
    // save image file to public folder
    $request->file('profile_pic')->move(base_path() . '/public/img/student/', $profile_picName);
    //------ END Extra Challenge B ---------------------------------------

    \DB::transaction(function ($request) {
      //Create student
      //
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

      //Create score
      for ($i = 1; $i <= 9; $i++) {
        $score = new \App\Score;
        $score->component = "MC";
        $score->week = $i;
        $score->score = 0;
        $score->student()->associate($student);
        $score->save();
      }

      for ($i = 1; $i <= 2; $i++) {
        $score = new \App\Score;
        $score->component = "TC";
        $score->week = $i;
        $score->score = 0;
        $score->student()->associate($student);
        $score->save();
      }

      for ($i = 1; $i <= 10; $i++) {
        $score = new \App\Score;
        $score->component = "HW";
        $score->week = $i;
        $score->score = 0;
        $score->student()->associate($student);
        $score->save();
      }

      for ($i = 1; $i <= 9; $i++) {
        $score = new \App\Score;
        $score->component = "BS";
        $score->week = $i;
        $score->score = 0;
        $score->student()->associate($student);
        $score->save();
      }

      for ($i = 1; $i <= 12; $i++) {
        $score = new \App\Score;
        $score->component = "KS";
        $score->week = $i;
        $score->score = 0;
        $score->student()->associate($student);
        $score->save();
      }

      for ($i = 1; $i <= 8; $i++) {
        $score = new \App\Score;
        $score->component = "TC";
        $score->week = $i;
        $score->score = 0;
        $score->student()->associate($student);
        $score->save();
      }
    });

    return redirect()->route('index');
  }

  // show edit view
  public function edit($id) {
    $student = $this->getStudent($id);
    $scores_arr = $this->storeScoresIntoArray(\App\Student::with('scores')->where('id', $id)->first());

    if ($student == -1) {
      return view('error')->with('message', "The selected student does not exist!");
    } else {
      return view('edit')->with('student', \App\Student::where('id', $id)->first())
                         ->with('scores_arr', $scores_arr);
    }
  }

  public function editStudent(Request $request) {

    //--------- Extra Challenge C: Use Regex/Better Validation -------------------------
    // validation rules and messages, put here first
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'mc_components' => ['regex:/^((([0-3]\.(0|5)|4\.0)|(x\.y)),){8}(([0-3]\.(0|5)|4\.0)|(x.y))$/'],
      'tc_components' => ['regex:/^^([0-9]\.([0-9])|(xy\.z)|(10\.[0-5])),((([0-9]|1[0-2])\.([0-9])|(xy.z))|(13\.([0-5])))$$/'],
      'hw_components' => ['regex:/^(([0-1]\.(0|5)|(x.y)),){9}([0-1]\.(0|5)|(x\.y))$/'],
      'bs_components' => ['regex:/^((0|1|x),){8}((0|1|x))$/'],
      'ks_components' => ['regex:/^((0|1|x),){11}((0|1|x))$/'],
      'ac_components' => ['regex:/^((0|1|x),){2}(([0-3]|x),){2}((0|1|x),){3}((0|1|x))$/']
    );
    $messages = array(
      'name.regex' => 'Full name should only contain letters and space.',
      'name.required' => 'Full name cannot be blank.',
      'name.between' => 'Full name should be between :min - :max characters.',
      'nick.regex' => 'Nick name should only contain alphanumeric characters and no space.',
      'nick.required' => 'Nick name cannot be blank.',
      'nick.between' => 'Nick name should be between :min - :max characters.',
      'kattis.regex' => 'Kattis account should only contain alphanumeric characters and no space.',
      'kattis.required' => 'Kattis account cannot be blank.',
      'kattis.between' => 'Kattis account should be between :min - :max characters.',
      'mc_components.regex' => 'Mini Contest scores should range from 0.0 to 4.0, with increments of 0.5, or set as "x.y".',
      'tc_components.regex' => 'Team Contest scores should range from 0.0 to 10.5 for Midterm TC and 0.0 to 13.5 for Final TC, or set as      "xy.z".',
      'hw_components.regex' => 'Homework scores should range from 0.0 to 1.5, with increments of 0.5, or set as "x.y".',
      'bs_components.regex' => 'Problem Bs scores should be 0 or 1, or set as "x".',
      'ks_components.regex' => 'Kattis Sets scores should be 0 or 1, or set as "x".',
      'ac_components.regex' => 'Achievements scores should range from 0 to 3 for week 3 and 4, and 0 or 1 for other weeks, or set as "x".'
    );
    //---------------- END Extra Challenge C --------------------------------------------------------

    $validator = Validator::make($request->all(), $rules, $messages);

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

    //REMOVE ALL OLD CODE THAT USES THE OLD DATABASE!
    //Reminder: when you edit nick, delete {old->profile_pic} and create {new->profile_pic}
    return redirect()->route('index');
  }

  public function deleteStudent($id) {
    $student = \App\Student::where('id', $id)->firstOrFail();
    \File::delete(base_path() . '/public/img/student/' . $student->profile_pic);
    $student->delete();
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
