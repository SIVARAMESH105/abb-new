<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Admin\ManageStates;
use DB;

class ViewCoachRosters extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_camp';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */	
	public function getPdf($campId)
	{
		$rosters = DB::table('tbl_roster')->where('camp_id', '=', $campId)->where('status', '=', 'Paid')->orderBy('fname', 'asc')->get();
		$data['rosters'] = $rosters;		
		$camps = DB::table('tbl_camp')
				->join('tbllocation', 'tbl_camp.LocationId', '=', 'tbllocation.Id')
				->select('tbl_camp.camp_focus', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_camp.starttime', 'tbl_camp.endtime', 'tbllocation.Location', 'tbllocation.Address', 'tbllocation.City', 'tbllocation.State', 'tbllocation.Zip')
				->where('tbl_camp.id', '=', $campId)
				->get();
		$data['camps'] = $camps;
		$coach = DB::table('tbl_coachcamp')
				->join('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
				->select('tbl_coach.first_name', 'tbl_coach.last_name')
				->where('tbl_coachcamp.coach_id', '=', $campId)
				->get();
		$data['coach'] = $coach;
		return $data;
	}
	
	#Coach level user rosters functions
	public function getRostersList($userId)
	{
		//for($userId=1; $userId<100; $userId++) { 67
		$getCoachId = DB::table('tbl_coach')->where('user_id', $userId)->get();
		if(count($getCoachId) > 0) {
			$getCampId = DB::table('tbl_coachcamp')->where('coach_id', $getCoachId[0]->id)->get();
			if(count($getCampId) > 0) {
				$getCamps = DB::table($this->table)->where('id', $getCampId[0]->camp_id)->get();
				if(count($getCamps) > 0) {
					$stateObj = new ManageStates();
					$camps = array();
					foreach($getCamps  as $getCamp) {
						$getLocation = DB::table('tbllocation')->where('Id', $getCamp->LocationId)->get();
						$getCamp->location = $getLocation[0]->Location;
						$getCamp->city = $getLocation[0]->City;
						$getCamp->state = $stateObj->getStateName($getLocation[0]->State);
						$getCamp->coach_name = $getCoachId[0]->first_name.' '.$getCoachId[0]->last_name;
						$camps[] = $getCamp;
					}
					return $camps;
				}
			}
		}
	}	
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function location()
	{
		return $this->belongsTo('App\Models\Admin\ManageLocations', 'LocationId');
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
