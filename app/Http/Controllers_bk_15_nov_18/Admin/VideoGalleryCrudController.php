<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// use App\Models\Admin\ManageVidoes;
use App\Models\Admin\VideoGallery;


// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VideoGalleryRequest as StoreRequest;
use App\Http\Requests\VideoGalleryRequest as UpdateRequest;

class VideoGalleryCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\VideoGallery');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/videoGallery');
        $this->crud->setEntityNameStrings('Video', 'video Gallery');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
                                    [   // Checkbox
                                        'name' => 'order',
                                        'label' => 'Status',
                                        'type'  => 'model_function',
                                        'function_name' => 'activeStatus'
                                    ],
									[
										'name'  => 'title',
										'label' => 'Title',
										'type'  => 'text',
									],
									[
										'name'  => 'image',
										'label' => 'Poster Image',
										'type'  => 'model_function',
										'function_name' => 'displayPoster'
									],
								]);
		$this->crud->addFields([
									[
										'name'  => 'title',
										'label' => 'Title<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'video',
										'label' => 'Video<span class="red">*</span>',
										'type'  => 'upload',
										'upload' => true,
										'disk' => 'videos' // specify the upload disk from config/filesystems.php
									],
									[
										'name'  => 'image',
										'label' => 'Poster Image',
										'type'  => 'upload',
										'upload' => true,
										'disk' => 'videoPosters'
									],
									[
										'name'  => 'order',
										'label' => 'Order<span class="red">*</span>',
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
        $this->crud->orderBy('order', 'asc');
    }
	
	/* public function create()
	{
		$this->data['crud'] = $this->crud;
		$this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;
		return view('Admin.addVideo', $this->data);
	} */
    public function store(StoreRequest $request)
    {
        // your additional operations before save here
		//echo "<pre>"; print_r($request->all()); exit;
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
    public function statusCheck($id, $videostatus){
        $videomodel = new VideoGallery();
        $videomodel->changeStatus($id, $videostatus);
    }
}
