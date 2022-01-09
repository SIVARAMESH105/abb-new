<?php

namespace App\Http\Controllers\Admin;
// use Backpack\CRUD\app\Http\Controllers\CrudController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\ManageCountry;
use App\Models\Admin\ManageStates;
use App\Jobs\CreateDirectorEmail;
use Carbon\Carbon;

// // VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageDirectorsRequest as StoreRequest;
use App\Http\Requests\ManageDirectorsRequest as UpdateRequest;
use Auth;
use DataTables;

class ManageDirectorsCrudController extends Controller
{
  
    public function __construct() 
    {
        $this->userObj = new User();
        $this->countryObj = new ManageCountry();
        $this->stateObj = new ManageStates();
    }

    public function directorsList(){
        return view('Admin.director_lists');
    }
    
    public function getDirectorsList(Request $request)
    {
        $directorDetails = User::where('user_type','4')->get();
        return DataTables::of($directorDetails)
            ->addColumn('state',function($details){
            $stateName = $this->stateObj->getStateName($details->state);
            return $stateName;
        }) ->addColumn('country',function($details){
            $countryName = $this->countryObj->countryStaticList();
            return $countryName[$details->country];
        })->addColumn('action', function ($details) {
                return '<a href="'.url('admin/editDirector/'.$details->id).'" class="btn btn-xs btn-default"><i class="fa fa-edit" ></i> Edit</a><a href="javascript:void(0);" onclick="confirmationDelete('.$details->id.');return false;"  class="btn btn-xs btn-default"><i class="fa fa-trash" ></i> Delete</a>';
        })->make(true);
    }
    
    public function createDirector()
    {
        $data['country_details'] = $this->countryObj->countryStaticList();
        $data['states'] = $this->stateObj->stateList();
        return view('Admin.create_directors', $data);
    }

    public function storeDirector(StoreRequest $request)
    {
        $status = $this->userObj->storeDirectorDetail($request->all());
        if($status == 'ok') {
            \Alert::success('Director added successfully')->flash();
            $job = (new CreateDirectorEmail($request->all()))
                    ->delay(Carbon::now()->addSeconds(5));
            dispatch($job);
            return \Redirect::to('admin/manageDirectors');
        } else {
            \Alert::error('Director add operation failed')->flash();
            return \Redirect::to('admin/createDirector/')->withInput();
        }
    }

    public function editDirector($uid)
    {
        $data['UserVal'] = $this->userObj->getUser($uid);
        $data['country_details'] = $this->countryObj->countryStaticList();
        $data['states'] = $this->stateObj->stateList();
        return view('Admin.edit_directors', $data);
    }
    
    public function updateDirector(UpdateRequest $request)
    {
        $status = $this->userObj->updateDirectorDetail($request->all());
        if($status == 'ok') {
            \Alert::success('Director updated successfully')->flash();
            return \Redirect::to('admin/manageDirectors');
        } else {
            \Alert::error('Director updation failed')->flash();
            return \Redirect::to('admin/editDirector/'.$request->input('id'))->withInput();
        }
    }
    
    public function deleteDirector($id)
    {       
        $user = User::find($id);    
        $status =$user->delete();
        if($status == 'ok') {
            \Alert::success('Director deleted successfully')->flash();
            return \Redirect::to('admin/manageDirectors');
        } else {
            \Alert::error('Director delete action failed')->flash();
            return \Redirect::to('admin/manageDirectors/');
        }
    }
}
