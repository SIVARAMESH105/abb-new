<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ManageDirectorsRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip' => 'required|numeric',
                'country' => 'required',
            ];
        $rule['email'] = (array_key_exists('id', $this->input())) ? 'required|unique:users,email,'.$this->id : 'required|unique:users,email';   
        if(array_key_exists('password', $this->input())) {
            $rule['password'] = 'required';
            $rule['confirm_password'] = 'required|same:password';
        }  
        return $rule;              
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
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
