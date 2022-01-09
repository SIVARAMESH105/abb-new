<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Auth;

class RevenueReports extends Model 
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    //protected $table = 'tbl_order_camp';
    protected $table = 'tbl_camp';

	/*
		* This function is used to get the result of revenue
		* @param array $data 
		* return result of array
        * @param :option_display: 1->All camper details, camp total, grand totals,2->Camp totals, grand totals,3-> grand totals
	*/
    public function getRevenueReport($data)
    {
        $startdate = $data['startdate'];
        $enddate = $data['enddate'];
        $states = $data['states'];
        $cities = $data['cities'];
        $locations = $data['locations'];
        $coachers = $data['coachers'];
        $directors = $data['directors'];
        $camps = $data['camps'];
        $optionsDisplay = $data['options_display'];
        $revenueReports = array();
        $finalResult = array();
        $camp_revenue_sql = DB::table($this->table)
                        ->leftjoin('tbl_roster', 'tbl_roster.camp_id', '=', 'tbl_camp.id')
                        ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
                        ->leftjoin('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                        ->leftjoin('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
                        ->leftjoin('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
                        ->leftjoin('tbl_directors', 'tbl_directors.location_id', '=', 'tbllocation.Id')
                        //->select(DB::raw('SUM(tbl_roster.amount_paid) as camp_revenue'));
                        ->select('tbl_camp.id', 'tbl_camp.camp_focus', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_camp.starttime', 'tbl_camp.endtime', 'tbl_state_codes.state_name', 'tbllocation.Location', 'tbllocation.City', 'tbl_coach.first_name', 'tbl_coach.last_name', DB::raw('COUNT(tbl_roster.camp_id) as campercount'), DB::raw('SUM(tbl_roster.amount_paid) as camp_revenue'),'tbl_directors.director' );
                            if (!empty($states) && !($states[0] == 'all') ) {
                                $camp_revenue_sql = $camp_revenue_sql->whereIn("tbl_state_codes.state_id", $states);
                            }
                            if (!empty($locations) && !($locations[0] == 'all')) {
                                $camp_revenue_sql = $camp_revenue_sql->whereIn("tbl_camp.LocationId", $locations);
                            }
                            if (!empty($cities) && !($cities[0] == 'all')) {
                               $camp_revenue_sql = $camp_revenue_sql->whereIn("tbllocation.Id", $cities);
                            }
                            if (!empty($coachers) && !($coachers[0] == 'all') ) {
                                $camp_revenue_sql = $camp_revenue_sql->whereIn("tbl_coach.id", $coachers);
                            }
                            if (!empty($startdate) && !empty($enddate)) {
								$startdate = date('Y-m-d', strtotime($startdate));
								$enddate = date('Y-m-d', strtotime($enddate));
								$camp_revenue_sql = $camp_revenue_sql->where('tbl_camp.startdate', '>=', $startdate)->where('tbl_camp.enddate', '<=', $enddate);
                            }
                            if (!empty($directors) && !($directors[0] == 'all')) {
                                $camp_revenue_sql = $camp_revenue_sql->whereIn("tbl_directors.director", $directors);
                            }
                            if (!empty($camps) && !($camps[0] == 'all')) {
                                $camp_revenue_sql = $camp_revenue_sql->whereIn("tbl_camp.id", $camps);
                            }
                            if (($optionsDisplay[0] == 1)) {
                                $camp_revenue= $camp_revenue_sql->where('tbl_roster.status', '=', 'Paid')->groupBy('tbl_camp.id')->get();
                            }  
                           else if (($optionsDisplay[0] == 2) || ($optionsDisplay[0] == 3) ) {
                                $camp_revenue= $camp_revenue_sql->where('tbl_roster.status', '=', 'Paid')->get();
                            }
        $product_revenue = DB::table('tbl_order_item')
                        ->leftjoin('tbl_product', 'tbl_order_item.pd_id', '=', 'tbl_product.pd_id')
                        ->select(DB::raw('SUM(tbl_order_item.od_price) as product_revenue') )
                        ->get();
        if($optionsDisplay[0] == 1){ 
            $revenueReports = $camp_revenue;
            return $revenueReports;
        } elseif($optionsDisplay[0] == 2 || $optionsDisplay[0] == 3)
        {
            if($camp_revenue[0]->camp_revenue == null){
                $camp_revenue[0]->camp_revenue = 0;   
            }
            if($product_revenue[0]->product_revenue == null){
                $product_revenue[0]->product_revenue = 0;   
            }
    		$totalRevenue = ($camp_revenue[0]->camp_revenue+$product_revenue[0]->product_revenue);
    		$revenueReports[] = array("camp_revenue"=>$camp_revenue[0]->camp_revenue,"product_revenue"=>$product_revenue[0]->product_revenue,"total_revenue"=>$totalRevenue);
            
            return $revenueReports;
        }
    }
	
	/*
		* This function is used to get the result of coach revenue
		* @param array $data 
		* return result of object
	*/
	public function getCoachRevenuereport($data)
    {  
		$startdate = $data['cstartdate'];
        $enddate = $data['cenddate'];
		$getCoachId = DB::table('tbl_coach')->select('id')->where(array('user_id'=>Auth::user()->id, 'email'=>Auth::user()->email))->first();
		$coachrevenueReportsSql = DB::table($this->table)
					->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
					->leftjoin('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
					->leftjoin('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
					->leftjoin('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
					->leftjoin('tbl_roster', 'tbl_roster.camp_id', '=', 'tbl_camp.id')
					->select('tbl_camp.id', 'tbl_camp.coach_id','tbl_camp.camp_focus', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_camp.starttime', 'tbl_camp.endtime', 'tbl_state_codes.state_name', 'tbllocation.Location', 'tbllocation.City', 'tbl_coach.first_name', 'tbl_coach.last_name', DB::raw('COUNT(tbl_roster.camp_id) as campercount'), DB::raw('SUM(tbl_roster.amount_paid) as camprevenue'));
					if (!empty($startdate) && !empty($enddate)) {
						$startdate = date('Y-m-d', strtotime($startdate));
						$enddate = date('Y-m-d', strtotime($enddate));
						$coachrevenueReportsSql = $coachrevenueReportsSql->where('tbl_camp.startdate', '>=', $startdate)->where('tbl_camp.enddate', '<=', $enddate);
					}	
		$coachrevenueReports = $coachrevenueReportsSql->where('tbl_roster.status', '=', 'Paid')->where('tbl_camp.coach_id', '=', $getCoachId->id)->groupBy('tbl_camp.id')->get();
		return $coachrevenueReports;
    }
}

?>