<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class ManageStates extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_state_codes';
    protected $primaryKey = 'state_id';
    public $timestamps = false;
    protected $fillable = ['state_name', 'state_code', 'country_id', 'status'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function getStatus(){
		if($this->status == 1)
			$status = 'Active';
		else
			$status = 'Inactive';
		
		return $status;
	}
	
	public function getStateCode($id)
	{
		$stateCode = DB::table($this->table)->select('state_code')->where('state_id', '=', $id)->get();
		if(count($stateCode) > 0) {
			return $stateCode[0]->state_code;
		}
	}
	
	public function getStateName($id)
	{
		$stateName = DB::table($this->table)->select('state_name')->where('state_id', '=', $id)->get();
		if(count($stateName) > 0) {
			return $stateName[0]->state_name;
		}
	}

	public function getStateCodeByName($stateName)
	{
		$stateCode = DB::table($this->table)->select('state_code')->where('state_name', '=', $stateName)->first();
		return $stateCode->state_code;
	}
	
	public function stateList()
	{
		$states = DB::table($this->table)->get();
		return $states;
	}
	
	public function getStatesByCountry($countryId)
	{
		$countryStates = DB::table($this->table)->where('country_id', $countryId)->get();
		$options = '';
		foreach($countryStates as $state)
		{
			$options .= '<option  data-attr="'.$state->state_code .'" value="'.$state->state_id .'">'.$state->state_name.'</option>';
		}
		return $options;
	}
    public function activeStateList()
    {
        $states = DB::table($this->table)->where('status', '=', '1')->get();
        return $states;
    }
	
	public function getStateListById($id)
    {
        $states = DB::table($this->table)->select('state_id','state_name')->where('state_id', '=', $id)->first();
		
		return $states;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function country() {
		return $this->belongsTo('App\Models\Admin\ManageCountry', 'country_id');
	}
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
