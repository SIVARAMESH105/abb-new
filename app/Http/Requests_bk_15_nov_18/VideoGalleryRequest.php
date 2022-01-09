<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VideoGalleryRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
             'title' => 'required',
             'order' => 'required|numeric',
        ];
		if(isset($this->input()['_method'])) {
			if(array_key_exists('video', $this->input())) {
				$rule['video'] = 'required|file|mimes:avi,mpeg,flv,mp4,wmv';
			}

		} else{
			$rule['video'] = 'required|file|mimes:avi,mpeg,flv,mp4,wmv';
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
            'credit_card_number.regex' => 'The credit card number must be 4 digits',
        ];
    }
}
