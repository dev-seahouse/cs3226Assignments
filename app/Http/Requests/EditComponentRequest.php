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
        $this->sanitize();
        return [
            //
        ];
    }

    public function sanitize()
    {
        $input = $this->all();
        $input = array_map(array($this, 'sanitize_strings'), $input);
        $this->replace($input);
    }

    private function sanitize_strings($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

}
