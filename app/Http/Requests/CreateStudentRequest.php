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

    public function sanitize()
    {
        $input = $this->all();

        if (preg_match("#https?://#", $input['url']) === 0) {
            $input['url'] = 'http://' . $input['url'];
        }

        $input['name']        = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['description'] = filter_var($input['description'],
            FILTER_SANITIZE_STRING);

        $this->replace($input);
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

    private function sanitize_strings($string)
    {
        return filter_var($input['name'], FILTER_SANITIZE_STRING);
    }
}
