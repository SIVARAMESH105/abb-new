<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Admin\ManageStates;
use DB;
use Auth;

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
		$rosters = DB::table('tbl_roster')->join('users','users.id','=','tbl_roster.user_id')->select('users.name','users.fname','users.gender','users.dob','users.city','users.grade','users.basketball_skill','users.parent_firstname','users.parent_lastname','users.parent_email','users.home_phone','users.work_phone','users.address','users.state','users.zip','tbl_roster.tshirtsize','tbl_roster.camp_id','tbl_roster.user_id','tbl_roster.amount_paid','tbl_roster.comments','tbl_roster.hear','tbl_roster.group_discount','tbl_roster.group_id')->where(array('tbl_roster.camp_id'=>$campId, 'tbl_roster.status'=>'Paid'))->orderBy('users.fname', 'asc')->get();
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
				->where('tbl_coachcamp.camp_id', '=', $campId)
				->get();
		$data['coach'] = $coach;
		return $data;
	}
	
	#Coach level user rosters functions
	public function getRostersList($userId)
	{
		//for($userId=1; $userId<100; $userId++) { 67
		$getCoachId = DB::table('tbl_coach')->where(array('user_id'=>$userId, 'email'=>Auth::user()->email))->get();
		//print_r($getCoachId);exit;
		if(count($getCoachId) > 0) {
			$getCampId = DB::table('tbl_coachcamp')->where('coach_id', $getCoachId[0]->id)->get();
			//print_r($getCampId);exit;
			if(count($getCampId) > 0) {
				$campsArray = array();
				foreach($getCampId as $id) {
					$campsArray[] = DB::table($this->table)->where('id', $id->camp_id)->first();
				}
				if(count(array_filter($campsArray)) > 0) {
					$stateObj = new ManageStates();
					$camps = array();
					foreach(array_filter($campsArray) as $getCamp) {
						$getLocation = DB::table('tbllocation')->where('Id', $getCamp->LocationId)->first();
						$getCamp->location = $getLocation->Location;
						$getCamp->city = $getLocation->City;
						$getCamp->state = $stateObj->getStateName($getLocation->State);
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
