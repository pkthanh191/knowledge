<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Center;

class UpdateCenterRequest extends FormRequest
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
        return array_merge(
            Center::$rules,
            ['email' => 'required|max:255|email|unique:centers,email,'.$this->centers,
            'phone' =>['required','regex:/^(09)[0-9]{8}$|^(03)[0-9]{8}$|^(05)[0-9]{8}$|^(07)[0-9]{8}$|^(08)[0-9]{8}$/','unique:centers,phone,'.$this->centers]
            ]);
    }


    public function attributes()
    {
        return Center::attributes();
    }
}
