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
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'img_image1' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'img_image2' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'img_image3' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'img_image4' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'img_image5' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'img_image6' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image7' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image8' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image9' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image10' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image11' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image12' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image13' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image14' => 'image|mimes:jpeg,png,jpg,gif,svg',  
            'image15' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'image16' => 'image|mimes:jpeg,png,jpg,gif,svg',   
           'feature_image' => 'image|mimes:jpeg,png,jpg,gif,svg'  
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
           //'feature_image.image' => 'only jpeg,png,jpg,gif,svg format are allowed.',   
        ];
    }
}
