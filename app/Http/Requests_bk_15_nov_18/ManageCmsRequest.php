<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ManageCmsRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'image1' => 'image',
            'image2' => 'image',
            'image3' => 'image',
            'image4' => 'image',
            'image5' => 'image',
            'image6' => 'image',
            'image7' => 'image',
            'image8' => 'image',
            'image9' => 'image',
            'image10' => 'image',
            'image11' => 'image',
            'image12' => 'image',
            'image13' => 'image',
            'image14' => 'image',
            'image15' => 'image',
            'image16' => 'image'
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
