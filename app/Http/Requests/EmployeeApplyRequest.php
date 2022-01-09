<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class EmployeeApplyRequest extends FormRequest
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
            'realname'   => 'required',
            'email'      => 'required|email',
            'authorization' => 'required',
            
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
           'realname.required' => Lang::get('error.employee-name-required'),
           'email.required'    => Lang::get('error.employee-email-required'),
           'authorization.required'    => Lang::get('error.employee-authorization-required'),
        ];
    }
}
