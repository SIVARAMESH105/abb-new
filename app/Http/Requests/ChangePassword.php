<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use App\Http\Response\ApiResponse;
use Lang;

class ChangePassword extends FormRequest
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
            'current_password'      => 'required',
            'new_password'       	=> 'required|different:current_password',
            'confirm_password'      => 'required|same:new_password'
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
            'current_password.required'     => Lang::get('error.current_password-required'),
            'new_password.required'			=> Lang::get('error.new_password-required'),
            'confirm_password.required'     => Lang::get('error.confirm_password-required'),
            'new_password.different'        => Lang::get('error.new-password-must-differ-from-current-password'),
            'confirm_password.same'      	=> Lang::get('error.confirm_password-same-as-password'),
        ];
    }
}
