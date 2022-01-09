<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Lang;

class CampUpdateRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            'camp_focus'      	=> 'required',
            'LocationId'       	=> 'required',
            'startdate'      	=> 'required',
            'enddate'      		=> 'required',
            'starttime'      	=> 'required',
            'endtime'      		=> 'required',
            'season'      		=> 'required',
            'cost'      		=> 'required',
            'EarlyBirdDiscount'	=> 'required',
            'EarlyBirdDays'     => 'required',
            'contact'      		=> 'required',
            'status'      		=> 'required',
            'coach_id'      	=> 'required',
            'flyer_id'      	=> 'required'
        ];
		
		/* return [
            'campname'      	=> 'required',
            'location'       	=> 'required',
            'startMonth'      	=> 'required',
            'startDay'      	=> 'required',
            'startYear'      	=> 'required',
            'endMonth'      	=> 'required',
            'endDay'      		=> 'required',
            'endYear'      		=> 'required',
            'startTime'      	=> 'required',
            'endTime'      		=> 'required',
            'season'      		=> 'required',
            'cost'      		=> 'required',
            'earlyBirdDiscount'	=> 'required',
            'discountDays'      => 'required',
            'contact'      		=> 'required',
            'status'      		=> 'required',
            'coachAssign'      	=> 'required',
            'campFlyer'      	=> 'required'
        ]; */
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
            'campname.required'     		=> Lang::get('error.campname-required'),
            'location.required'				=> Lang::get('error.location-required'),
            'startMonth.required'     		=> Lang::get('error.startMonth-required'),
            'startDay.required'     		=> Lang::get('error.startDay-required'),
            'startYear.required'     		=> Lang::get('error.startYear-required'),
            'endMonth.required'        		=> Lang::get('error.endMonth-required'),
            'endDay.required'        		=> Lang::get('error.endDay-required'),
            'endYear.required'        		=> Lang::get('error.endYear-required'),
            'startTime.required'      		=> Lang::get('error.startTime-required'),
            'endTime.required'      		=> Lang::get('error.endTime-required'),
            'season.required'      			=> Lang::get('error.season-required'),
            'cost.required'      			=> Lang::get('error.cost-required'),
            'earlyBirdDiscount.required'	=> Lang::get('error.earlyBirdDiscount-required'),
            'discountDays.required'      	=> Lang::get('error.discountDays-required'),
            'contact.required'      		=> Lang::get('error.contact-required'),
            'status.required'      			=> Lang::get('error.status-required'),
            'coachAssign.required'      	=> Lang::get('error.coachAssign-required'),
            'campFlyer.required'      		=> Lang::get('error.campFlyer-required')
        ];
    }
}
