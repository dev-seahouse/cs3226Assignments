<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Carbon\Carbon;
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
    $students = \App\Student::with('components')
                  ->join('components', 'students.id', '=', 'components.student_id')
                  ->select(\DB::raw('students.*, mc + tc + hw + bs + ks + ac as total'))
                  ->orderBy('total', 'DESC')
                  ->get();
    $last_updated = \App\DatabaseUtil::get_last_updated();
    $friendly_last_updated = Carbon::createFromTimestamp(strtotime($last_updated))->diffForHumans();

    return view('index')->with('students', $students)
                        ->with('last_updated',$friendly_last_updated);;
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

      //Create scores
      $this->create_scores("MC", 9, $student);
      $this->create_scores("TC", 2, $student);
      $this->create_scores("HW", 10, $student);
      $this->create_scores("BS", 9, $student);
      $this->create_scores("KS", 12, $student);
      $this->create_scores("AC", 8, $student);
    });

    return redirect()->route('index');
  }


  private function create_scores($component_name, $num_scores_in_component, $student){
    for ($i = 1; $i <= $num_scores_in_component; $i++) {
      $score = new \App\Score;
      $score->component = $component_name;
      $score->week = $i;
      $score->score = 0;
      $score->student()->associate($student);
      $score->save();
    }
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
    // validate user input
    $validator = Validator::make($request->all(), $this->getEditFormRules(), $this->getEditFormMessages());

    if ($validator->fails()) {
      return back()
             ->withErrors($validator)
             ->withInput();
    }
    
    // update database
    // need to update student
    // need to update component sums
    // need to update scores
    // if nick is edited, need to delete old profile pic to create new profile pic

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

  public function editAllStudent(Request $request,$section) {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';

    $week=preg_replace("/[^0-9]/","",$section);
    $component = preg_replace('/[0-9]+/', '', $section); //remove interger
    
    $studentCount=$request->input('studentCount');

    $sectionRule=null;
    switch ($component) {
        case "MC":
            $sectionRule=$mcRule;
            break;
        case "HW":
            $sectionRule=$tcRule;
            break;
        case "BS":
            $sectionRule=$bsRule;
            break;
        case "KS":
            $sectionRule=$ksRule;
            break;           
        default:
            $sectionRule="error";
    }    
    $rules=array();

    for($i=1;$i<=$studentCount;$i++){

      $new_rule=array();
      if($section=='TC1')$new_rule=array($section."_".$i => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if($section=='TC2')$new_rule=array($section."_".$i => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if($section=='AC1' || $section=='AC2')$new_rule=array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if($section=='AC3' || $section=='AC4')$new_rule=array($section."_".$i => ['required', 'regex:/^([0-3]|x)$/']);
      else if($section=='AC5' || $section=='AC6' || $section=='AC8')$new_rule=array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if($section=='AC7')$new_rule=array($section."_".$i => ['required', 'regex:/^([0-6]|x)$/']);
      else{
        $new_rule=array($section."_".$i => ['required',$sectionRule]);
      }
      $rules=array_merge($rules, $new_rule);
    }
    $validator = Validator::make($request->all(), $rules);
    // print_r($rules);
    if ($validator->fails()) {
      return back() 
             ->withErrors($validator)
             ->withInput();
    }else{

      $students = \App\Student::with('components')
          ->join('components', 'students.id', '=', 'components.student_id')
          ->select('name',\DB::raw(' mc + tc + hw + bs + ks + ac as sum'),'students.id')
          ->orderBy('sum','DESC')
          ->get();
      $foreach_count=1;
      foreach($students as $student){
        $score=\App\Score::where('component','=',$component)->where('week','=',$week)->where('student_id','=',$student->id)->first();
        $inputScore=$request->input($section."_".$foreach_count);
        if($inputScore=='x.y' || $inputScore=='x' || $inputScore=='x.yz')$inputScore=null;
        $score->score= $inputScore;
        $score->save();
        $foreach_count=$foreach_count+1;
      }  
      return redirect()->route('index');       
    }      
  }

  public function editSection($section) {
    $component = preg_replace('/[0-9]+/', '', $section); //remove interger
    $week=preg_replace("/[^0-9]/","",$section);


    $studentCount=\App\Student::get()->count();
  
    $students = \App\Student::with('components')
              ->join('components', 'students.id', '=', 'components.student_id')
              ->select('name',\DB::raw(' mc + tc + hw + bs + ks + ac as sum'),'students.id')
              ->orderBy('sum','DESC')
              ->get();

    $sectionScore=array();
    $test=null;
    foreach($students as $student){
      $currentStudentSectionScore=\App\Score::where('component','=',$component)->where('week','=',$week)->where('student_id','=',$student->id)->select('score','component')->get();
      $test= $currentStudentSectionScore;
      array_push($sectionScore,$currentStudentSectionScore);
    }
    return view('editSection')->with('section',$section)->with('students',$students)->with('sectionScore',$sectionScore)->with('studentCount',$studentCount)->with('component',$component)->with('week',$week)->with('test',$test);

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

  // Faker (old code, use new code for seeding)
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
  
  private function getEditFormRules() {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';
    $rules = array(
      'name' => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
      'nick' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
      // MC rules
      'MC1' => ['required', $mcRule], 'MC2' => ['required', $mcRule], 'MC3' => ['required', $mcRule], 
      'MC4' => ['required', $mcRule], 'MC5' => ['required', $mcRule], 'MC6' => ['required', $mcRule],
      'MC7' => ['required', $mcRule], 'MC8' => ['required', $mcRule], 'MC9' => ['required', $mcRule],
      // TC rules
      'TC1' => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/'],
      'TC2' => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/'],
      // HW rules
      'HW1' => ['required', $hwRule], 'HW2' => ['required', $hwRule], 'HW3' => ['required', $hwRule], 
      'HW4' => ['required', $hwRule], 'HW5' => ['required', $hwRule], 'HW6' => ['required', $hwRule],
      'HW7' => ['required', $hwRule], 'HW8' => ['required', $hwRule], 'HW9' => ['required', $hwRule],
      'HW10' => ['required', $hwRule],
      // BS rules
      'BS1' => ['required', $bsRule], 'BS2' => ['required', $bsRule], 'BS3' => ['required', $bsRule],
      'BS4' => ['required', $bsRule], 'BS5' => ['required', $bsRule], 'BS6' => ['required', $bsRule],
      'BS7' => ['required', $bsRule], 'BS8' => ['required', $bsRule], 'BS9' => ['required', $bsRule],
      // KS rules
      'KS1' => ['required', $ksRule], 'KS2' => ['required', $ksRule], 'KS3' => ['required', $ksRule],
      'KS4' => ['required', $ksRule], 'KS5' => ['required', $ksRule], 'KS6' => ['required', $ksRule], 
      'KS7' => ['required', $ksRule], 'KS8' => ['required', $ksRule], 'KS9' => ['required', $ksRule],
      'KS10' => ['required', $ksRule], 'KS11' => ['required', $ksRule], 'KS12' => ['required', $ksRule],
      // AC rules
      'AC1' => ['required', 'regex:/^(0|1|x)$/'], 'AC2' => ['required', 'regex:/^(0|1|x)$/'],
      'AC3' => ['required', 'regex:/^([0-3]|x)$/'], 'AC4' => ['required', 'regex:/^([0-3]|x)$/'],
      'AC5' => ['required', 'regex:/^(0|1|x)$/'], 'AC6' => ['required', 'regex:/^(0|1|x)$/'],
      'AC7' => ['required', 'regex:/^([0-6]|x)$/'], 'AC8' => ['required', 'regex:/^(0|1|x)$/'],
    );
    
    return $rules;
  }
  
  private function getEditFormMessages() {
    $messages = array(
      'name.regex' => 'Full name should only contain letters and space',
      'name.required' => 'Full name cannot be blank',
      'name.between' => 'Full name should be between :min - :max characters',
      'nick.regex' => 'Nick name should only contain alphanumeric characters and no space',
      'nick.required' => 'Nick name cannot be blank',
      'nick.between' => 'Nick name should be between :min - :max characters',
      'kattis.regex' => 'Kattis account should only contain alphanumeric characters and no space',
      'kattis.required' => 'Kattis account cannot be blank',
      'kattis.between' => 'Kattis account should be between :min - :max characters',
      'TC1.required' => 'Midterm Team Contest score is required, or set as "xy.z"',
      'TC1.regex' => 'Midterm Team Contest score should be between 0 to 10.5',
      'TC2.required' => 'Final Team Contest score is required, or set as "xy.z"',
      'TC2.regex' => 'Final Team Contest score should be between 0 to 13.5',
    );
    
    return $messages;
  }

}
?>
