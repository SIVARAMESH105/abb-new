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
					$location[0]->geoContent = $geo[0]->content;
					$location[0]->geoImage = $geo[0]->image;
					$location[0]->geoVideo = $geo[0]->video;
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
		if($geo == 'yes') {
			$this->insertGeo($request, $inputData, $locationId);
		}
	}
	
	public function insertGeo($request, $inputData, $locationId)
	{
		$imageName = '';
		$videoName = '';
		$cityName = str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $inputData['City']));
		$stateObj = new ManageStates();
		$stateName = $stateObj->getStateName($inputData['State']);
		$pageTitle = $cityName.'-'.$stateName.'-basketball-camps';
		if($request->hasFile('image'))
		{
			$imageName = time().'_'.$request->file('image')->getClientOriginalName();
			$request->file('image')->move("public/uploads/images/geo/images", $imageName);
		}
		if($request->hasFile('video'))
		{
			$videoName = time().'_'.$request->file('video')->getClientOriginalName();
			$request->file('video')->move("public/uploads/images/geo/videos", $videoName);
		}
		$insert = DB::table('tbl_geo_pages')->insert(['location_id' => $locationId, 'title' => $pageTitle, 'content' => $inputData['geoTemplate'], 'image' => $imageName, 'video' => $videoName]);
		
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
	}
	
	public function updateGeo($request, $inputData)
	{
		$imageName = $inputData['existImage'];
		$videoName = $inputData['existVideo'];
		$cityName = str_replace(' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $inputData['City']));
		$stateObj = new ManageStates();
		$stateName = $stateObj->getStateName($inputData['State']);
		$pageTitle = $cityName.'-'.$stateName.'-basketball-camps';
		if($request->hasFile('image'))
		{
			$imageName = time().'_'.$request->file('image')->getClientOriginalName();
			$request->file('image')->move("public/uploads/images/geo/images", $imageName);
			\File::delete(public_path('public/uploads/images/geo/images/'.$inputData['existImage']));
			
		}
		if($request->hasFile('video'))
		{
			$videoName = time().'_'.$request->file('video')->getClientOriginalName();
			$request->file('video')->move("public/uploads/images/geo/videos", $videoName);
			\File::delete(public_path('public/uploads/images/geo/videos/'.$inputData['existVideo']));
		}
		$getGeoOldTitle = DB::table('tbl_geo_pages')->select('title')->where('location_id', $inputData['locationId'])->get();
		if(count($getGeoOldTitle) > 0) {
			$oldGeoPageTitle = $getGeoOldTitle[0]->title;
		} else {
			$oldGeoPageTitle = '';
		}
		$update = GeoLocatedPages::updateOrCreate(['location_id' => $inputData['locationId']], ['title' => $pageTitle, 'content' => $inputData['geoTemplate'], 'image' => $imageName, 'video' => $videoName]);
		
		#Updating geo page url in sitemap.xml
		if($oldGeoPageTitle != $pageTitle)
		{
			$this->sitemap('update', $oldGeoPageTitle, $pageTitle);
		}
	}
	
	public function destroyGeo($id)
	{
		$geo = $this->getGeoEntry($id);
		if(count($geo) > 0 && $geo[0]->image != '') {
			\File::delete(public_path('public/uploads/images/geo/images/'.$geo[0]->image));
		}
		if(count($geo) > 0 && $geo[0]->video != '') {
			\File::delete(public_path('public/uploads/images/geo/videos/'.$geo[0]->video));
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
