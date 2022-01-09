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
    		->groupBy("startCamp")
    		->get();

    	return $month_details;
    	    
    }
    /*Find camp by Location and state*/
    public function campDetails($data){
    	$date = $data['date'];
    	$camp_details = DB::table("tbl_camp")
            ->join("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->join("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->leftjoin("tbl_country", "tbl_country.country_id", "=", "tbllocation.Country")
            ->select("tbl_camp.*", 'tbl_country.country_code', DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"), "tbllocation.*", "tbl_state_codes.state_id", "tbl_state_codes.state_name")
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
            ->leftjoin("tbl_country", "tbl_country.country_id", "=", "tbllocation.Country")
            ->select("tbl_camp.*", "tbl_country.country_code",DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"), "tbllocation.*", "tbl_state_codes.state_id", "tbl_state_codes.state_name")
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
            ->orderBy("tbl_state_codes.state_name")
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

	/**
		*Purpose   :For Search data concept using camp and cms content
		*Parameter :Array of search data come.
		*return    :Array of cms content,Location,and camp information
		*Comments1 :If Search data is one ->we can search the data by city,state and locationname wise.
		*Comments2 :If Search data is two ->we can search the data by city and statecode only .
		*Comments2 :If Search data is threee ->we can search the data by locationname  and content wise .
	**/

	public function getSearchCampDetails($data) {
        //To get the count of array data.
		$searchCount = count($data);
        $city ='';
        $stateCode ='';
        $campResult = array();
        $cmsContentRes = array();
        if($searchCount>1) {
        	$city = $data['0'];
        	$stateCode = $data['1'];
        	$locationName = implode(" ",$data);  	
        } else {
       		$city = $data['0'];
       		$locationName = $data['0'];
       		$stateName = $data['0']; 	
        }
       	$campsql=DB::table($this->table)->select("tbl_camp.id","tbl_camp.camp_focus","tbl_camp.Address","tbl_camp.CutoffDays","tbl_camp.EarlyBirdDiscount","tbl_camp.EarlyBirdDays","tbl_camp.cost","tbl_camp.contact", DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startdate"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as enddate"),DB::raw("DATE_FORMAT(tbl_camp.starttime, '%r') as starttime"),DB::raw("DATE_FORMAT(tbl_camp.endtime, '%r') as endtime"),'tbl_state_codes.state_name','tbllocation.*')->leftJoin("tbllocation", "tbllocation.Id", "=", "tbl_camp.LocationId")->leftJoin("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State");
        
        if($searchCount > 1) {
        	$campsql->where("tbllocation.City", "like", "%$city%");
        	$campsql->where("tbl_state_codes.state_code", "like", "%$stateCode%");
        	$campsql->orWhere("tbllocation.Location", "like", "%$locationName%");
        } else {
        	
			$campsql->where("tbllocation.City", "like", "%$city%");
			$campsql->orWhere("tbllocation.Location", "like", "%$locationName%");
			$campsql->orWhere("tbl_state_codes.state_name", "like", "%$stateName%");

        }
        $campResult = $campsql->get();

        //cms content result
        if($searchCount) {
			$content = implode(" ",$data);
			$cmssql =DB::table("tbl_cms_content");
			$cmssql->where("content", "like", "%$content%");
			$cmssql->whereNotIn("id",  ["1", "2"]);

        }
        $cmsContentRes = $cmssql->get();

        /*Based on Location search using sql query if geo-track location on yes.
        */
        
        $locationSql= DB::table("tbllocation")
			->leftjoin("tbl_camp", "tbllocation.Id", "=", "tbl_camp.LocationId")
			->leftjoin("tbl_geo_pages", "tbllocation.Id", "=", "tbl_geo_pages.location_id")
			->leftjoin("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->leftjoin("tbl_country", "tbl_country.country_id", "=", "tbllocation.Country")
            ->select("tbllocation.Location","tbllocation.City","tbllocation.State","tbllocation.Country","tbllocation.Zip","tbllocation.MapLink","tbllocation.AdditionalInfo","tbllocation.geo","tbl_camp.id","tbl_camp.camp_focus","tbl_camp.Address","tbl_camp.CutoffDays","tbl_camp.EarlyBirdDiscount","tbl_camp.EarlyBirdDays","tbl_camp.cost","tbl_camp.contact","tbl_geo_pages.title","tbl_geo_pages.title_tag","tbl_geo_pages.description_tag","tbl_geo_pages.content","tbl_geo_pages.image","tbl_geo_pages.video", "tbl_camp.startdate", "tbl_camp.enddate", "tbl_camp.starttime", "tbl_camp.endtime", "tbl_country.country_code", DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"),DB::raw("DATE_FORMAT(tbl_camp.starttime, '%r') as campstarttime"),DB::raw("DATE_FORMAT(tbl_camp.endtime, '%r') as campendtime"),"tbl_state_codes.state_id","tbl_state_codes.state_name");
		if($searchCount>1) {
			$locationSql->where("tbllocation.geo","=","yes");
	     	$locationSql->where("tbl_camp.status","=","1");
	     	$locationSql->where("tbllocation.City", "like", "%$city%");
	     	$locationSql->where("tbl_state_codes.state_code", "like", "%$stateCode%");
	    }
		else {
			$locationSql->where("tbllocation.geo","=","yes");
	     	$locationSql->where("tbl_camp.status","=","1");
	        $locationSql->where(function($locationSql) use ($city, $locationName,$stateName)
	        {
				$locationSql->where("tbllocation.City", "like", "%$city%")
				->orWhere("tbllocation.Location", "like", "%$locationName%")
				->orWhere("tbl_state_codes.state_name", "like", "%$stateName%");

	        });
   		}
		
         $locationResult = $locationSql->get();  
        return array("camsRes"=>$campResult, "cmsContent" =>$cmsContentRes,"locationRes"=>$locationResult);
		
	}
}
