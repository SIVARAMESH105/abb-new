<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\ViewCoachRosters;
use App\Models\Admin\ManageStates;
use App\Http\Requests;
use App\Http\Requests\EditAdminProfile as UpdateRequest;
use App\Http\Requests\ChangePassword as ChangePasswordRequest;
use Auth;
use PDF;

class ViewCoachRostersController extends Controller
{
	
	function __construct()
	{
		$this->rostersObj = new ViewCoachRosters();
	}
	
    function viewRosters($userId)
	{
		$data['rosters'] = $this->rostersObj->getRostersList($userId);
		return view('Admin.listCoachRosters', $data);
	}
	
	public function downloadRostersPdf($campId)
	{
		$data = $this->rostersObj->getPdf($campId);
		$customPaper = array(0,0,850,560);
		return PDF::loadView('Admin/rosterPdfTemplate', $data)->setPaper($customPaper,'portrait')->save(public_path().'/uploads/pdf/camps/camp_'.time().'.pdf')->stream('download.pdf');
	}
	
	public function coachCampersList($campId)
	{
		$stateObj = new ManageStates();
		$data['campers'] = $this->rostersObj->getPdf($campId);
		$data['campId'] = $campId;
		$data['campers']['camps'][0]->stateName = $stateObj->getStateName($data['campers']['camps'][0]->State);
		return view('Admin.coachCampersList', $data);
	}
}
