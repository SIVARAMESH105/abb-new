<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ViewRosters;
use Input;
use App\Item;
use Excel;
use PDF;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ViewRostersRequest as StoreRequest;
use App\Http\Requests\ViewRostersRequest as UpdateRequest;

class ViewRostersCrudController extends CrudController
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
        $this->crud->setModel('App\Models\Admin\ViewRosters');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/viewRosters');
        $this->crud->setEntityNameStrings('Rosters', 'View Rosters');

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
										'function_name' => 'getCampNameWithLink'
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
										'function_name' => 'getStateName'
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
									[
										'name'  => 'coach_id',
										'label' => 'Camper Count',
										'type'  => 'model_function',
										'function_name' => 'getCamperCount'
									],
									[
										'name' => 'coach_id',
										'label' => 'Coach Name',
										'type'  => 'model_function',
										'function_name' => 'getCoachName'
									],
									[
										'name' => 'id',
										'label' => 'XLS',
										'type'  => 'model_function',
										'function_name' => 'downloadXLS'
									],
									[
										'name' => 'id',
										'label' => 'PDF',
										'type'  => 'model_function',
										'function_name' => 'downloadPDF'
									],
								]);
		$this->crud->addClause('join', 'tbllocation', 'tbl_camp.LocationId', 'tbllocation.Id');
		$this->crud->addClause('leftjoin', 'tbl_order_camp', 'tbl_camp.id', 'tbl_order_camp.camp_id');

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
		$this->crud->enableExportButtons();
		
        // ------ ADVANCED QUERIES
        $this->crud->addClause('where', 'status', '=', '1');
        $this->crud->orderBy('State');
        $this->crud->orderBy('City');
        $this->crud->orderBy('startdate');
        $this->crud->groupBy('tbl_camp.id');
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
	
	public function downloadRostersXls($campId)
	{
		$viewRosters = new ViewRosters();
		$data = $viewRosters->getXls($campId);
		return Excel::create('rosters', function($excel) use ($data) {
			$excel->sheet('rosters', function($sheet) use ($data)
			{
				$sheet->fromArray($data, null, 'A1', false, false);
				$sheet->setBorder('A1:B7', 'thin');
				$sheet->setBorder('A9:P9', 'thin');
				$sheet->cells('A9:P9', function($cells) {
					$cells->setFontWeight('bold');
				});
				$sheet->setAutoSize(true);
			});
		})->download("xls");
	}
	
	public function downloadRostersPdf($campId)
	{
		$viewRosters = new ViewRosters();
		$data = $viewRosters->getPdf($campId);
		$customPaper = array(0,0,850,560);
		return PDF::loadView('Admin/rosterPdfTemplate', $data)->setPaper($customPaper,'portrait')->save(public_path().'/uploads/pdf/camps/camp_'.time().'.pdf')->stream('download.pdf');
	}
}
