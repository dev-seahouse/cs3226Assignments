<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditComponentController extends Controller {

  function __construct() {
    // constructor
  }

  public function edit(Request $request, $section) {
    $week = preg_replace('/[^0-9]/', '', $section);
    $component = preg_replace('/[0-9]+/', '', $section); //remove integer

    $studentCount = $request->input('studentCount');
    $sectionRule = $this->getSectionRule($component);

    $validator = Validator::make($request->all(), $this->getRules($studentCount, $section, $sectionRule));
    if ($validator->fails()) {
      return back() 
        ->withErrors($validator)
        ->withInput();
    }

    // update scores
    for ($i = 1; $i <= $studentCount; $i++) {
      $student_id = $request->input($i);

      $score = \App\Score::where('student_id', $student_id)->where('component', $component)->where('week', $week)->first();
      $inputScore = $request->input($section.'_'.$i);
      if ($inputScore == 'x.y' || $inputScore == 'x' || $inputScore == 'xy.z') $inputScore = null;
      $score->score = $inputScore;
      $score->save();
    }

    // need to update components

    return redirect()->route('index');
  }

  private function getSectionRule($component) {
    $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
    $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
    $bsRule = 'regex:/^(0|1|x)$/';
    $ksRule = 'regex:/^(0|1|x)$/';

    $sectionRule = null;
    switch ($component) {
      case "MC":
        $sectionRule = $mcRule;
        break;
      case "HW":
        $sectionRule = $hwRule;
        break;
      case "BS":
        $sectionRule = $bsRule;
        break;
      case "KS":
        $sectionRule = $ksRule;
        break;           
      default:
        $sectionRule = "error";
    }

    return $sectionRule;
  }

  private function getRules($studentCount, $section, $sectionRule) {
    $rules = array();

    for ($i = 1; $i <= $studentCount; $i++){

      $new_rule = array();
      if ($section == 'TC1') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if ($section == 'TC2') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
      else if ($section == 'AC1' || $section == 'AC2') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if ($section == 'AC3' || $section == 'AC4') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^([0-3]|x)$/']);
      else if ($section == 'AC5' || $section == 'AC6' || $section == 'AC8')
        $new_rule = array($section."_".$i => ['required', 'regex:/^(0|1|x)$/']);
      else if ($section == 'AC7') 
        $new_rule = array($section."_".$i => ['required', 'regex:/^([0-6]|x)$/']);
      else {
        $new_rule = array($section."_".$i => ['required', $sectionRule]);
      }
      $rules = array_merge($rules, $new_rule);
    }

    return $rules;
  }


}