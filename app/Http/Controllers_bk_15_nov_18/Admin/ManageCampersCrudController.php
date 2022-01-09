<?php

namespace App\Http\Controllers\Admin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageCampers;
use App\Models\Admin\User;
use App\Models\Admin\ManageCountry;
use App\Models\Site\CountrySite;
use Illuminate\Http\Request;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageCampersRequest as StoreRequest;
use App\Http\Requests\ManageCampersRequest as UpdateRequest;
use Auth;
use DataTables;

class ManageCampersCrudController extends CrudController
{
	
	/* public function __construct()
	{	
		parent::__construct();
		$user = Auth::user();
		$id = Auth::id();
		//echo '<pre>'; print_r($user); die;
	} */
		
	public function campersList(){
		return view('Admin.camper_lists');
	}
	
	public function getCamperslist(Request $request){
		$camperObj = new ManageCampers();
		$camperDetails = $camperObj->getCamperDetails();
		return DataTables::of($camperDetails)
            ->addColumn('action', function ($details) {
				$p_type= "'m_camper'";
                return '<a href="'.url('admin/editCamper/'.$details->uid.'/m_camper').'" class="btn btn-xs btn-default"><i class="fa fa-edit" ></i> Edit</a><a href="javascript:void(0);" onclick="confirmationDelete('.$details->tid.','.$p_type.');return false;"  class="btn btn-xs btn-default"><i class="fa fa-trash" ></i> Delete</a>';
		})->make(true);
	}
	
	public function editCamper($uid,$p_type){
		$userObj = new User();
		$data['UserVal'] = $userObj->getUser($uid);
		$countryObj = new ManageCountry();
		$data['country_details'] = $countryObj->countryStaticList();
		return view('Admin.edit_campers', $data);
	}
	
	public function updateCamper(UpdateRequest $request){
		$Obj = new User();
		$status = $Obj->updateCamperDetail($request->all());
		if($request->input('page_type') == 'm_camper'){
			if($status == 'ok') {
				\Alert::success('Camper updated successfully')->flash();
				return \Redirect::to('admin/manageCampers');
			} else {
				\Alert::error('Camper updation failed')->flash();
				return \Redirect::to('admin/editCamper/'.$request->input('id')/$request->input('page_type'))->withInput();
			}
		}else {
			if($status == 'ok') {
				\Alert::success('Camper updated successfully')->flash();
				return \Redirect::to('admin/campers');
			} else {
				\Alert::error('Camper updation failed')->flash();
				return \Redirect::to('admin/editCamper/'.$request->input('id')/$request->input('page_type'))->withInput();
			}
		}
	}
	
	public function deleteCamper($ros_id,$p_type){
		$camperObj = new ManageCampers();
		$camperObj->deleteCamper($ros_id);
		if($p_type == 'm_camper'){
			\Alert::success('Camper deleted successfully')->flash();
			return \Redirect::to('admin/manageCampers');
		}else{
			\Alert::success('Camper deleted successfully')->flash();
			return \Redirect::to('admin/campers');
		}
	}
}
