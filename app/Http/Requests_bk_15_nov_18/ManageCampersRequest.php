<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ManageCampersRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'name' => 'required',
             'fname' => 'required',
             'tshirtsize' => 'required',
             'gender' => 'required',
             'dob' => 'required',
             'grade' => 'required',
             'parent_firstname' => 'required',
             'parent_lastname' => 'required',
             'address' => 'required',
             'city' => 'required',
             'state' => 'required',
             'zip' => 'required|numeric',
             'home_phone' => 'required|regex:/^[0-9 \-]+$/',
             'parent_email' => 'required|email',
        ];
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
