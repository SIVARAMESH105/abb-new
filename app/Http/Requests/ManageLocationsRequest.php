<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ManageLocationsRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
		if($this->request->get('geoCheckbox')=="yes"){
			return [
					'Location'      	=> 'required',
					'Address'       	=> 'required',
					'City'      		=> array('required', 'regex:/^[a-zA-Z-\s]+$/'),
					'State'      		=> 'required',
					'Country'      		=> 'required',
					'Zip'      			=> 'required',
					'director'			=> 'required',
					'geoTemplate'      	=> 'required',
					'title'				=> Rule::unique('tbl_geo_pages'),
					'transcript'		=>'file_extension:vtt,srt',
				];
		} else {
			return [
				'Location'      	=> 'required',
				'Address'       	=> 'required',
				'City'      		=> array('required', 'regex:/^[a-zA-Z-\s]+$/'),
				'State'      		=> 'required',
				'Country'      		=> 'required',
				'Zip'      			=> 'required',
				'director'			=> 'required',
			];
		}
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
