<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageCms;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageCmsRequest as StoreRequest;
use App\Http\Requests\ManageCmsRequest as UpdateRequest;

class ManageCmsCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageCms');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/cms');
        $this->crud->setEntityNameStrings('Page', 'Manage CMS');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'title',
										'label' => 'Page Title',
										'type'  => 'model_function',
										'function_name' => 'linkPageTitle'
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'title',
										'label' => 'Page Title',
										'type'  => 'text',
									]
								]);

        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS
		//$this->crud->removeAllButtons();
		$this->crud->removeButton('create');
		$this->crud->removeButton('delete');

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
	
	public function editCms($id)
	{
		$cmsObj = new ManageCms();
		$data['pageContent'] = $cmsObj->getPage($id);
		$data['imgName'] = $cmsObj->getImgName($id);
		$data['metaVal'] = $cmsObj->getMetaVal($id);
		$data['fieldTypes'] = $cmsObj->getFieldTypes($id);
		$data['pageId'] = $id;
		return view('Admin.editCms', $data);
	}
	
	public function updateCms(UpdateRequest $request, $id)
	{
		$cmsObj = new ManageCms();
		$update = $cmsObj->updatePage($request, $id);
		return \Redirect::to('admin/editCms/'.$id);
	}
}
