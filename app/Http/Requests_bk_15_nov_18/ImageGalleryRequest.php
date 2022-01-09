<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;
use App\Http\Response\ApiResponse;
use Lang;


class ImageGalleryRequest extends FormRequest
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
        $rule = [
            'realname' => 'required|max:100',
            'email' => 'required|max:100',
            'phone' => 'required|regex:/^[0-9 \-]{5,15}$/',
            'caption' => 'required|max:255',
            'basketimages' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];       
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
           'phone.regex'           => Lang::get('Phone number must be in 5-15 digits'),
           'basketimages.mimes'           => Lang::get('Your image should be in png,jpg,gif format'),
        ];
    }
}
