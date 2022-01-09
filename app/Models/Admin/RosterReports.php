<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Auth;

class RosterReports extends Model 
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_camp';
    
    public function getRostersreport($data)
    {     
        $states = $data['states'];
        $cities = $data['cities'];
        $locations = $data['locations'];
        $coachers = $data['coachers'];
		if(backpack_user()->user_type == 4) {  
			$rosterReports = DB::table($this->table)
                        ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
                        ->leftjoin('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                        ->leftjoin('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
                        ->leftjoin('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
                        ->leftjoin('tbl_roster', 'tbl_roster.camp_id', '=', 'tbl_camp.id')
						->leftjoin('tbl_directors', 'tbl_directors.location_id', '=', 'tbllocation.Id')
						->select('tbl_camp.id', 'tbl_camp.camp_focus', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_camp.starttime', 'tbl_camp.endtime', 'tbl_state_codes.state_name', 'tbllocation.Location', 'tbllocation.City', 'tbl_coach.first_name', 'tbl_coach.last_name', DB::raw('COUNT(tbl_roster.camp_id) as campercount'), DB::raw('SUM(tbl_roster.amount_paid) as camprevenue'),'tbl_directors.director' );
		
		} else {
			 $rosterReports = DB::table($this->table)
                        ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
                        ->leftjoin('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                        ->leftjoin('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
                        ->leftjoin('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
                        ->leftjoin('tbl_roster', 'tbl_roster.camp_id', '=', 'tbl_camp.id')
						->select('tbl_camp.id', 'tbl_camp.camp_focus', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_camp.starttime', 'tbl_camp.endtime', 'tbl_state_codes.state_name', 'tbllocation.Location', 'tbllocation.City', 'tbl_coach.first_name', 'tbl_coach.last_name', DB::raw('COUNT(tbl_roster.camp_id) as campercount'), DB::raw('SUM(tbl_roster.amount_paid) as camprevenue') );
		}
       
		if (!empty($states)) {
		   $rosterReports = $rosterReports->whereIn("tbl_state_codes.state_id", $states);
		}
		if (!empty($locations)) {
			$rosterReports = $rosterReports->whereIn("tbl_camp.LocationId", $locations);
		}
		if (!empty($cities)) {
			$rosterReports = $rosterReports->whereIn("tbllocation.Id", $cities);
		}
		if (!empty($coachers)) {
			$rosterReports = $rosterReports->whereIn("tbl_coach.id", $coachers);
		}
		if(backpack_user()->user_type == 4) {
			$director = backpack_user()->name;
			$rosterReports = $rosterReports->where("tbl_directors.director", $director);
		}
        $rosterReports->where('tbl_roster.status', '=', 'Paid')
                       ->groupBy('tbl_camp.id')
                        ->get();
        return $rosterReports;
    }

    public function getCamperRevenue($camp_id)
    {
        $camperRevenue = DB::table('tbl_roster')
                        ->leftjoin('users', 'tbl_roster.user_id', '=', 'users.id')
                        ->leftjoin('tbl_camp', 'tbl_roster.camp_id', '=', 'tbl_camp.id')
                        ->select('users.*', 'tbl_camp.camp_focus', DB::raw('SUM(tbl_roster.amount_paid) as camperrevenue') )
                        ->where('tbl_roster.camp_id', '=', $camp_id)
                        ->where('tbl_roster.status', '=', 'Paid')
                        ->groupBy('tbl_roster.user_id')
                        ->get();
        return $camperRevenue;
    }               
}
?>