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

}
