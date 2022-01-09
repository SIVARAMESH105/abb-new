<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Locations extends Model
{
    protected $table = 'tbllocation';
    protected $primaryKey = 'id';
    public $timestamps = false;
	
	public function getCityDetails($stateId){
		if($stateId !=''){
			$city_details = DB::table('tbllocation')
			->join("tbl_camp", "tbllocation.Id", "=", "tbl_camp.LocationId")
            ->select("tbllocation.City")
			->where([
			    ["tbllocation.State", "=", $stateId],
			    ["tbl_camp.status", "=", 1],
			])
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
            ->groupBy("tbllocation.City")
			->get();
			return $city_details;
		}
	}


	public function getLocationCampsByTitle($slug) {
		$geoPages = DB::table("tbl_geo_pages")->where('title', $slug)->first();
		//print_r($geoPages);exit;
		if(!empty($geoPages)) {
			$locDetails = DB::table($this->table)
			->leftjoin("tbl_camp", "tbllocation.Id", "=", "tbl_camp.LocationId")
			->leftjoin("tbl_geo_pages", "tbllocation.Id", "=", "tbl_geo_pages.location_id")
			->leftjoin("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")
            ->leftjoin("tbl_country", "tbl_country.country_id", "=", "tbllocation.Country")
            ->select("tbllocation.Location","tbllocation.City","tbllocation.State","tbllocation.Country","tbllocation.Zip","tbllocation.MapLink","tbllocation.AdditionalInfo","tbllocation.geo","tbl_camp.id","tbl_camp.camp_focus","tbllocation.Address","tbl_camp.CutoffDays","tbl_camp.EarlyBirdDiscount","tbl_camp.EarlyBirdDays","tbl_camp.cost","tbl_camp.contact","tbl_geo_pages.title","tbl_geo_pages.title_tag","tbl_geo_pages.description_tag","tbl_geo_pages.content","tbl_geo_pages.image","tbl_geo_pages.video", "tbl_geo_pages.transcript","tbl_camp.startdate", "tbl_camp.enddate", "tbl_camp.starttime", "tbl_camp.endtime", "tbl_country.country_code", DB::raw("DATE_FORMAT(tbl_camp.startdate, '%M %d, %Y') as startCamp"),DB::raw("DATE_FORMAT(tbl_camp.enddate, '%M %d, %Y') as endCamp"),DB::raw("DATE_FORMAT(tbl_camp.starttime, '%r') as campstarttime"),DB::raw("DATE_FORMAT(tbl_camp.endtime, '%r') as campendtime"),"tbl_state_codes.state_id","tbl_state_codes.state_name")
			->where(array("tbllocation.Id"=>$geoPages->location_id,"tbl_camp.status"=>1))
			->get();
			return $locDetails;
		}
		
	}
	
	public function getLocationByTitle($slug)
	{
		$geoPages = DB::table("tbl_geo_pages")->where('title', $slug)->first();
		if(!empty($geoPages)) {
			$location = DB::table($this->table)->leftjoin("tbl_state_codes", "tbl_state_codes.state_id", "=", "tbllocation.State")->where('Id', $geoPages->location_id)->first();
			if($location->geo == 'yes') {
				$geo = DB::table('tbl_geo_pages')->where('location_id', $location->Id)->first();
				if($geo) {
					$location->geoId = $geo->id;
					$location->geoPageTitle = $geo->title;
					$location->geoTitleTag = $geo->title_tag;
					$location->geoDescriptionTag = $geo->description_tag;
					$location->geoContent = $geo->content;
					$location->geoImage = $geo->image;
					$location->geoVideo = $geo->video;
					$location->geoTranscript= $geo->transcript;
					$location->image_alt_txt = $geo->image_alt_txt;
					$location->isAjaxUpload = $geo->isAjaxUpload;
				}
			}
			return $location;
		}
	}

	public function listCityDetails(){
			$city_details = DB::table('tbllocation')
			->leftjoin("tbl_camp", "tbllocation.Id", "=", "tbl_camp.LocationId")
			->leftjoin("tbl_state_codes", "tbllocation.State", "=", "tbl_state_codes.state_id")
			->leftjoin("tbl_geo_pages", "tbllocation.Id", "=", "tbl_geo_pages.location_id")
            ->select("tbllocation.City","tbllocation.Location", "tbl_state_codes.state_name","tbl_camp.camp_focus","tbllocation.Id","tbl_geo_pages.title")
			->where([
			    ["tbl_camp.status", "=", 1],
				["tbllocation.geo", "=", "yes"],
			])
			->whereDate('tbl_camp.startdate', '>', Carbon::now())
			->orderBy("tbl_state_codes.state_name")
            ->groupBy("tbllocation.City")
			->get();
			/*$finalResult = array();
			foreach($city_details as $key => $value){
				//echo $value."<br>";
				//echo "<pre>";print_r($value); echo "</pre>";
				$finalResult[$value->state_name][] = $value->City;
			}*/
			$result = array();
			$collection = collect($city_details);
			$changed = $collection->mapToGroups(function ($value, $key) {
				$result[$value->state_name]= $value;
				return $result;
			});
			return collect($changed)->toArray();
			//return $finalResult;
	}
}
