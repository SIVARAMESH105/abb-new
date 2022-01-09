<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageLocations;
use App\Models\Admin\ManageCountry;
use App\Models\Admin\ManageStates;
use URL;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageLocationsRequest as StoreRequest;
use App\Http\Requests\ManageLocationsRequest as UpdateRequest;

class ManageLocationsCrudController extends CrudController
{
    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageLocations');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageLocations');
        $this->crud->setEntityNameStrings('Location', 'Manage Locations');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'Location',
										'label' => 'Camp Location',
										'type'  => 'text',
									],
									[
										'label' => 'Camp State',
										'type'  => 'select',
										'name' => 'State', // the db column for the foreign key
										'entity' => 'state', // the method that defines the relationship in your Model
										'attribute' => 'state_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageStates" // foreign key model
									],
									[
										'name'  => 'City',
										'label' => 'Camp City',
										'type'  => 'text',
									]
								]);
								
		$this->crud->addFields([
									[
										'name'  => 'Location',
										'label' => 'Camp Location',
										'type'  => 'text',
									],
									[
										'name'  => 'Address',
										'label' => 'Address',
										'type'  => 'text'
									],
									[
										'name'  => 'City',
										'label' => 'City',
										'type'  => 'text'
									],
									[
										'label' => 'Country',
										'type'  => 'select',
										'name' 	=> 'Country', // the db column for the foreign key
										'entity' => 'country', // the method that defines the relationship in your Model
										'attribute' => 'country_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageCountry" // foreign key model
									],
									[
										'label' => 'State',
										'type'  => 'select',
										'name' 	=> 'State', // the db column for the foreign key
										'entity' => 'state', // the method that defines the relationship in your Model
										'attribute' => 'state_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageStates" // foreign key model
									],
									[
										'name'  => 'Zip',
										'label' => 'Zip',
										'type'  => 'text'
									],
									[
										'name'  => 'AdditionalInfo',
										'label' => 'Additional Information',
										'type'  => 'tinymce'
									],
								]);
		$this->crud->addClause('join', 'tbl_state_codes', 'tbl_state_codes.state_id', 'tbllocation.State');
		// ------ CRUD BUTTONS
		//$this->crud->removeButton('update');
    }
	
	public function create()
	{
		$countryObj = new ManageCountry();
		$stateObj = new ManageStates();
		$this->data['crud'] = $this->crud;
		$this->data['countries'] = $countryObj->countryList();
		$this->data['states'] = $stateObj->stateList();
		$this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;
		return view('Admin.addLocation', $this->data);
	}

    public function store(StoreRequest $request)
    {
		$locationObj = new ManageLocations();
		$storeLocation = $locationObj->insertLocation($request);
		\Alert::success('Location added successfully')->flash();
		return \Redirect::to('admin/manageLocations');
    }
	
	public function edit($id)
	{
		$locationObj = new ManageLocations();
		$countryObj = new ManageCountry();
		$stateObj = new ManageStates();
		$this->data['entry'] = $this->crud->getEntry($id);
		$this->data['content'] = $locationObj->getEntry($id);
		$this->data['crud'] = $this->crud;
		$this->data['countries'] = $countryObj->countryList();
		$this->data['states'] = $stateObj->stateList();
		//$this->data['fields'] = $this->crud->getCreateFields();
		$this->data['title'] = trans('backpack::crud.preview').' '.$this->crud->entity_name;
		return view('Admin.editLocation', $this->data);
	}

    public function update(UpdateRequest $request)
    {
		$locationObj = new ManageLocations();
		$update = $locationObj->updateLocation($request);
		\Alert::success('Location updated successfully')->flash();
		return \Redirect::to('admin/manageLocations');
    }
	
	public function destroy($id)
	{
		$locationObj = new ManageLocations();
		$geo = $locationObj->getGeoEntry($id);
		if(count($geo) > 0) {
			$geoTitle = $geo[0]->title;
			$locationObj->sitemap('delete', $geoTitle, '');
			$locationObj->destroyGeo($id);		
		}
		#crud core functionality: destroying location entry
		$this->crud->hasAccessOrFail('delete');
        return $this->crud->delete($id);
	}
	
	public function getStateCityNameByAjax($id)
	{
		$locationObj = new ManageLocations();
		return $stateCityName = $locationObj->getStateCityName($id);
	}
}
