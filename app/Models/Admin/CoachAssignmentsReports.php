<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class CoachAssignmentsReports extends Model 
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    
    protected $table = 'tbl_camp';
    
    public function getCoachAssignmentsreport($data)
    {     
        $states = $data['states'];
        $cities = $data['cities'];
        $locations = $data['locations'];
        $camps = $data['camps'];
        // $coachers = $data['coachers'];
        $directors = $data['directors'];
        $CoachAssignmentsReports = DB::table($this->table)
                        ->join('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
                        ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                        ->join('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
                        ->join('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
                        ->join('tbl_roster', 'tbl_roster.camp_id', '=', 'tbl_camp.id')
                        ->join('tbl_directors', 'tbl_directors.location_id', '=', 'tbllocation.Id')
                        ->select('tbl_camp.id', 'tbl_camp.camp_focus', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_camp.starttime', 'tbl_camp.endtime', 'tbl_state_codes.state_name', 'tbllocation.Location', 'tbllocation.City', 'tbl_coach.first_name', 'tbl_coach.last_name', DB::raw('COUNT(tbl_roster.camp_id) as campercount'),'tbl_directors.director');
                            if (!empty($states)) {
                               $CoachAssignmentsReports = $CoachAssignmentsReports->whereIn("tbl_state_codes.state_id", $states);
                            }
                            if (!empty($locations)) {
                                $CoachAssignmentsReports = $CoachAssignmentsReports->whereIn("tbl_camp.LocationId", $locations);
                            }
                            if (!empty($cities)) {
                                $CoachAssignmentsReports = $CoachAssignmentsReports->whereIn("tbllocation.Id", $cities);
                            }
                            if (!empty($camps)) {
                                $CoachAssignmentsReports = $CoachAssignmentsReports->whereIn("tbl_camp.id", $camps);
                            }
                            // if (!empty($coachers)) {
                            //     $CoachAssignmentsReports = $CoachAssignmentsReports->whereIn("tbl_coach.id", $coachers);
                            // }
							 if (!empty($directors)) {
                                 $CoachAssignmentsReports = $CoachAssignmentsReports->whereIn("tbl_directors.director", $directors);
                             }
							
        $CoachAssignmentsReports->where('tbl_camp.status', '=', '1')
                        ->where('tbl_state_codes.status', '=', '1')
                        ->where('tbl_roster.status', '=', 'Paid')
                        ->groupBy('tbl_camp.id')
                        ->orderBy('tbl_coach.first_name', 'ASC')
                        ->get();
        return $CoachAssignmentsReports;
    }
}

?>