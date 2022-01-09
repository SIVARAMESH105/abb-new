<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\Location;
use App\Models\Admin\ManageCamps;
use App\Models\Admin\CampTime;
use App\Models\Admin\Coaches;
use App\Models\Admin\CoachCamp;
use App\Models\Admin\Flyer;
use Illuminate\Routing\Redirector;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CampUpdateRequest as StoreRequest;
use App\Http\Requests\CampUpdateRequest as UpdateRequest;
use Auth;
use DB;

class ManageCampsCrudController extends CrudController
{
	public function __construct()
	{
		parent::__construct();
	}

    public function setUp()
    {
	//echo Auth::user()->user_type; exit;

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageCamps');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageCamps');
        $this->crud->setEntityNameStrings('Camp', 'Manage Camps');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();

        // ------ CRUD FIELDS
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
										'type'  => 'text',
									],
									[
										'name'  => 'startdate',
										'label' => 'Start Date',
										'type' => "text",
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
									[
										'name'  => 'status',
										'label' => 'Status',
										'type'  => 'model_function',
										'function_name' => 'getStatus'
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'camp_focus',
										'label' => 'Camp Name<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'label' => 'Location<span class="red">*</span>',
										'type'  => 'select',
										'name' 	=> 'LocationId', // the db column for the foreign key
										'entity' => 'location', // the method that defines the relationship in your Model
										'attribute' => 'Location', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageLocations" // foreign key model
									],
									[
										'name'  => 'startdate',
										'label' => 'Start Date<span class="red">*</span>',
										'type'  => 'date'
									],
									[
										'name'  => 'enddate',
										'label' => 'End Date<span class="red">*</span>',
										'type'  => 'date'
									],
									[
										'name'  => 'starttime',
										'label' => 'Start Time<span class="red">*</span>',
										'type'  => 'time'
									],
									[
										'name'  => 'endtime',
										'label' => 'End Time<span class="red">*</span>',
										'type'  => 'time'
									],
									[
										'name'  => 'season',
										'label' => 'Season',
										'type'  => 'select_from_array',
										'options' => ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'],
										'allows_null' => false,
									],
									[
										'name'  => 'cost',
										'label' => 'Cost<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'EarlyBirdDiscount',
										'label' => 'Early Bird Discount<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'EarlyBirdDays',
										'label' => 'Discount Days<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'contact',
										'label' => 'Contact<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'status',
										'label' => 'Status',
										'type'  => 'radio',
										'default' => 1,
										'options' => [
														1 => "Active",
														0 => "Inactive",
														2 => 'Coming Soon'
													],
										// optional
										'inline'      => true, // show the radios all on the same line?
									],
									[
										'label' => 'Coach Assign<span class="red">*</span>',
										'type'  => 'select',
										'name' => 'coach_id', // the db column for the foreign key
										'entity' => 'coach', // the method that defines the relationship in your Model
										'attribute' => 'first_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageCoaches" // foreign key model
									],
									[
										'label' => 'Camp Flyer PDF',
										'type'  => 'select',
										'name' => 'flyer_id', // the db column for the foreign key
										'entity' => 'flyer', // the method that defines the relationship in your Model
										'attribute' => 'flyer_title', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageFlyers" // foreign key model
									],
								]);
		$this->crud->addClause('join', 'tbllocation', 'tbllocation.Id', 'tbl_camp.LocationId');

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }
	
    public function store(StoreRequest $request)
    {
        $redirect_location = parent::storeCrud();
        return $redirect_location;
    }
	
	/* public function edit($request)
    {
		$campsObj = new ManageCamps();
		$locationObj = new Location();
		$campTimeObj = new CampTime();
		$coachesObj = new Coaches();
		$coachCampObj = new CoachCamp();
		$flyerObj = new Flyer();
		$data['camps'] = $campsObj->getCamp($request);
		$data['locations'] = $locationObj->getLocations();
		$data['coaches'] = $coachesObj->getCoaches();
		$data['campCoach'] = $coachCampObj->getCampCoach($request);
		$data['flyers'] = $flyerObj->getFlyers();
		$startDate = explode('-', $data['camps'][0]->startdate);
		$endDate = explode('-', $data['camps'][0]->enddate);
		$startTime = explode(':', $data['camps'][0]->starttime);
		$endTime = explode(':', $data['camps'][0]->endtime);
		$data['months'] = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
		$data['campTimes'] = $campTimeObj->getCampTime();
		$data['startYear'] = $startDate[0];
		$data['startMonth'] = $startDate[1];
		$data['startDay'] = $startDate[2];
		$data['endYear'] = $endDate[0];
		$data['endMonth'] = $endDate[1];
		$data['endDay'] = $endDate[2];
		$data['starttime'] = $startTime[0].':'.$startTime[1];
		$data['endtime'] = $endTime[0].':'.$endTime[1];
		return view('Admin.editCamp', $data);
	} */

    /* public function update(UpdateRequest $request)
    {
		$campsObj = new ManageCamps();
		$coachCampObj = new CoachCamp();
		$campStatus = $campsObj->updateCamp($request->all());
		$coachStatus = $coachCampObj->updateCampCoach($request->all());
		\Alert::success('Camp updated successfully')->flash();
		return redirect('/admin/manageCamps');
    } */
	public function update(UpdateRequest $request)
    {
		$coachCampObj = new CoachCamp();
		$coachStatus = $coachCampObj->updateCampCoach($request->all());
		return parent::updateCrud();
	}
	
	public function campPopupList()
	{
		$campsObj = new ManageCamps();
		$data['campList'] = $campsObj->getPopupCampList();
		return view('Admin.popupCampList', $data);
	}
}
