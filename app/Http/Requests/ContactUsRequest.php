<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;

class ContactUsRequest extends FormRequest
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
            'state'      => 'required',
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
            'realname.required' => Lang::get('error.contact-name-required'),
            'email.required'    => Lang::get('error.contact-email-required'),
            'state.required'    => Lang::get('error.contact-state-required'),

        ];
    }
}
