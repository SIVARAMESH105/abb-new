<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\AssignmentDetails;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AssignmentDetailsRequest as StoreRequest;
use App\Http\Requests\AssignmentDetailsRequest as UpdateRequest;

class AssignmentDetailsCrudController extends CrudController
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
        $this->crud->setModel('App\Models\Admin\AssignmentDetails');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/assignmentdetails');
        $this->crud->setEntityNameStrings('assignmentdetails', 'Assignment Details');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'camp_focus',
										'label' => 'Camp Name',
										'type'  => 'model_function',
										'function_name' => 'campNameWithLink'
									],
									[
										'name'  => 'Location',
										'label' => 'Camp Location',
										'type'  => 'text',
									],
									[
										'name'  => 'City',
										'label' => 'Camp City',
										'type'  => 'text',
									],
									[
										'name'  => 'State',
										'label' => 'Camp State',
										'type'  => 'select',
										'entity' => 'getStateCode', // the method that defines the relationship in your Model
										'attribute' => 'state_code', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageStates" // foreign key model
									],
									[
										'name'  => 'startdate',
										'label' => 'Start Date',
										'type'  => 'text'
									],
									[
										'name'  => 'enddate',
										'label' => 'End Date',
										'type'  => 'text',
									],
									[
										'name'  => 'starttime',
										'label' => 'Start Time',
										'type'  => 'text',
									],
									[
										'name'  => 'endtime',
										'label' => 'End Time',
										'type'  => 'text',
									]
								]);
		$this->crud->addClause('join', 'tbl_coachcamp', 'tbl_coach.id', 'tbl_coachcamp.coach_id');
		$this->crud->addClause('join', 'tbl_camp', 'tbl_coachcamp.camp_id', 'tbl_camp.id');
		$this->crud->addClause('join', 'tbllocation', 'tbllocation.Id', 'tbl_camp.LocationId');

        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS
		$this->crud->removeAllButtons();

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
		session_start();
		$coachId = '';
		if(isset($_SESSION['coachId'])) {
			$coachId = $_SESSION['coachId'];
		}
        $this->crud->addClause('where', 'tbl_camp.status', '=', 1);
        $this->crud->addClause('where', 'tbl_coachcamp.coach_id', '=', $coachId);
		$this->crud->orderBy('tbl_camp.startdate');
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
	
	public function redirectToCoachAssignments($coachId)
	{
		$assignmentDetails = new AssignmentDetails();
		$_SESSION['coachName'] = $assignmentDetails->getCoachName($coachId);
		$_SESSION['coachId'] = $coachId;
		return \Redirect::to('admin/coachAssignments');
	}
}
