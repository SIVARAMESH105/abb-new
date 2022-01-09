<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
//use App\Models\Admin\ManageCampers;

use Illuminate\Routing\Redirector;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageAssignmentsRequest as StoreRequest;
use App\Http\Requests\ManageAssignmentsRequest as UpdateRequest;

class ManageAssignmentsCrudController extends CrudController
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
        $this->crud->setModel('App\Models\Admin\ManageAssignments');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageAssignments');
        $this->crud->setEntityNameStrings('Assignments', 'Manage Assignments');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

       // $this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'camp_focus',
										'label' => 'Camp Name',
										'type'  => 'text',
									],
									[
										'label' => 'Location',
										'type'  => 'select',
										'name' => 'LocationId', // the db column for the foreign key
										'entity' => 'location', // the method that defines the relationship in your Model
										'attribute' => 'Location', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageLocations" // foreign key model
									],
									[
										'name'  => 'City',
										'label' => 'City',
										'type'  => 'text',
									],
									[
										'name'  => 'State',
										'label' => 'State',
										'type'  => 'model_function',
										'function_name' => 'getStateCode'
									],
									[
										'name'  => 'startdate',
										'label' => 'Start Date',
										'type'  => 'text',
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
									],
									/*[
										'label' => 'Coach',
										'type'  => 'select',
										'name' => 'coach_id', // the db column for the foreign key
										'entity' => 'coach', // the method that defines the relationship in your Model
										'attribute' => 'last_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\Coaches" // foreign key model
									],*/
									[
										'name'  => 'coach_id',
										'label' => 'Coach',
										'entity' => 'coach',
										'type'  => 'model_function',
										'function_name' => 'getFullName'
									],
								]);
		$status =1;
		$this->crud->addClause('join', 'tbl_coachcamp', 'tbl_camp.id', 'tbl_coachcamp.camp_id');
		$this->crud->addClause('join', 'tbl_coach', 'tbl_coachcamp.coach_id', 'tbl_coach.id');
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
		$this->crud->addClause('where', 'tbl_camp.status', '=', $status);
		$this->crud->groupBy('tbl_camp.id');
		$this->crud->orderBy('tbllocation.State', 'asc');
		
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
}
