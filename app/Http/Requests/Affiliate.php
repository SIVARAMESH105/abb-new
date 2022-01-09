<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use App\Http\Response\ApiResponse;
use Lang;
use Illuminate\Validation\Rule;

class Affiliate extends FormRequest
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
		$rules = [
			'name'   => 'required',
            'address'    => 'required',
			'phone' => 'required',
            'email'   => 'required|email',
		];
		/*foreach($this->request->get('URL') as $key => $val){
			$rules['URL'.$key] = 'required';
		}*/
		return $rules;
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
