<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageFlyers;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageFlyersRequest as StoreRequest;
use App\Http\Requests\ManageFlyersRequest as UpdateRequest;

class ManageFlyersCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageFlyers');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageFlyers');
        $this->crud->setEntityNameStrings('flyer', 'Manage Flyers');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									
									[
										'name'  => 'flyer_title',
										'label' => 'Flyer Name',
										'type'  => 'text',
									],
									[
										'name'  => 'flyer_pdf',
										'label' => 'PDF',
										'type'  => 'model_function',
										'function_name' => 'getPdfLink'
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'flyer_title',
										'label' => 'Flyer Name<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'flyer_desc',
										'label' => 'Flyer Description<span class="red">*</span>',
										'type'  => 'textarea',
									],
									[
										'name'  => 'flyer_pdf',
										'label' => 'Flyer PDF<span class="red">*</span>',
										'type'  => 'upload',
										'attributes' => ['class' => 'form-control file-browse'],
										'upload' => true,
										'disk' => 'flyer' // specify the upload disk form config/filesystems.php. if you store files in the /public folder, please ommit this; if you store them in /storage or S3 or other, please specify it;
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
        $this->crud->orderBy('flyer_title');
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
