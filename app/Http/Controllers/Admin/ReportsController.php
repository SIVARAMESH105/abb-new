<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ManageStates;
use App\Models\Admin\ManageLocations;
use App\Models\Admin\ManageCoaches;
use App\Models\Admin\ManageCamps;
use App\Models\Admin\DirectorListReports;
use Auth;

class ReportsController extends Controller
{
    public function __construct()
    {   
        $this->stateObj = new ManageStates();
        $this->locationObj = new ManageLocations();
        $this->coachObj = new ManageCoaches();
        $this->campObj = new ManageCamps();
        $this->directorObj = new DirectorListReports();
    }

    public function reportsList() 
    {
		if(backpack_user()->user_type==4) {
			$name = backpack_user()->name;
			$states = $this->locationObj->getCampLocationStates($name);
			$stateList = array();
			$cityList = array();
			$Locations = array();
			if(count($states)>0) {
				foreach($states as $st) {
					$stateList[] = $this->stateObj->getStateListById($st->State);
					$cityList[] = $this->locationObj->getCityListByCity($st->City);
					$Locations[] = $this->locationObj->getLocationListByName($st->Location);
				}
			}
			$data['stateList'] = $stateList;
			$data['cityList'] = $cityList;
			$data['locationList'] = $Locations;
			$data['campList'] = $this->locationObj->getCampListDirector($name);
			$data['coachList'] = $this->locationObj->getCoachListDirector($name);
		} else {
			$data['stateList']= $this->stateObj->activeStateList();
			$data['cityList'] = $this->locationObj->getCityList();
			$data['locationList'] = $this->locationObj->getLocationList();
			$data['campList'] = $this->campObj->activeCampList();
			$data['coachList'] = $this->coachObj->getCoachList();
		}
		
		$data['directorList'] = $this->directorObj->getDirectorList();
		return view('Admin.reportsList', $data);
    }
}

?>