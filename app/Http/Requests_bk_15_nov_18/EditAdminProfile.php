<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use App\Http\Response\ApiResponse;
use Lang;

class EditAdminProfile extends FormRequest
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
            'username'        => 'required',
            'useremail'       => 'required|email|max:100'
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
            'username.required'    => Lang::get('error.username-required'),
            'useremail.required'   => Lang::get('error.useremail-required'),
            'useremail.email'      => Lang::get('error.useremail-email'),
            'useremail.max'        => Lang::get('error.useremail-max'),
        ];
    }

    /**
     * Get the response againts validation
     *
     * @return json
     */
    /* public function response(array $errors)
    {   
        //if ($this->ajax())
        //{
            //$result = ApiResponse::build(false, $errors);
            //return Response::json($result);
        //}
    } */
}
