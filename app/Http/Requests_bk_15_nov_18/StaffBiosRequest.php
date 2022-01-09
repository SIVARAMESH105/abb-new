<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StaffBiosRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
		$rule = [
            'name' => 'required',
            'content' => 'required',
            'lft' => 'required|numeric',
        ];
		if(isset($this->input()['_method'])) {
			if(array_key_exists('image', $this->input()) ) {
                $rule['image'] = 'required|image';
			} else if (array_key_exists('thumbnail', $this->input())) {
                $rule['thumbnail'] = 'required|image';
            }
		} else{
            $rule['image'] = 'required|image';
			$rule['thumbnail'] = 'required|image';
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
