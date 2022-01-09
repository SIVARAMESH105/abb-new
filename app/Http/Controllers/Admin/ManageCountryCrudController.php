<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageCountry;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageCountryRequest as StoreRequest;
use App\Http\Requests\ManageCountryRequest as UpdateRequest;

class ManageCountryCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageCountry');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageCountry');
        $this->crud->setEntityNameStrings('Country', 'Manage Countries');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();

        // ------ CRUD FIELDS
		$this->crud->setColumns([
									[
										'name'  => 'country_name',
										'label' => 'Country Name',
										'type'  => 'text',
									],
									[
										'name'  => 'country_code',
										'label' => 'Country Code',
										'type'  => 'text',
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'country_name',
										'label' => 'Country Name<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'country_code',
										'label' => 'Country Code<span class="red">*</span>',
										'type'  => 'text'
									]
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
}
