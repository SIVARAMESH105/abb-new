<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageCampers;
use App\Models\Admin\Camper;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageCampersRequest as StoreRequest;
use App\Http\Requests\ManageCampersRequest as UpdateRequest;
use DataTables;

class CamperCrudController extends CrudController
{	
	
	public function __construct()
	{
		parent::__construct();
	}
	
    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\Camper');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/campers');
        $this->crud->setEntityNameStrings('camper', 'Camper List');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'name',
										'label' => 'Roster Name',
										'type'  => 'model_function',
										'function_name' => 'mergeRosterName'
									],
									[
										'name'  => 'gender',
										'label' => 'Gender',
										'type'  => 'text',
									],
									[
										'name'  => 'dob',
										'label' => 'DOB',
										'type'  => 'text'
									],
									[
										'name'  => 'city',
										'label' => 'City',
										'type'  => 'text',
									]
								]);
		
		$this->crud->addFields([
									[
										'name'  => 'name',
										'label' => "<h4>1. GENERAL INFORMATION</h4><br>Student's First Name<span class='red'>*</span>",
										'type'  => 'text',
									],
									[
										'name'  => 'fname',
										'label' => "Student's Last Name*",
										'type'  => 'text',
									],
									[
										'label' => 'T-shirt Size<span class="red">*</span>',
										'type'  => 'select',
										'name' 	=> 'tshirtsize', // the db column for the foreign key
										'entity' => 'tshirtSize', // the method that defines the relationship in your Model
										'attribute' => 'size', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\TshirtSize" // foreign key model
									],
									[
										'name'  => 'gender',
										'label' => 'Student Gender<span class="red">*</span>',
										'type'  => 'radio',
										'options' => [
														'Female' => "Female",
														'Male' => "Male"
													],
										// optional
										'inline'      => true, // show the radios all on the same line?
									],
									[
										'name'  => 'dob',
										'label' => 'Student Birthdate<span class="red">*</span>',
										'type'  => 'date'
									],
									[
										'name'  => 'grade',
										'label' => 'Student Grade<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'parent_firstname',
										'label' => '<i>Parent/Guardian</i><br>First Name<span class="red">*</span>',
										'type'  => 'text',
									],
									
									[
										'name'  => 'parent_lastname',
										'label' => 'Last Name<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'address',
										'label' => 'Address<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'city',
										'label' => 'City<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'state',
										'label' => 'State<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'zip',
										'label' => 'ZIP/Postal Code<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'country',
										'label' => 'Country<span class="red">*</span>',
										'type'  => 'select_from_array',
										'options' => ManageCampers::countryList(),
										'allows_null' => false,
									],
									[
										'name'  => 'home_phone',
										'label' => 'Home Phone<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'work_phone',
										'label' => 'Work/Other Phone',
										'type'  => 'text',
									],
									[
										'name'  => 'parent_email',
										'label' => 'Parent E-mail<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'basketball_exp',
										'label' => "<h4>2. BASKETBALL EXPERIENCE</h4><br>Have you attended an Advantage Basketball Camps session before?",
										'type'  => 'radio',
										'options' => [
														'Yes' => "Yes",
														'No' => "No"
													],
										'inline'      => true, // show the radios all on the same line?
									],
									[
										'name'  => 'basketball_exp_desc',
										'label' => 'If yes, where/when',
										'type'  => 'text',
									],
									[
										'name'  => 'basketball_skill',
										'label' => 'How woud you rate your basketball skills and abilities?',
										'type'  => 'radio',
										'options' => [
														'Beginner' => "Beginner",
														'Intermediate' => "Intermediate",
														'Advanced' => "Advanced"
													],
										'inline'      => true, // show the radios all on the same line?
									]
								]);
		
        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS
        $this->crud->removeButton('create');

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS
		
        // ------ ADVANCED QUERIES
		session_start();
		$campId = '';
		if(isset($_SESSION['campId'])) {
			$campId = $_SESSION['campId'];
		}
        $this->crud->addClause('where', 'tbl_roster.camp_id', '=', $campId);
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
	
	public function redirectToCamper($campId)
	{
		$_SESSION['campId'] = $campId;
		return \Redirect::to('admin/campers');
	}
	
	public function campers(){
		//echo 'in'; die;
		return view('Admin.campers');
	}
	
	public function getCamperUserslist(Request $request){
		$camperuserObj = new Camper();
		$camperuserDetails = $camperuserObj->getCamperUserDetails($_SESSION['campId']);
		return DataTables::of($camperuserDetails)
            ->addColumn('action', function ($details) {
				$p_type= "'camper'";
                return '<a href="'.url('admin/editCamper/'.$details->uid.'/camper').'" class="btn btn-xs btn-default"><i class="fa fa-edit" ></i> Edit</a><a href="javascript:void(0);" onclick="confirmationDelete('.$details->tid.','.$p_type.');return false;" class="btn btn-xs btn-default"><i class="fa fa-trash" ></i> Delete</a>';
		})->make(true);
	}
}
