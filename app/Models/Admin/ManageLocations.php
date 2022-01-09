<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin\GeoLocatedPages;
use App\Models\Admin\ManageStates;
use Backpack\CRUD\CrudTrait;
use DB;
use URL;

class ManageLocations extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbllocation';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    //protected $fillable = ['Location', 'Address', 'City', 'State', 'Country', 'Zip', 'AdditionalInfo'];
    // protected $guarded = ['id'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function getEntry($id)
	{
		$location = DB::table($this->table)->where('Id', $id)->get();
		if(count($location) > 0) {
			if($location[0]->geo == 'yes') {
				$geo = DB::table('tbl_geo_pages')->where('location_id', $location[0]->Id)->get();
				if(count($geo) > 0) {
					$location[0]->geoId = $geo[0]->id;
					$location[0]->geoPageTitle = $geo[0]->title;
					$location[0]->geoTitleTag = $geo[0]->title_tag;
					$location[0]->geoDescriptionTag = $geo[0]->description_tag;
					$location[0]->geoContent = $geo[0]->content;
					$location[0]->geoImage = $geo[0]->image;
					$location[0]->geoVideo = $geo[0]->video;
					$location[0]->geoTranscript = $geo[0]->transcript;  
					$location[0]->image_alt_txt = $geo[0]->image_alt_txt;
					$location[0]->isAjaxUpload = $geo[0]->isAjaxUpload;
				}
			}
			return $location;
		}
	}
	
	public function getGeoEntry($id)
	{
		$geo = DB::table('tbl_geo_pages')->where('location_id', $id)->get();
		return $geo;
	}
	
	public function insertLocation($request)
	{
		$inputData = $request->all();
		if(isset($inputData['geoCheckbox'])) {
			$geo = $inputData['geoCheckbox'];
		} else {
			$geo = 'no';
		}
		$locationId = DB::table($this->table)->insertGetId(
						['Location' => $inputData['Location'], 'Address' => $inputData['Address'], 'City' => $inputData['City'], 'Country' => $inputData['Country'], 'State' => $inputData['State'], 'Zip' => $inputData['Zip'], 'AdditionalInfo' => $inputData['AdditionalInfo'], 'geo' => $geo]
						);
		//Insert director
		if(!empty($inputData['director'])) {
			$director = DB::table("tbl_directors")->insertGetId(["location_id"=>$locationId, "director"=>$inputData['director']]);
		}
		
		if($geo == 'yes') {
			$this->insertGeo($request, $inputData, $locationId);
		}
	}
	
	public function insertGeo($request, $inputData, $locationId)
	{
		$imageName = '';
		$videoName = '';
		$tranScriptName = '';
		$cityName = str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $inputData['City']));
		$stateObj = new ManageStates();
		$stateName = $stateObj->getStateName($inputData['State']);
		//$pageTitle = $cityName.'-'.$stateName.'-basketball-camps';
		$pageTitle = str_replace(' ', '-', preg_replace("/[^A-Za-z0-9- ]/", '', strtolower($inputData['title'])));
		$title_tag = $inputData['titletag'];
		$description_tag = $inputData['desctag'];
		$tempPath = public_path('/uploads/tempfeatureimages/');
        $destinationPath = public_path('/uploads/images/geo/images/');
        $videoDestinationPath = public_path('/uploads/images/geo/videos/');
        $tranScriptDestinationPath = public_path('/uploads/images/geo/transcript/');
		$isAjaxUpload='';
		if(trim($request['image']!=''))
		{
			try{
				$imageName = time().'_'.$request['image'];
				//$request->file('image')->move("public/uploads/images/geo/images", $imageName);
				copy($tempPath.$request['image'],$destinationPath.$imageName);
				\File::delete($tempPath.$request['image']);
			} catch(\Exception $e) {
				echo $e->getMessage();
			}
		}
		
		if(trim($request['video']!=''))
		{
			try{
				//$videoName = time().'_'.$request->file('video')->getClientOriginalName();
				//$request->file('video')->move("public/uploads/images/geo/videos", $videoName);
				$videoName = time().'_'.$request['video'];
				$isAjaxUpload = 0;
				copy($tempPath.$request['video'], $videoDestinationPath.$videoName);
				\File::delete($tempPath.$request['video']);
			} catch(\Exception $e) {
				echo $e->getMessage();
			}
		} elseif(trim($request['ajxvideo'])!='') {
			$videoName = $request['ajxvideo'];
			$isAjaxUpload = 1;
		}
		
		if(trim($request->file('transcript')!=''))
		{
			$tranScriptName = time().'_'.$request->file('transcript')->getClientOriginalName();
			$request->file('transcript')->move(public_path("/uploads/images/geo/transcript"), $tranScriptName);
		}
		
		$insert = DB::table('tbl_geo_pages')->insert(['location_id' => $locationId, 'title' => $pageTitle, 'title_tag'=>$title_tag, 'description_tag'=>$description_tag, 'content' => $inputData['geoTemplate'], 'image' => $imageName, 'video' => $videoName,'transcript' => $tranScriptName,'image_alt_txt'=>$inputData['alt'], 'isAjaxUpload' => $isAjaxUpload]);
		
		#Adding geo page url to sitemap.xml
		$this->sitemap('add', '', $pageTitle);
	}
	
	public function updateLocation($request)
	{
		$inputData = $request->all(); 
		if(!isset($inputData['geoCheckbox'])) {
			$geo = 'no';
			$this->destroyGeo($inputData['locationId']);
		} else {
			$geo = $inputData['geoCheckbox'];
			$this->updateGeo($request, $inputData);
		}
		$update = DB::table($this->table)->where('Id', $inputData['locationId'])->update(
					['Location' => $inputData['Location'], 'Address' => $inputData['Address'], 'City' => $inputData['City'], 'Country' => $inputData['Country'], 'State' => $inputData['State'], 'Zip' => $inputData['Zip'], 'AdditionalInfo' => $inputData['AdditionalInfo'], 'geo' => $geo]
					);
		//update director
		if(!empty($inputData['director'])) {
			$rows = DB::table("tbl_directors")->where('location_id', $inputData['locationId'])->count();
			if($rows>0) {
				$director = DB::table("tbl_directors")->where('location_id', $inputData['locationId'])->update(["director"=>$inputData['director']]);
			} else {
				$director = DB::table("tbl_directors")->insertGetId(["location_id"=>$inputData['locationId'], "director"=>$inputData['director']]);
			}
		}
	}
	
	public function updateGeo($request, $inputData)
	{
		$imageName = $inputData['existImage'];
		$videoName = $inputData['existVideo'];
	    $tranScriptName = $inputData['existTranscript'];
	
		$cityName = str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $inputData['City']));
		$stateObj = new ManageStates();
		$stateName = $stateObj->getStateName($inputData['State']);
		//$pageTitle = $cityName.'-'.$stateName.'-basketball-camps';
		$pageTitle = str_replace(' ', '-', preg_replace("/[^A-Za-z0-9- ]/", '', strtolower($inputData['title'])));
		$title_tag = $inputData['titletag'];
		$description_tag = $inputData['desctag'];
		$tempPath = public_path('/uploads/tempfeatureimages/');
        $destinationPath = public_path('/uploads/images/geo/images/');
        $videoDestinationPath = public_path('/uploads/images/geo/videos/');
        $tranScriptDestinationPath = public_path('/uploads/images/geo/transcript/');
		$isAjaxUpload='';
		if(trim($request['image']!=''))
		{
			
			try{
				//$imageName = time().'_'.$request->file('image')->getClientOriginalName();
				//$request->file('image')->move("public/uploads/images/geo/images", $imageName);
				$imageName = time().'_'.$request['image'];
				copy($tempPath.$request['image'], $destinationPath.$imageName);
				\File::delete(public_path('/uploads/images/geo/images/'.$inputData['existImage']));
			} catch(\Exception $e) {
				echo $e->getMessage();
			}
			
		}
		if(trim($request['video']!=''))
		{
			//$videoName = time().'_'.$request->file('video')->getClientOriginalName();
			//$request->file('video')->move("public/uploads/images/geo/videos", $videoName);
			$videoName = time().'_'.$request['video'];
			$isAjaxUpload = 0;
			copy($tempPath.$request['video'], $videoDestinationPath.$videoName);
			\File::delete(public_path('/uploads/images/geo/videos/'.$inputData['existVideo']));
		} elseif(trim($request['ajxvideo'])!='') {
			$videoName = $request['ajxvideo'];
			$isAjaxUpload = 1;
		} else {
			$isAjaxUpload=$request['isAjaxUpload'];
		}
		
		if(trim($request->file('transcript')!=''))
		{
            $inputData['existTranscript'];
			$tranScriptName = time().'_'.$request->file('transcript')->getClientOriginalName();
			$request->file('transcript')->move(public_path("/uploads/images/geo/transcript"), $tranScriptName);
		    \File::delete(public_path('uploads/images/geo/transcript/'.$inputData['existTranscript']));
		    
		}
		
		$getGeoOldTitle = DB::table('tbl_geo_pages')->select('title')->where('location_id', $inputData['locationId'])->get();
		if(count($getGeoOldTitle) > 0) {
			$oldGeoPageTitle = $getGeoOldTitle[0]->title;
		} else {
			$oldGeoPageTitle = '';
		}
		$update = GeoLocatedPages::updateOrCreate(['location_id' => $inputData['locationId']], ['title' => $pageTitle,'title_tag'=>$title_tag, 'description_tag'=>$description_tag, 'content' => $inputData['geoTemplate'], 'image' => $imageName, 'video' => $videoName,'transcript' => $tranScriptName, 'image_alt_txt'=>$inputData['alt'],'isAjaxUpload' => $isAjaxUpload]);
		
		#Updating geo page url in sitemap.xml
		if($oldGeoPageTitle != $pageTitle)
		{
			$this->sitemap('update', $oldGeoPageTitle, $pageTitle);
		}
	}

	public function getCampLocation($id)
	{
		$data = DB::table("tbl_camp")->select(DB::raw("COUNT(LocationId) as camp_count"))->where('LocationId', '=', $id)->get();
		return $data[0]->camp_count;	
	}  
	
	public function destroyGeo($id)
	{
		$geo = $this->getGeoEntry($id);
		if(count($geo) > 0 && $geo[0]->image != '') {
			\File::delete(public_path('/uploads/images/geo/images/'.$geo[0]->image));
		}
		if(count($geo) > 0 && $geo[0]->video != '') {
			\File::delete(public_path('/uploads/images/geo/videos/'.$geo[0]->video));
		}
		if(count($geo) > 0 && $geo[0]->transcript != '') {
			\File::delete(public_path('/uploads/images/geo/transcript/'.$geo[0]->video));
		}
		$deleteGeo = DB::table('tbl_geo_pages')->where('location_id', $id)->delete();
	}
	
	public function sitemap($requestType, $oldGeoPageTitle, $newPageTitle)
	{
		$simplexml = simplexml_load_file(URL::to('/public/sitemap.xml'));
		$dom = new \DOMDocument('1.0');
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML($simplexml->asXML());
		$xml = new \SimpleXMLElement($dom->saveXML());
		if($requestType == 'update')
		{
			list($url) = $simplexml->xpath("/urlset/url[loc = '$oldGeoPageTitle']") + [NULL];
			if(isset($url->loc)) {
				$url->loc = $newPageTitle;
			} else {
				$pageUrl = $xml->addChild('url');
				$pageUrl->addChild('loc', $newPageTitle);
			}
		}
		else if($requestType == 'delete')
		{
			list($url) = $simplexml->xpath("/urlset/url[loc = '$oldGeoPageTitle']") + [NULL];
			//list($prev) = $url->xpath('preceding-sibling::*[1]');
			unset($url->loc);
		}		
		if($requestType == 'add')
		{
			$pageUrl = $xml->addChild('url');
			$pageUrl->addChild('loc', $newPageTitle);
		}
		Storage::disk('sitemap')->put('sitemap.xml', $xml->saveXML());
	}
	
	public function getLocationName($id)
	{
		$LocationName = DB::table($this->table)->select('Location')->where('Id', '=', $id)->get();
		if(count($LocationName) > 0) {
			return $LocationName[0]->Location;
		}
	}
	
	public function getStateCityName($id)
	{
		$stateCity = DB::table($this->table)->select('City', 'State')->where('Id', '=', $id)->get();
		if(count($stateCity) > 0) {
			$stateObj = new ManageStates();
			$stateCode = $stateObj->getStateCode($stateCity[0]->State);
			return $stateCode.'/'.$stateCity[0]->City;
		}
	}
	
    // For Roster report (ReportController)
    public function getCityList()
    {
        $cityList = DB::table($this->table)->select('Id', 'City')->where('City', '!=', '')->groupBy('City')->get();
        return $cityList;
    }
	public function getCityListByCity($cityName)
    {
		$city = DB::table($this->table)->select('Id', 'City')->where('City', '=', trim($cityName))->first();
        return $city;
    }
    public function getLocationList()
    {
        $locationList = DB::table($this->table)->select('Id', 'Location')->where('Location', '!=', '')->groupBy('Location')->get();
        return $locationList;
    }
	
	public function getLocationListByName($lname)
    {
        $locationList = DB::table($this->table)->select('Id', 'Location')->where('Location', 'like', trim($lname))->first();
        return $locationList;
    }
	
	/*
	 * To verify the slug url
	 * @param array locationId and slugurl
	 * return int count
	*/
	public function toVerifySlugUrl($inputData) {
		if($inputData['location']=="edit") {
			$getGeoTitleCount = DB::table("tbl_geo_pages")->select('Id', 'location_id', "title")->where(array("location_id"=>$inputData['locationId'],"title"=>$inputData['slugurl']))->count();
		} else {
			$getGeoTitleCount = DB::table("tbl_geo_pages")->select('Id', 'location_id', "title")->where("title", $inputData['slugurl'])->count();
		}
		return $getGeoTitleCount;
	}
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
	public function country() {
		return $this->belongsTo('App\Models\Admin\ManageCountry', 'Country');
	}
	
	public function state() {
		return $this->belongsTo('App\Models\Admin\ManageStates', 'State');
	}

	public function getDataCityName($id){
		$location = DB::table($this->table)
		->leftjoin('tbl_camp', 'tbllocation.Id', '=', 'tbl_camp.LocationId')
        ->select('tbllocation.*','tbl_camp.*')
		->where([
		["tbllocation.Id", $id],
		["tbllocation.geo", "yes"],
		])->groupBy('tbl_camp.LocationId')->get();
		return $location;
	}
	
	public function getDirectorList($locationId)
	{
		$directors = DB::table('tbl_directors')->where('location_id', $locationId)->first();
		return $directors;
	}
	
	public function getCampLocationStates($name) {
		$getCityState = DB::table("tbllocation")->leftjoin('tbl_directors', "tbl_directors.location_id", "=", "tbllocation.id")->select("City","State", "Location")->where("tbl_directors.director",$name)->groupBy('State')->get();
		return $getCityState;
	}
	
	/*
	* This function is used to get the result of city name by using state id
	* @param array $data 
	* return result of object
	*/
	public function getStateReportCityName($id)
	{
		$data = explode(",",$id);
		$cityNameSql = DB::table($this->table)->select('Id','City','Location');
					if(in_array('all',$data) || $id=="all"){
						$cityNameSql->where('City', '!=', '')->groupBy('City');
					} else {
						$cityNameSql->whereIn('State', $data);
					}
		$cityName = $cityNameSql->get();
	    return $cityName;
	}
	/*
	* This function is used to get the result of Location name by using city id
	* @param string $data 
	* return result of object
	*/
	public function getCityReportLocationName($id)
	{
		//For multi select data convert into array of string
		$data = explode(",",$id);
		$locationNameSql = DB::table($this->table)->select('Id','Location');
						if(in_array('all',$data) || $id=="all"){
							$locationNameSql->where('Location', '!=', '')->groupBy('Location');
						} else {
							$locationNameSql->whereIn('Id', $data );
						}
		$locationName=$locationNameSql->get();
	    return $locationName;
	}
	/*
	* This function is used to get the result of camp name by using location id
	* @param string $data 
	* return result of object
	*/
	public function getLocationReportCampName($id) 
    {
    	$data = explode(",",$id);
		$campNamesSql = DB::table($this->table)
				->join('tbl_camp', 'tbl_camp.LocationId', '=', 'tbllocation.Id')
				->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                ->select('tbl_camp.camp_focus', 'tbl_camp.id','tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_state_codes.state_code', 'tbllocation.Location', 'tbllocation.City');
				if(!in_array('all',$data) || $id!="all"){
					$campNamesSql->whereIn('tbl_camp.LocationId', $data );
				}
				$campNamesSql->where('tbl_camp.status', '=', '1');
        $campNames=$campNamesSql->orderBy('tbl_camp.camp_focus', 'ASC')
                ->groupBy('tbl_camp.id')
                ->get();
		return $campNames;
    }

    /*
	* This function is used to get the result of coach name by using diector name
	* @param string $data 
	* return result of object
	*/

    public function getDirectorReportCoachName($id) 
    {
    	$data = explode(",",$id);
		if(in_array('all',$data) || $id=="all"){
			$coachName = DB::table('tbl_coach')->orderBy('first_name', 'ASC')->get();
		} else {
	        $coachName = DB::table('tbl_directors')
                        ->join('tbl_camp', 'tbl_camp.LocationId', '=', 'tbl_directors.location_id')
                        ->join('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
                        ->join('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
                        ->select('tbl_coach.id','tbl_coach.first_name', 'tbl_coach.last_name')
						->whereIn('tbl_directors.director', $data)
						->groupBy('tbl_coach.id')
                        ->get();
        }
        return $coachName;
    }
	
     /*
	* This function is used for "Director login on revenue report" to get the result of camp name
	* @param string $data 
	* return result of object
	*/


    public function getCampListDirector($name) {
		$getDirector = DB::table('tbl_directors')
                        ->join('tbl_camp', 'tbl_camp.LocationId', '=', 'tbl_directors.location_id')
                        ->join('tbllocation', 'tbllocation.Id','=','tbl_camp.LocationId' )
                        ->join('tbl_state_codes', 'tbl_state_codes.state_id', '=', 'tbllocation.State')
                        ->select('tbl_camp.camp_focus', 'tbl_camp.id','tbl_camp.startdate', 'tbl_camp.enddate', 'tbl_state_codes.state_code', 'tbllocation.Location', 'tbllocation.City')
						->where('tbl_directors.director', $name)
						->where('tbl_camp.status', '=', '1')
                		->orderBy('tbl_camp.camp_focus', 'ASC')
                		->groupBy('tbl_camp.id')
                        ->get();
		return $getDirector;
	}
	 /*
	* This function is used for "Director login on revenue report" to get the result of coach name
	* @param string $data 
	* return result of object
	*/
	public function getCoachListDirector($name) {
		$getCoach =DB::table('tbl_directors')
                        ->join('tbl_camp', 'tbl_camp.LocationId', '=', 'tbl_directors.location_id')
                        ->join('tbl_coachcamp', 'tbl_coachcamp.camp_id', '=', 'tbl_camp.id')
                        ->join('tbl_coach', 'tbl_coach.id', '=', 'tbl_coachcamp.coach_id')
                        ->select('tbl_coach.id','tbl_coach.first_name', 'tbl_coach.last_name')
						->where('tbl_directors.director', $name)
						->groupBy('tbl_coach.id')
                        ->get();
        return $getCoach;
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
