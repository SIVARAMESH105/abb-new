<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ManageFlyersRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'flyer_title' => 'required',
            'flyer_desc' => 'required',
        ];
		if(isset($this->input()['_method'])) {
			if(array_key_exists('flyer_pdf', $this->input())) {
				$rule['flyer_pdf'] = 'required|file|mimes:pdf';
			}
		} else{
			$rule['flyer_pdf'] = 'required|file|mimes:pdf';
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
