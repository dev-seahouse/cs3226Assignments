<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function __construct()
    {
        $this->components = $this->components();
    }
    // get all components belonging to student
    public function components()
    {
        return $this->hasMany('App\Component', 'student_id');
    }

    public function propic()
    {
        return "student" . $this->id . ".png";
    }

    public function get_component_scores($component_name){
        $component = $this->find_component_by_name($component_name);
        return $component->first()->scores();
    }

    public function get_component_sum($component_name){
        $scores = $this->get_component_scores($component_name);
        return $scores->sum('score');
    }

    public function get_spe(){
      return $this->get_component_sum("MC") + $this->get_component_sum("TC");
    }

    public function get_dil(){
      return $this->get_component_sum("HW") +
             $this->get_component_sum("BS") +
             $this->get_component_sum("KS") +
             $this->get_component_sum("AC");
    }

    public function get_sum(){
      return $this->get_spe() + $this->get_dil();
    }

    public function find_component_by_name($c_name)
    {
        return $this->components->where("component_t_id",
            ComponentType::where("name", $c_name)->first()->id);
    }
/*
    public function toArray(){
      $arr = array(
          "ID" => $this->id,
          "FLAG" => $this->nationality,
          "PROPIC" => $this->propic(),
          "NAME" => $this->name,
          "KATTIS" => $this->kattis,
          "MC" => $this->get_component_sum("MC"),
          "MC_COMPONENTS" => $this->get_component_scores("MC")->get()->toArray(),
          "TC" => $this->get_component_sum("TC"),
          "TC_COMPONENTS" => $this->get_component_scores("TC")->get()->toArray(),
          "SPE" => $this->get_spe(),
          "HW" => $this->get_component_sum("HW"),
          "HW_COMPONENTS" => $this->get_component_scores("HW")->get()->toArray(),
          "BS" => $this->get_component_sum("BS"),
          "BS_COMPONENTS" => $this->get_component_scores("BS")->get()->toArray(),
          "KS" => $this->get_component_sum("KS"),
          "KS_COMPONENTS" => $this->get_component_scores("KS")->get()->toArray(),
          "AC" => $this->get_component_sum("AC"),
          "AC_COMPONENTS" => $this->get_component_scores("AC")->get()->toArray(),
          "DIL" => $this->get_dil(),
          "SUM" => $this->get_sum()
        );
      return $arr;
    }*/

}
