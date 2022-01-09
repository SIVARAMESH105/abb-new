<?php

namespace App\Http\Controllers\Admin;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\User;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageCoachesRequest as StoreRequest;
use App\Http\Requests\ManageCoachesRequest as UpdateRequest;
use App\Jobs\SendCoachesEmail;
use Carbon\Carbon;
use Auth;

class ManageCoachesCrudController extends CrudController
{
	
	public function __construct()
	{	
		parent::__construct();
		$user = Auth::user();
		$id = Auth::id();
		//echo '<pre>'; print_r($user); die;
	}
	
    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageCoaches');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageCoaches');
        $this->crud->setEntityNameStrings('Coach', 'Manage Coaches');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name'  => 'first_name',
										'label' => 'Coach Name',
										'type'  => 'model_function',
										'function_name' => 'mergeCoachName'
									],
									[
										'name'  => 'city',
										'label' => 'City',
										'type'  => 'text',
									],
									[
										'name'  => 'state',
										'label' => 'State',
										'type'  => 'text',
									],
									[
										'name'  => 'home_phone',
										'label' => 'Phone',
										'type'  => 'text'
									],
									[
										'name'  => 'email',
										'label' => 'Email',
										'type'  => 'model_function',
										'function_name' => 'getEmailLink'
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'first_name',
										'label' => 'First Name<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'last_name',
										'label' => 'Last Name<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'username',
										'label' => 'Username<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'password',
										'label' => 'Password<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'email',
										'label' => 'Email<span class="red">*</span>',
										'type'  => 'email'
									],
									[
										'name'  => 'gender',
										'label' => 'Gender<span class="red">*</span>',
										'type'  => 'radio',
										'options' => [
														'female' => "Female",
														'male' => "Male"
													],
										'inline'      => true, // show the radios all on the same line?
									],
									[
										'name' => 'tshirt_size',
										'label' => 'T-shirt Size<span class="red">*</span>',
										'type' => 'select',
										'entity' => 'tshirtSize', // the method that defines the relationship in your Model
										'attribute' => 'size', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\TshirtSize" // foreign key model
									],
									[
										'name'  => 'dob',
										'label' => 'Coach Birthdate<span class="red">*</span> (MM/DD/YYYY)',
										'type'  => 'date_picker',
										'date_picker_options' => [
											  'todayBtn' => 'linked',
											  'format' => 'mm-dd-yyyy',
											  'language' => 'en'
										]
								
									],
									[
										'name'  => 'emp_startdate',
										'label' => 'Employment Start Date (MM/DD/YYYY)',
										'type'  => 'date_picker',
										'date_picker_options' => [
											  'todayBtn' => 'linked',
											  'format' => 'mm-dd-yyyy'
										],
									],
									[
										'name'  => 'address',
										'label' => 'Address<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'city',
										'label' => 'City<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'state',
										'label' => 'State<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'zip',
										'label' => 'Zip Code<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name' => 'country',
										'lebel' => 'Country<span class="red">*</span>',
										'type' => 'select',
										'entity' => 'country', // the method that defines the relationship in your Model
										'attribute' => 'country_name', // foreign key attribute that is shown to user
										'model' => "App\Models\Admin\ManageCountry" // foreign key model
									],
									[
										'name'  => 'home_phone',
										'label' => 'Home Phone<span class="red">*</span>',
										'type'  => 'text'
									],
									[
										'name'  => 'cellphone',
										'label' => 'Cell Phone',
										'type'  => 'text'
									],
									[
										'name'  => 'work_phone',
										'label' => 'Work/Other Phone',
										'type'  => 'text'
									],
									[
										'name'  => 'notes',
										'label' => 'Notes',
										'type'  => 'textarea',
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
        $this->crud->orderBy('first_name');
    }

    public function store(StoreRequest $request)
    {
		// your additional operations before save here
		$userObj = new User();
		$userId = $userObj->insertCoach($request->all());
		$request->request->set('user_id', $userId);
		$request->request->remove('username');
		$request->request->remove('password');
		
		$redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        return $redirect_location;
    }
	
	public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;
		$userObj = new User();
		$user = $userObj->getUser($this->data['entry']['user_id']);
		if(count($user) > 0) {
			$this->data['fields']['username']['value'] = $user->email;
			$this->data['fields']['password']['value'] = $user->password;
		}

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
		$userObj = new User();
		$userId = $userObj->updateCoach($request->all());
		
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        return $redirect_location;
    }
	
	public function sendEmailAllCoaches()
    {
		$job = (new SendCoachesEmail())
                    ->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
		return redirect('admin/manageCoaches');
    }
}
