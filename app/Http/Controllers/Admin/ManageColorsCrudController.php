<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageColorsRequest as StoreRequest;
use App\Http\Requests\ManageColorsRequest as UpdateRequest;

class ManageColorsCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageColors');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageColors');
        $this->crud->setEntityNameStrings('Color', 'Manage Colors');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'color_name',
										'label' => 'Color Name',
										'type'  => 'text',
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'color_name',
										'label' => 'Color Name<span class="red">*</span>',
										'type'  => 'text',
									]
								]);

        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        $this->crud->orderBy('color_name');
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
