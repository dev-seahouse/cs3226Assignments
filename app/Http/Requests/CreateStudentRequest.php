<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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

    public function sanitize()
    {
        $input = $this->all();

        $sanitizer_args = array (
            'name' => FILTER_SANITIZE_STRING,
            'nick' => FILTER_SANITIZE_STRING,
            'kattis' => FILTER_SANITIZE_STRING,
            'nationality' => FILTER_SANITIZE_STRING,
            'fileURL' => FILTER_SANITIZE_URL
        );

        $input = filter_var_array($input, $sanitizer_args);

        $this->replace($input);
    }


    public function rules()
    {
        $this->sanitize();

        return [
            'name'        => 'required|between:5,30|regex:/^[A-Za-z ]+$/',
            'nick'        => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/|unique:students',
            'kattis'      => 'required|between:5,30|regex:/^[0-9A-Za-z]+$/',
            'profile_pic' => 'required|mimes:png,jpeg|max:1000',
            'fileURL'     => 'required',
            'nationality' => 'required|in:CHN,SGP,IDN,VNM,JPN,AUS,GER,OTH',
        ];
    }


    public function messages()
    {
        return [
            'name.regex'           => 'Full name should only contain letters and space',
            'name.required'        => 'Full name cannot be blank',
            'name.between'         => 'Full name should be between :min - :max characters',
            'nick.regex'           => 'Nick name should only contain alphanumeric characters and no space',
            'nick.required'        => 'Nick name cannot be blank',
            'nick.between'         => 'Nick name should be between :min - :max characters',
            'kattis.regex'         => 'Kattis account should only contain alphanumeric characters and no space',
            'kattis.required'      => 'Kattis account cannot be blank',
            'kattis.between'       => 'Kattis account should be between :min - :max characters',
            'profile_pic.required' => 'Profile picture is required',
            'profile_pic.mimes'    => 'Profile picture should be a PNG or JPG file',
            'profile_pic.max'      => 'Profile picture should be smaller than 1000 KB',
            'fileURL.required'     => 'Please click save to confirm',
            'nationality.required' => 'Nationality cannot be blank',
            'nationality.in'       => 'Nationality should be of either Singaporean, Indonesian, Chinese, Vietnamese, Japanese, Australian, German or Others',
        ];
    }
}
