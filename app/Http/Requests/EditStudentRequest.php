<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditStudentRequest extends FormRequest
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
        $id = $this->id;
        $this->sanitize();

        $mcRule = 'regex:/^([0-3](\.(0|5))?)$|(4(\.0)?)$|(x\.y)$/';
        $hwRule = 'regex:/^([0-1](\.(0|5))?)$|(x.y)$/';
        $bsRule = 'regex:/^(0|1|x)$/';
        $ksRule = 'regex:/^(0|1|x)$/';
        return [
            'name'   => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
            'nick'   => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/|unique:students' . ($id ? ',id,' . $id : ''),
            'kattis' => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
            // MC rules
            'MC1'    => ['required', $mcRule], 'MC2'               => ['required', $mcRule], 'MC3'  => ['required', $mcRule],
            'MC4'    => ['required', $mcRule], 'MC5'               => ['required', $mcRule], 'MC6'  => ['required', $mcRule],
            'MC7'    => ['required', $mcRule], 'MC8'               => ['required', $mcRule], 'MC9'  => ['required', $mcRule],
            // TC rules
            'TC1'    => ['required', 'regex:/^(10(\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/'],
            'TC2'    => ['required', 'regex:/^(1[0-3](\.[0-5])?)$|^([0-9](\.([0-9]))?)$|(xy\.z)$/'],
            // HW rules
            'HW1'    => ['required', $hwRule], 'HW2'               => ['required', $hwRule], 'HW3'  => ['required', $hwRule],
            'HW4'    => ['required', $hwRule], 'HW5'               => ['required', $hwRule], 'HW6'  => ['required', $hwRule],
            'HW7'    => ['required', $hwRule], 'HW8'               => ['required', $hwRule], 'HW9'  => ['required', $hwRule],
            'HW10'   => ['required', $hwRule],
            // BS rules
            'BS1'    => ['required', $bsRule], 'BS2'               => ['required', $bsRule], 'BS3'  => ['required', $bsRule],
            'BS4'    => ['required', $bsRule], 'BS5'               => ['required', $bsRule], 'BS6'  => ['required', $bsRule],
            'BS7'    => ['required', $bsRule], 'BS8'               => ['required', $bsRule], 'BS9'  => ['required', $bsRule],
            // KS rules
            'KS1'    => ['required', $ksRule], 'KS2'               => ['required', $ksRule], 'KS3'  => ['required', $ksRule],
            'KS4'    => ['required', $ksRule], 'KS5'               => ['required', $ksRule], 'KS6'  => ['required', $ksRule],
            'KS7'    => ['required', $ksRule], 'KS8'               => ['required', $ksRule], 'KS9'  => ['required', $ksRule],
            'KS10'   => ['required', $ksRule], 'KS11'              => ['required', $ksRule], 'KS12' => ['required', $ksRule],
            // AC rules
            'AC1'    => ['required', 'regex:/^(0|1|x)$/'], 'AC2'   => ['required', 'regex:/^(0|1|x)$/'],
            'AC3'    => ['required', 'regex:/^([0-3]|x)$/'], 'AC4' => ['required', 'regex:/^([0-3]|x)$/'],
            'AC5'    => ['required', 'regex:/^(0|1|x)$/'], 'AC6'   => ['required', 'regex:/^(0|1|x)$/'],
            'AC7'    => ['required', 'regex:/^([0-6]|x)$/'], 'AC8' => ['required', 'regex:/^(0|1|x)$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.regex'      => 'Full name should only contain letters and space',
            'name.required'   => 'Full name cannot be blank',
            'name.between'    => 'Full name should be between :min - :max characters',
            'nick.regex'      => 'Nick name should only contain alphanumeric characters and no space',
            'nick.required'   => 'Nick name cannot be blank',
            'nick.between'    => 'Nick name should be between :min - :max characters',
            'kattis.regex'    => 'Kattis account should only contain alphanumeric characters and no space',
            'kattis.required' => 'Kattis account cannot be blank',
            'kattis.between'  => 'Kattis account should be between :min - :max characters',
            'TC1.required'    => 'Midterm Team Contest score is required, or set as "xy.z"',
            'TC1.regex'       => 'Midterm Team Contest score should be between 0 to 10.5',
            'TC2.required'    => 'Final Team Contest score is required, or set as "xy.z"',
            'TC2.regex'       => 'Final Team Contest score should be between 0 to 13.5',
        ];
    }

    public function sanitize()
    {
        $input = $this->all();


        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['nick'] = filter_var($input['nick'],
            FILTER_SANITIZE_STRING);
        $input['comments'] = filter_var($input['comments'],
            FILTER_SANITIZE_STRING);

        $this->replace($input);
    }
}
