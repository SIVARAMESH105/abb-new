<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Location;
use Backpack\CRUD\CrudTrait;
use App\Models\Admin\ManageLocations;
use App\Models\Admin\ManageStates;
use App\Models\Admin\ManageCountry;
use DB;

class ManageCamps extends Model
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
    // protected $guarded = ['id'];
    protected $fillable = ['camp_focus', 'LocationId', 'startdate', 'enddate', 'starttime', 'endtime', 'season', 'cost', 'EarlyBirdDiscount', 'contact', 'EarlyBirdDays', 'status', 'coach_id', 'flyer_id'];
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
		else if($this->status == 0)
			$status = 'Inactive';
		else
			$status = 'Coming Soon';
		
		return $status;
	}
	
	public function setDatetimeAttribute($value) {
        $this->attributes['datetime'] = \Date::parse($value);
    }
	
	public function getCamp($id) {
		$camp = DB::table($this->table)
				->join('tbllocation', 'tbl_camp.LocationId', '=', 'tbllocation.Id')
				->select('tbl_camp.*', 'tbllocation.Id', 'tbllocation.Location', 'tbllocation.City', 'tbllocation.State')
				->where('tbl_camp.id', '=', $id)
				->get();
		return $camp;
	}
	
	public function updateCamp($inputData = array()) {
		$campInfo = ManageCamps::find($inputData['id']);
		$campInfo->camp_focus = $inputData['campname'];
		$campInfo->LocationId = $inputData['location'];
		$campInfo->startdate = $inputData['startYear'].'-'.$inputData['startMonth'].'-'.$inputData['startDay'];
		$campInfo->enddate = $inputData['endYear'].'-'.$inputData['endMonth'].'-'.$inputData['endDay'];
		$campInfo->starttime = $inputData['startTime'];
		$campInfo->endtime = $inputData['endTime'];
		$campInfo->season = $inputData['season'];
		$campInfo->cost = $inputData['cost'];
		$campInfo->EarlyBirdDiscount = $inputData['earlyBirdDiscount'];
		$campInfo->EarlyBirdDays = $inputData['discountDays'];
		$campInfo->contact = $inputData['contact'];
		$campInfo->status = $inputData['status'];
		$campInfo->flyer_id = $inputData['campFlyer'];
		$campInfo->save();
		return $campInfo->Id;
	}
	
	public function getPopupCampList()
	{
		$camps = DB::table($this->table)->leftJoin('tbllocation', 'tbl_camp.LocationId', '=', 'tbllocation.Id')->get();
		$locationObj = new ManageLocations();
		$stateObj = new ManageStates();
		$countryObj = new ManageCountry();
		$campList = array();
		foreach($camps as $camp)
		{
			$camp->location = $locationObj->getLocationName($camp->LocationId);
			$camp->State = $stateObj->getStateName($camp->State);
			$camp->Country = $countryObj->getCountryCode($camp->Country);
			$campList[] = $camp;
		}
		return $campList;
	}
	
	public function getCampName($campId)
	{
		$camp = DB::table($this->table)->select('camp_focus')->where('id', $campId)->get();
		return $camp[0]->camp_focus;
	}
    
    // Get active camps for "Coach Assignments" report
    public function activeCampList() 
    {
        $activeCamps = DB::table($this->table)
        		->join('tbllocation',  'tbllocation.Id', '=', 'tbl_camp.LocationId')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                ->select('tbl_camp.camp_focus', 'tbl_camp.id','tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_state_codes.state_code', 'tbllocation.Location', 'tbllocation.City')
                ->where('tbl_camp.status', '=', '1')
                ->orderBy('tbl_camp.camp_focus', 'ASC')
                ->groupBy('tbl_camp.id')
                ->get();
       
        return $activeCamps;
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
		return $this->belongsTo('App\Models\Admin\ManageCoaches', 'coach_id');
	}
	
	public function flyer() {
		return $this->belongsTo('App\Models\Admin\ManageFlyers', 'flyer_id');
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
