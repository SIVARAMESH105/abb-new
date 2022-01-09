<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;
use Carbon\Carbon;

class Camps extends Model
{
    protected $table = 'tbl_camp';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
    /* Get Camp Ajax detail */
    public function getMonth($data){
    	$city = $data['city_id'];
    	$state_id = $data['state_id'];
    	
    	$month_details = DB::table("tbl_camp")
    		->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
    		->select("tbl_camp.startdate", DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %Y') as startCamp"), "tbl_camp.id")
    		->where([
    			["tbllocation.City", "=", $city],
    			["tbllocation.State", "=", $state_id],
    			["tbl_camp.status", "=", 1]

    		])
    		->whereDate("tbl_camp.startdate", ">", Carbon::now())
    		->groupBy("tbl_camp.startdate")
    		->get();

    	return $month_details;
    	    
    }
    /*Find camp by Location and state*/
    public function campDetails($data){
    	$date = $data['date'];
    	$camp_details = DB::table("tbl_camp")
            ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select("tbl_camp.*", DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"), "tbllocation.*", "tbl_state_codes.state_id", "tbl_state_codes.state_name")
			->where([
			    ["tbl_state_codes.state_id", "=", $_GET['stateId']],
			    ["tbllocation.City", "=", $_GET['cityId']],
			])
			->whereRaw("date_format(tbl_camp.startdate, '%Y-%m') = date_format('$date', '%Y-%m')")
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
            ->get();
        return $camp_details;
    }
    /*Find camp by Date: getting city*/
    public function CityByDate($data){
    	$stateId = $data['stateId']; 
    	$month = $data['month'];
    	return DB::table("tbl_camp")
		    ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select("tbllocation.City")
            ->where([
				["tbl_camp.status", "=", 1],
				["tbllocation.State", "=", $stateId]

			])
			->whereRaw("date_format(tbl_camp.startdate, '%Y-%m') = date_format('$month', '%Y-%m')")
            ->groupBy("tbllocation.City")
            ->get();
    }

    /*Find camp by Date: getting state*/
    public function stateByDate($data){
    	$month = $data['month'];
    	return DB::table("tbl_camp")
		    ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select("tbl_state_codes.state_id","tbl_state_codes.state_name")
			->whereRaw("date_format(tbl_camp.startdate, '%Y-%m') = date_format('$month', '%Y-%m')")
			->where("tbl_camp.status", "=", 1)
			->orderBy("tbl_state_codes.state_name")
            ->groupBy("tbl_state_codes.state_name")
            ->get();
    }
     /*View all camps*/
    public function getAllCamps(){
    	return DB::table("tbl_camp")
            ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->select("tbl_camp.*",DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"), "tbllocation.*", "tbl_state_codes.state_id", "tbl_state_codes.state_name")
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
            ->get();
    }
     /*To get Active Start Date*/
    public function getCampsStartDate(){
    	return $active_camps_startdate = DB::table('tbl_camp')
			->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->select(DB::raw("DISTINCT(DATE_FORMAT(tbl_camp.startdate, '%M-01-%Y')) as camp_startdate"))
            ->where("tbl_camp.status", "=", 1)
            ->where("tbl_camp.startdate", ">=", Carbon::now())
			->get();
      // return DB::select("SELECT  DISTINCT(DATE_FORMAT(tbl_camp.startdate, '%M-01-%Y' )) as camp_startdate FROM tbl_camp INNER JOIN tbllocation ON tbllocation.Id = tbl_camp.LocationId where tbl_camp.status ='1' and tbl_camp.startdate >= CURDATE()");  
    }  

	public function getCampDetails($cid){
		if($cid !=''){
			$camp_details = DB::table('tbl_camp')
            ->join('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
            ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
            ->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
			->where('tbllocation.Country',$cid)
			->orderBy('tbl_state_codes.state_name','asc')
            ->get();
			return $camp_details;
		}else{
			$camp_details = DB::table('tbl_camp')
            ->join('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
            ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
            ->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
			->where('tbllocation.Country',1)
			->orderBy('tbl_state_codes.state_name','asc')
            ->get();
			return $camp_details;
		}
		
	}
	public function getStateCampDetails($sid){
			$camp_details = DB::table('tbl_camp')
            ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
            ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
            ->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
			->where('tbl_state_codes.state_id',$sid)
			->orderBy('tbl_state_codes.state_name','asc')
            ->get();
			return $camp_details;
	}
	
	public function getRegisterCampDetails($sid,$request_type){
			$camp_details = DB::table('tbl_camp')
            ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
            ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
            ->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
			->where('tbl_camp.id',$sid)
			->orderBy('tbl_state_codes.state_name','asc')
            ->get();
			if($request_type == 'saveregister'){
				return $camp_details[0];
			}
			return $camp_details;
	}
	
	public function getsortMonth($mid,$cid){
			if($mid == 0){
				$camp_details = DB::table('tbl_camp')
				->join('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
				->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
				->where('tbllocation.Country',$cid)
				->orderBy('tbl_state_codes.state_name','asc')
				->get();
				return $camp_details;
			}else{
				$camp_details = DB::table('tbl_camp')
				->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
				->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
				->where('tbllocation.Country',$cid)
				->whereMonth('tbl_camp.startdate',$mid)
				->orderBy('tbl_state_codes.state_name','asc')
				->get();
				return $camp_details;
			}
	}
	
	public function getRegisterUserCamp(){
			$camp_details = DB::table('tbl_camp')
            ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
            ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
            ->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
			->where('tbl_camp.id',$sid)
			->orderBy('tbl_state_codes.state_name','asc')
            ->get();
			if($request_type == 'saveregister'){
				return $camp_details[0];
			}
			return $camp_details;
	}
	
	public function getRegisterdCamp($cid){
			//echo $sid;die;
			$camp_details = DB::table('tbl_camp')
            ->leftjoin('tbllocation', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
            ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
            ->select('tbl_camp.*', 'tbllocation.*', 'tbl_state_codes.state_name')
			->where('tbl_camp.id',$cid)
			->orderBy('tbl_state_codes.state_name','asc')
            ->get();
			return $camp_details;
	}

	public function getCampName($campId){
		$camp = DB::table($this->table)->select('camp_focus')->where('id', $campId)->get();
		return $camp[0]->camp_focus;
	}
	
	public function getCamp($id) {
		$camp = DB::table($this->table)
				->join('tbllocation', 'tbl_camp.LocationId', '=', 'tbllocation.Id')
				->select('tbl_camp.*', 'tbllocation.Id', 'tbllocation.Location', 'tbllocation.City', 'tbllocation.State')
				->where('tbl_camp.id', '=', $id)
				->get();
		return $camp;
	}
	
	public function getStateName($id)
	{
		$stateName = DB::table('tbl_state_codes')->select('state_name')->where('state_id', '=', $id)->get();
		if(count($stateName) > 0) {
			return $stateName[0]->state_name;
		}
	}
	
	public function getSingleCampDetails($id) {
		$camp = DB::table($this->table)
				->join('tbllocation', 'tbl_camp.LocationId', '=', 'tbllocation.Id')
				->select('tbl_camp.*', 'tbllocation.Id', 'tbllocation.Location', 'tbllocation.City', 'tbllocation.State')
				->where('tbl_camp.id', '=', $id)
				->first();
		return $camp;
	}
}
