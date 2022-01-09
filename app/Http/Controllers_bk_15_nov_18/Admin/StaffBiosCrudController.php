<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\StaffBios;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StaffBiosRequest as StoreRequest;
use App\Http\Requests\StaffBiosRequest as UpdateRequest;

class StaffBiosCrudController extends CrudController
{
	public function __construct()
	{
		parent::__construct();
	}
	
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\StaffBios');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/staffbios');
        $this->crud->setEntityNameStrings('Staff Bio', 'Staff Bios');
        $this->crud->enableReorder('name');
        $this->crud->allowAccess('reorder');
        // $this->crud->setListView('Admin/staffList');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'name',
										'label' => 'Name',
										'type'  => 'model_function',
                                        'function_name' => 'displayLink'
									],
									[
										'name' => 'image',
										'label' => 'Photo',
										'type'  => 'model_function',
										'function_name'	=> 'displayPhoto'
									],
                                    [
                                        'name' => 'thumbnail',
                                        'label' => 'Thumbnail',
                                        'type'  => 'model_function',
                                        'function_name' => 'displayThumbnail'
                                    ]
								]);
		
		$this->crud->addFields([
									[
										'name'  => 'name',
										'label' => 'Name<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'image',
										'label' => 'Main Photo<span class="red">*</span>',
										'type'  => 'upload',
										'upload' => true,
										'disk' => 'staffbios'	// specify the upload disk form config/filesystems.php. if you store files in the /public folder, please ommit this; if you store them in /storage or S3 or other, please specify it;
									],
                                    [
                                        'name'  => 'thumbnail',
                                        'label' => 'Thumbnail (150x150)<span class="red">*</span>',
                                        'type'  => 'upload',
                                        'upload' => true,
                                        'disk' => 'staffbiosThumb'   // specify the upload disk form config/filesystems.php. if you store files in the /public folder, please ommit this; if you store them in /storage or S3 or other, please specify it;
                                    ],
									[
										'name'  => 'short_desc',
										'label' => 'Short Description',
										'type'  => 'ckeditor'
									],
									[
										'name'  => 'content',
										'label' => 'Content<span class="red">*</span>',
										'type'  => 'ckeditor'
									],
									[
										'name'  => 'lft',
										'label' => 'Order Number<span class="red">*</span>',
										'type'  => 'text'
									],
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
        $this->crud->orderBy('lft');


    }

    public function store(StoreRequest $request)
    {
       #echo "<pre>"; print_r($request->all());
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
		$id = $this->data['entry']['id'];
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry		
		$staffBios = new StaffBios();
        $thumb = $staffBios->thumbnail($request, 'create', $id);        
		$mainPhoto = $staffBios->mainPhoto($request, 'create', $id);		
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
		$staffBios = new StaffBios();
        $thumb = $staffBios->thumbnail($request, 'update', '');
		$mainPhoto = $staffBios->mainPhoto($request, 'update', '');
		
        return $redirect_location;
    }
}
