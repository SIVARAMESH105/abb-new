<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class EditCampRequest extends FormRequest
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
        return [
            'student_name'   => 'required',
            'user_email'      => 'required|email',
            'gender'      => 'required',
            'date'      => 'required',
            'month'      => 'required',
            'year'      => 'required',
            'grade_level'      => 'required',
            'parent_first_name'      => 'required',
            'address'      => 'required',
            'city'      => 'required',
            'state'      => 'required',
            'zip_code'      => 'required',
            'country'      => 'required',
            'home_phone'      => 'required',
            'parent_email'      => 'required|email',
            'confirm_email'      => 'required|same:parent_email',
            'hearabout'      => 'required',
            'session_before'      => 'required',
            'rating'      => 'required',
            
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {   
        return [
            //
        ];
    }
}
