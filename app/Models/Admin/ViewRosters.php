<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class ViewRosters extends Model
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
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function getCampNameWithLink()
	{
		return '<a href="camper/'.$this->id.'">'.$this->camp_focus.'</a>';
	}
	
	public function getStateCode()
	{
		$state = DB::table('tbllocation')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.state')
				->select('tbl_state_codes.state_code')
				->where('tbllocation.Id', '=', $this->LocationId)
				->get();
		
		return $state[0]->state_code;
	}

	public function getStateName()
	{
		$state = DB::table('tbllocation')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.state')
				->select('tbl_state_codes.state_name')
				->where('tbllocation.Id', '=', $this->LocationId)
				->get();
		
		return $state[0]->state_name;
	}
	
	
	public function getCoachName()
	{
		$getCoachId = DB::table('tbl_coachcamp')->select('coach_id')->where('camp_id', '=', $this->id)->get();
		if(isset($getCoachId[0]) && $getCoachId[0]->coach_id != '')
		{
			$coachId = $getCoachId[0]->coach_id;
			$getCoachName = DB::table('tbl_coach')->select('first_name', 'last_name')->where('id', '=', $coachId)->get();
			if(isset($getCoachName[0])){
				return $getCoachName[0]->first_name.' '.$getCoachName[0]->last_name;
			}
		}
	}
	
	public function getCamperCount()
	{
		$getCount = DB::table('tbl_roster')->where('camp_id', '=', $this->id)->where('status', '=', 'Paid')->count();
		return $getCount;
	}
	
	public function downloadXLS()
	{
		$xlsIconSrc = asset('public/images/Excel-icon.png');
		return '<a href="rostersXls/'.$this->id.'" target="_blank"><img src="'.$xlsIconSrc.'" width="20" height="20" border="0"></a>';
	}
	
	public function downloadPDF()
	{
		$pdfIconSrc = asset('public/images/pdf.jpeg');
		return '<a href="rostersPdf/'.$this->id.'" target="_blank"><img src="'.$pdfIconSrc.'" width="22" height="22" border="0"></a>';
	}
	
	public function getXls($campId)
	{	//echo $campId;die;
		/* $campers = DB::table('tbl_roster')->select(DB::raw('count(*) as camperCount, name, fname, gender, dob, grade, tshirtsize, basketball_skill, parent_firstname, parent_lastname, parent_email, home_phone, work_phone, amount_paid, address, city, state, zip, last_update'))->where('camp_id', '=', $campId)->where('status', '=', 'Paid')->get(); */
		
		$campers = DB::table('tbl_roster as tr')
				->join('users as u', 'u.id', '=', 'tr.user_id')
				->select(DB::raw('count(*) as camperCount, u.name, u.fname, u.gender, u.dob, u.grade, u.basketball_skill, u.parent_firstname, u.parent_lastname, u.parent_email, u.home_phone, u.work_phone, tr.amount_paid, u.address, u.city, u.state, u.zip, tr.last_update, tr.tshirtsize'))
				->where('tr.camp_id', '=', $campId)
				->where('tr.status', '=', 'New')
				->get();
		//echo '<pre>'; print_r($campers);die;
		
		$camp = DB::table('tbl_camp as c')
				->join('tbllocation as l', 'l.Id', '=', 'c.LocationId')
				->select(DB::raw('count(*) as campCount, c.camp_focus, c.startdate, c.enddate, c.starttime, c.endtime, l.Location, l.Address, l.City, l.State, l.Zip'))
				->where('c.id', '=', $campId)
				->get();
				
		$coach = DB::table('tbl_coachcamp')
				->join('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
				->select(DB::raw('count(*) as coachCount, tbl_coach.first_name, tbl_coach.last_name'))
				->where('tbl_coachcamp.coach_id', '=', $campId)
				->get();
		if($coach[0]->coachCount > 0) {
			$coachName = $coach[0]->first_name.' '.$coach[0]->last_name;
		} else {
			$coachName = '';
		}
		if($camp[0]->campCount > 0) {
			$campName = $camp[0]->camp_focus;
			$campLocation = $camp[0]->Location;
			$campAddress = $camp[0]->Address;
			$campDate = $camp[0]->startdate.' - '.$camp[0]->enddate;
			$campTime = $camp[0]->starttime.' - '.$camp[0]->endtime;
		} else {
			$coachName = '';
			$campLocation = '';
			$campAddress = '';
			$campDate = '';
			$campTime = '';
		}
		if($campers[0]->camperCount > 0) {
			$camperCount = $campers[0]->camperCount;
		} else {
			$camperCount = '';
		}
		$data = array(
			array('Camp Name', $campName),
			array('Location', $campLocation),
			array('Address', $campAddress),
			array('Date', $campDate),
			array('Time', $campTime),
			array('Camper Count', count($campers)),
			array('Coach', $coachName),
			array('', ''),
			array('Roster Name', 'Gender', 'Birth Date', 'Grade', 'Size', 'Experience', 'Parent Name', 'Parent Email', 'Address', 'City', 'State', 'ZIP Code', 'Home Phone', 'Work Phone', 'Paid', 'Date Registered'),
		);		
		foreach($campers as $camper)
		{
			$campData = array($camper->name.' '.$camper->fname, $camper->gender, $camper->dob, $camper->grade, $camper->tshirtsize, $camper->basketball_skill, $camper->parent_firstname.' '.$camper->parent_lastname, $camper->parent_email, $camper->address, $camper->city, $camper->state, $camper->zip, $camper->home_phone, $camper->work_phone, '$'.$camper->amount_paid, $camper->last_update);
			array_push($data, $campData);
		}
		return $data;
	}
	
	public function getPdf($campId)
	{
		//$rosters = DB::table('tbl_roster')->where('camp_id', '=', $campId)->where('status', '=', 'Paid')->orderBy('fname', 'asc')->get();
		
		$rosters = DB::table('tbl_roster as tr')
				->join('users as u', 'u.id', '=', 'tr.user_id')
				->select(DB::raw('count(*) as camperCount, u.name, u.fname, u.gender, u.dob, u.grade, u.basketball_skill, u.parent_firstname, u.parent_lastname, u.parent_email, u.home_phone, u.work_phone, tr.amount_paid, u.address, u.city, u.state, u.zip, tr.last_update'))
				->where('tr.camp_id', '=', $campId)
				->where('tr.status', '=', 'New')
				->get();
		//echo '<pre>'; print_r($rosters);die;
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
