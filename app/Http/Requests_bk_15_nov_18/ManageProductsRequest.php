<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;
class ManageProductsRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            // 'name' => 'required|min:5|max:255'
             'pd_name' => 'required',
             'pd_category' => 'required',
             'pd_description' => 'required',
             'pd_price' => 'required',
             'pd_breakqty' => 'required',
             'pd_color' => 'required',
             'pd_size' => 'required',
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
           'pd_name.required'     		=> Lang::get('error.pd_name-required'),
           'pd_category.required'     		=> Lang::get('error.pd_category-required'),
           'pd_description.required'     		=> Lang::get('error.pd_description-required'),
           'pd_price.required'     		=> Lang::get('error.pd_price-required'),
        ];
    }
}
