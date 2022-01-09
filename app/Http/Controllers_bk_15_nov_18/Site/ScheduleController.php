<?php

namespace App\Http\Controllers\Site;

use App\Models\Site\Camps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Site\Locations;

session_start();

class ScheduleController extends Controller
{
 
	public function __construct()
    {
      $this->campsObj = new Camps();  
    }
	
    
	/*Shedule Ajax method*/
	public function ajaxGetCity(){
		$state_id = (!empty($_GET['stateId'])) ? $_GET['stateId'] :'';
		$locationObj = new Locations();
		$city_details = $locationObj->getCityDetails($state_id);
		$data = json_encode($city_details);
		return $data;
	}

	/* Month List*/
	public function ajaxMonthList(){
		$data['state_id'] = $_GET['stateId'];
		$data['city_id']  = $_GET['cityId'];
		$month_details = $this->campsObj->getMonth($data);
		$months = json_encode($month_details);
		return $months;

	}

	/* Camp by location */
	public function ajaxGetCamps(){
		$data['state_id'] = $_GET['stateId'];
		$data['city_id']  = $_GET['cityId'];
		$data['month']  = $_GET['month']; 	
		$dbstarttime= 'tbl_camp.starttime';
        $data['date']= $_GET['month'];
		$camp_details = $this->campsObj->campDetails($data);      
        $camps = json_encode($camp_details);
        return $camps;
	}

	/* All Camps detail */
	public function ajaxAllCamps(){
		$allCampDetail = $this->campsObj->getAllCamps();
        //print_r($allCampDetail);
        return json_encode($allCampDetail);
	}

	/*Find camps by date: Get State existing in existing month*/
	public function ajaxGetState(){
		$data['month'] = $_GET['month'];
		$state_details = $this->campsObj->stateByDate($data);
        return json_encode($state_details);
		//echo $month;
	}

	public function ajaxCityByDate(){
		$data['month'] = $_GET['month'];
		$data['stateId'] = $_GET['stateId'];
		$city_details =  $this->campsObj->CityByDate($data);
        return json_encode($city_details);
	}

	public function ajaxCampsByDate(){
		$data['state_id'] = $_GET['stateId'];
		$data['city_id']  = $_GET['cityId'];
		$data['date']  = $_GET['month']; 
		$camp_details = $this->campsObj->campDetails($data);      
        return json_encode($camp_details);
	}
}
