<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageLocations;
use App\Models\Admin\ManageCountry;
use App\Models\Admin\ManageStates;
use App\Models\Admin\VideoGallery;
use App\Models\Admin\DirectorListReports;
use URL;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageLocationsRequest as StoreRequest;
use App\Http\Requests\EditLocationsRequest as UpdateRequest;
use Illuminate\Http\Request;
use App\Helpers;

class ManageLocationsCrudController extends CrudController
{
    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageLocations');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageLocations');
        $this->crud->setEntityNameStrings('Location', 'Manage Locations');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'Location',
										'label' => 'Camp Location',
										'type'  => 'text',
									],
									[
										'label' => 'Camp State',
										'type'  => 'select',
										'name' => 'State', // the db column for the foreign key
										'entity' => 'state', // the method that defines the relationship in your Model
										'attribute' => 'state_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageStates" // foreign key model
									],
									[
										'name'  => 'City',
										'label' => 'Camp City',
										'type'  => 'text',
									]
								]);
								
		$this->crud->addFields([
									[
										'name'  => 'Location',
										'label' => 'Camp Location',
										'type'  => 'text',
									],
									[
										'name'  => 'Address',
										'label' => 'Address',
										'type'  => 'text'
									],
									[
										'name'  => 'City',
										'label' => 'City',
										'type'  => 'text'
									],
									[
										'label' => 'Country',
										'type'  => 'select',
										'name' 	=> 'Country', // the db column for the foreign key
										'entity' => 'country', // the method that defines the relationship in your Model
										'attribute' => 'country_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageCountry" // foreign key model
									],
									[
										'label' => 'State',
										'type'  => 'select',
										'name' 	=> 'State', // the db column for the foreign key
										'entity' => 'state', // the method that defines the relationship in your Model
										'attribute' => 'state_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageStates" // foreign key model
									],
									[
										'name'  => 'Zip',
										'label' => 'Zip',
										'type'  => 'text'
									],
									[
										'name'  => 'AdditionalInfo',
										'label' => 'Additional Information',
										'type'  => 'tinymce'
									],
									
								]);
		$this->crud->addClause('join', 'tbl_state_codes', 'tbl_state_codes.state_id', 'tbllocation.State');
		// ------ CRUD BUTTONS
		//$this->crud->removeButton('update');
    }
	
	public function create()
	{
		$countryObj = new ManageCountry();
		$stateObj = new ManageStates();
		$videoObj = new VideoGallery();
		$directorObj = new DirectorListReports();
		$this->data['crud'] = $this->crud;
		$this->data['countries'] = $countryObj->countryList();
		$this->data['states'] = $stateObj->stateList();
		$this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;
		$directors = $directorObj->getDirectorList();
		$names = array();
		if(count($directors)>0) {
			foreach($directors as $director) {
				$names[] = $director->name;
			}
		}
		$this->data['directors'] = $names;
		$this->data['defaultGeoTemplateText'] = Helpers::defaultGeoTemplateText();
		$this->data['videoLists'] = $videoObj->getLists();
		return view('Admin.addLocation', $this->data);
	}

    public function store(StoreRequest $request)
    {
		$locationObj = new ManageLocations();
		$storeLocation = $locationObj->insertLocation($request);
		\Alert::success('Location added successfully')->flash();
		return \Redirect::to('admin/manageLocations');
    }
	
	public function edit($id)
	{
		$locationObj = new ManageLocations();
		$countryObj = new ManageCountry();
		$stateObj = new ManageStates();
		$videoObj = new VideoGallery();
		$directorObj = new DirectorListReports();
		$this->data['entry'] = $this->crud->getEntry($id);
		$this->data['content'] = $locationObj->getEntry($id);
		$this->data['crud'] = $this->crud;
		$this->data['countries'] = $countryObj->countryList();
		$this->data['states'] = $stateObj->stateList();
		//$this->data['fields'] = $this->crud->getCreateFields();
		$this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;
		//get state code from modal
		$this->data['stateCode'] = $stateObj->getStateName($this->data['content'][0]->State);
		//$this->data['directors'] = Helpers::directors();
		$directors = $directorObj->getDirectorList();
		$names = array();
		if(count($directors)>0) {
			foreach($directors as $director) {
				$names[] = $director->name;
			}
		}
		$this->data['directors'] = $names;
		$this->data['dlist'] = $locationObj->getDirectorList($id);
		$this->data['videoLists'] = $videoObj->getLists();
		return view('Admin.editLocation', $this->data);
	}

    public function update(UpdateRequest $request)
    {
		$locationObj = new ManageLocations();
		$update = $locationObj->updateLocation($request);
		\Alert::success('Location updated successfully')->flash();
		return \Redirect::to('admin/manageLocations');
    }
	
	public function destroy($id)
	{
		$locationObj = new ManageLocations();
		$count = $locationObj->getCampLocation($id);
		if($count>=1){
			\Alert::warning('Location not deleted, If Camps already associated with them.')->flash();  
			$message = 'Not Deleted';
			return $message;
		}else{
		    $geo = $locationObj->getGeoEntry($id);
			if(count($geo) > 0) {
				$geoTitle = $geo[0]->title;
				$locationObj->sitemap('delete', $geoTitle, '');
				$locationObj->destroyGeo($id);		
			}
			#crud core functionality: destroying location entry
			$this->crud->hasAccessOrFail('delete');
	        return $this->crud->delete($id); 
    	}  
	}
	
	public function getStateCityNameByAjax($id)
	{
		$locationObj = new ManageLocations();
		return $stateCityName = $locationObj->getStateCityName($id);
	}

	

	/*
	 * To verify the slug url
	 * @param array locationId and slugurl
	 * return int count
	*/
	public function toVerifySlugUrl(Request $request) {
		$locationObj = new ManageLocations();
		$getCount = $locationObj->toVerifySlugUrl($request->all());
		return $getCount;
	}
	

	public function getStructuredDataCity($id)
    {
        $locationObj = new ManageLocations();
        $stateCityName = $locationObj->getDataCityName($id);
        $stateObj = new ManageStates();
        $state_name = $stateObj->getStateName($stateCityName[0]->State);
        $countryObj = new ManageCountry();
        $country_code = $countryObj->getCountryCode($stateCityName[0]->Country);
        return response()->json([
            "@context" => "http://schema.org",
            "@type" => "ChildrensEvent",
            "location" => array("@type" => "Place","address" => array("@type" => "PostalAddress","streetAddress" => $stateCityName[0]->Address,
            "addressLocality" => $stateCityName[0]->City,"addressRegion" => $state_name,"postalCode" => $stateCityName[0]->Zip,"addressCountry" =>$country_code),"name" => $stateCityName[0]->Location),
            "name" => $stateCityName[0]->camp_focus,
            "offers" => array(
                "@type" => "Offer",
                "availability" =>"http =>//schema.org/LimitedAvailability",
                "availabilityEnds" =>"2019-08-01T09 =>00",
                "offeredBy" => array(
                    "@type" => "Corporation",
                    "contactPoint" => array(
                    "@type" => "ContactPoint",
                    "areaServed"  => "US",
                    "contactType" => "Sales",
                    "email"  => "info@advantagebasketball.com", //Main Contact Point Email
                    "telephone"  => "+1-425-670-8877"//Main Contact Point Telephone
                    ),
                    "address" => array(
                    "@type" => "PostalAddress",
                    "postOfficeBoxNumber" => "1344",
                    "addressLocality" => "Lynnwood",
                    "addressRegion" => "WA",
                    "postalCode" => "98046",
                    "addressCountry" => $country_code),
                    "identifier" =>array("@type" =>"PropertyValue","propertyID" =>"UBI","value" =>"601600614"),
                    "image" => "https =>//www.advantagebasketball.com/public/images/logo-image.png",
                    "legalName" => "Hummel Enterprises, Inc.",
                    "name" => "Advantage Basketball Camps",
                    "sameAs" =>    "https =>//www.linkedin.com/company/advantage-basketball-camps",
                    "telephone" =>    "+1-425-670-8877",
                    "url" =>    "https =>//www.advantagebasketball.com/"
                ),
                "price" => $stateCityName[0]->cost,
                "priceCurrency" => "USD",
                "url" => "https =>//www.advantagebasketball.com/camp/register/3625"
              ),
            "startDate"=>$stateCityName[0]->startdate . 'T'.$stateCityName[0]->starttime,
            "endDate" => $stateCityName[0]->enddate . 'T'.$stateCityName[0]->endtime,
            "typicalAgeRange" => "6-18"
        ]);
    }

    /*
	 * To display the city name under state id wise.
	 * @param string stateid
	 * return int count
	*/
	public function getStateReportCityNameByAjax(Request $request)
	{
		if(count($request['stateId'])>1) {
			$id = implode(",", $request['stateId']);
		} else {
			$id= $request['stateId'][0];
		}
		$locationObj = new ManageLocations();
		$data['cityName'] = $locationObj->getStateReportCityName($id);
		$data['count'] = count($data['cityName']);
		return view('Admin.RevenueReport.cityFilter', $data);
	}
	/*
	 * To display the location name using city id wise.
	 * @param string stateid
	 * return int count
	*/
	public function getCityReportLocationNameByAjax(Request $request)
	{
		if(count($request['city_id'])>1) {
			$id = implode(",", $request['city_id']);
		} else {
			$id= $request['city_id'][0];
		}
		
		$locationObj = new ManageLocations();
		$data['locationName'] = $locationObj->getCityReportLocationName($id);
		$data['count'] = count($data['locationName']);
		return view('Admin.RevenueReport.locationFilter', $data);
	}
	/*
	 * To display the camp name using locationid wise.
	 * @param string stateid
	 * return int count
	*/
	public function getLocationReportCampNameByAjax(Request $request)
	{
		if(count($request['location_id'])>1) {
			$id = implode(",", $request['location_id']);
		} else {
			$id= $request['location_id'][0];
		}
		
		$locationObj = new ManageLocations();
		$data['campName'] = $locationObj->getLocationReportCampName($id);
		$data['count'] = count($data['campName']);
		return view('Admin.RevenueReport.campFilter', $data);
	}
	/*
	 * To display the camp name using locationid wise.
	 * @param string stateid
	 * return int count
	*/
	public function getDirectorReportCoachNameByAjax(Request $request)
	{
		if(count($request['director_name'])>1) {
			$id = implode(",", $request['director_name']);
		} else {
			$id= $request['director_name'][0];
		}
		$locationObj = new ManageLocations();
		$data['coachName'] = $locationObj->getDirectorReportCoachName($id);
		$data['count'] = count($data['coachName']);
		return view('Admin.RevenueReport.coachFilter', $data);
	}

}
