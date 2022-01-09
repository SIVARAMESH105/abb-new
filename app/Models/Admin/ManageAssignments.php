<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Location;
use App\Models\Admin\ManageStates;
use Backpack\CRUD\CrudTrait;
use DB;
class ManageAssignments extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
	protected $table = 'tbl_camp';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['camp_focus', 'LocationId', 'startdate', 'enddate', 'starttime', 'endtime', 'coach', 'coach_id','status'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	
	
	public function setDatetimeAttribute($value) {
        $this->attributes['datetime'] = \Date::parse($value);
    }
	
	public function getStateCode() {
		$state = DB::table('tbllocation')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.state')
				->select('tbl_state_codes.state_code')
				->where('tbllocation.Id', '=', $this->LocationId)
				->get();
		
		return $state[0]->state_code;
	}	
	
	public function getFullName() {
		/*$full_name = DB::table('tbl_coach')
					->join('tbl_coachcamp', 'tbl_coachcamp.coach_id', '=', 'tbl_coach.id')
					->join('tbl_camp', 'tbl_camp.id', '=', 'tbl_coachcamp.camp_id')
					->select(DB::raw('CONCAT(tbl_coach.first_name, " ", tbl_coach.last_name)  AS fullname'))
					->where('tbl_camp.status', '=', 1)
					->get();*/
		$full_name = DB::table('tbl_coach')
					->select(DB::raw('CONCAT(tbl_coach.first_name, " ", tbl_coach.last_name)  AS fullname'))
					->where('tbl_coach.id', '=', $this->coach_id)
					->get();
		return $full_name[0]->fullname;
	}
	
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function location() {
		return $this->belongsTo('App\Models\Admin\ManageLocations', 'LocationId');
	}
	
	public function coach() {
		return $this->belongsTo('App\Models\Admin\ManageCoaches', 'id' );
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
