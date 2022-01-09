<?php

namespace App\Http\Controllers\Admin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageSliderCaption;
use App\Models\Admin\User;

use Illuminate\Http\Request;


use Auth;
use DataTables;

class ManageSliderCaptionCrudController extends CrudController
{
	
	public function __construct()
	{
		$this->sliderObj = new ManageSliderCaption();
	}


	public function sliderlist(){
		
		return view('Admin.slidercaption_lists');
	}

	public function createslider(){
		
		return view('Admin.add_sliders');
	}

	public function addSliderCaption(Request $data){
		$caption = $data->input("caption");
		$this->validate($data,[
         	'caption'=>'required'
        ]);   
		$sliderAdd = $this->sliderObj->insert($caption);
		if($sliderAdd) {
            \Alert::success('Caption added successfully')->flash();
				return \Redirect::to('admin/manageCaptions');   
        }
	}

	public function getSliderCaptionDetails(){
		$sliderDetails = $this->sliderObj->getSliderCaptionDetails();
		return DataTables::of($sliderDetails)
            ->addColumn('action', function ($sliderDetail) {
			 return '<a href="'.url('admin/editslider/'.$sliderDetail->id).'" class="btn btn-xs btn-default"><i class="fa fa-edit" ></i> Edit</a><a href="javascript:void(0);" onclick="confirmationDelete('.$sliderDetail->id.');return false;"  class="btn btn-xs btn-default"><i class="fa fa-trash" ></i> Delete</a>';
		})->make(true);
	}
	
	public function editSliderCaption($id){
		$sliderDetails = $this->sliderObj->editSliderCaptionDetails($id);
		return view('Admin.edit_sliders',['sliderDetails'=>$sliderDetails]);  
	}


	public function updateSliderCaption(Request $data){
	    $caption = $data->input("caption");
	    $this->validate($data,[
         	'caption'=>'required'
        ]);
		$id = $data->input("id");
		$status = $this->sliderObj->updateSliderCaption($caption,$id);
	    if($status == 'ok') {
			\Alert::success('Caption updated successfully')->flash();
			return \Redirect::to('admin/manageCaptions');
		} else {
			\Alert::error('Caption updation failed')->flash();
			return \Redirect::to('admin/editslider/'.$request->input('id'))->withInput();
		}
	}

	public function deleteSliderCaption($id){
		$status = $this->sliderObj->deleteSliderCaption($id);
		if($status == 'ok'){
			\Alert::success('Camper deleted successfully')->flash();
			return \Redirect::to('admin/manageCaptions');
		}else{
			\Alert::success('Caption deletion failed')->flash();
			return \Redirect::to('admin/manageCaptions');
		}
	}  
	
	
}
