<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditComponentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $component = preg_replace('/[0-9]+/', '', $this->section); //remove integer
        $sectionRule = $this->getSectionRule($component);
        $studentCount = $this->studentCount;
        $section = $this->section;

        $rules = array();

        for ($i = 1; $i <= $studentCount; $i++) {

            $new_rule = array();
            if ($section == 'TC1') {
                $new_rule = array($section . "_" . $i => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
            } else if ($section == 'TC2') {
                $new_rule = array($section . "_" . $i => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/']);
            } else if ($section == 'AC1' || $section == 'AC2') {
                $new_rule = array($section . "_" . $i => ['required', 'regex:/^(0|1|x)$/']);
            } else if ($section == 'AC3' || $section == 'AC4') {
                $new_rule = array($section . "_" . $i => ['required', 'regex:/^([0-3]|x)$/']);
            } else if ($section == 'AC5' || $section == 'AC6' || $section == 'AC8') {
                $new_rule = array($section . "_" . $i => ['required', 'regex:/^(0|1|x)$/']);
            } else if ($section == 'AC7') {
                $new_rule = array($section . "_" . $i => ['required', 'regex:/^([0-6]|x)$/']);
            } else {
                $new_rule = array($section . "_" . $i => ['required', $sectionRule]);
            }
            $rules = array_merge($rules, $new_rule);
        }

        return $rules;
    }



    public function sanitize()
    {
        $input = $this->all();
        $input = array_map(array($this, 'sanitize_strings'), $input);
        $this->replace($input);
    }

    private function getSectionRule($component)
    {
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

    private function sanitize_strings($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}
