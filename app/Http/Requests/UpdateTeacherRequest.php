<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Teacher;

class UpdateTeacherRequest extends FormRequest
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
        return array_merge(Teacher::$rules, ['email' =>  "required|email|unique:teachers,email,".$this->teachers], ['phone' =>  array('required', 'unique:teachers,phone,'.$this->teachers, 'regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/')]);
    }

    public function attributes()
    {
        return Teacher::attributes();
    }
}
