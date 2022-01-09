<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageStates;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageStatesRequest as StoreRequest;
use App\Http\Requests\ManageStatesRequest as UpdateRequest;

class ManageStatesCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageStates');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageState');
        $this->crud->setEntityNameStrings('State', 'Manage States');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();

        // ------ CRUD FIELDS
		$this->crud->setColumns([
									[
										'name'  => 'state_name',
										'label' => 'State Name',
										'type'  => 'text',
									],
									[
										'name'  => 'state_code',
										'label' => 'State Code',
										'type'  => 'text',
									],
									[
										'label' => 'County Name',
										'type'  => 'select',
										'name' => 'country_id', // the db column for the foreign key
										'entity' => 'country', // the method that defines the relationship in your Model
										'attribute' => 'country_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageCountry" // foreign key model
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
										'label' => 'Country Name',
										'type'  => 'select',
										'name' 	=> 'country_id', // the db column for the foreign key
										'entity' => 'country', // the method that defines the relationship in your Model
										'attribute' => 'country_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageCountry" // foreign key model
									],
									[
										'name'  => 'state_name',
										'label' => 'State Name<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'state_code',
										'label' => 'State Code<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'status',
										'label' => 'Status',
										'type'  => 'radio',
										'default' => 1,
										'options' => [
														1 => "Active",
														0 => "Inactive"
													],
										// optional
										'inline'      => true, // show the radios all on the same line?
									],
								]);

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
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
	
	public function reloadStates($countryId)
	{
		$stateObj = new ManageStates();
		$countryStates = $stateObj->getStatesByCountry($countryId);
		return $countryStates;
	}
}
