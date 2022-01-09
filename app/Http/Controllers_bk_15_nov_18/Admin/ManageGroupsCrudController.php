<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageGroups;
use App\Models\Admin\ManageCamps;
use App\Models\Admin\ManageStates;
use App\Jobs\SendGroupInvitationEmail;
use App\Jobs\ResendGroupInvitationEmail;
use Carbon\Carbon;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageGroupsRequest as StoreRequest;
use App\Http\Requests\ManageGroupsRequest as UpdateRequest;

class ManageGroupsCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageGroups');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageGroups');
        $this->crud->setEntityNameStrings('Group', 'Manage Groups');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();
		$this->crud->setColumns([
									[
										'name' => 'camp_id',
										'label' => 'Camp Name',
										'type'  => 'model_function',
										'function_name' => 'getCampName'
									],
									[
										'name' => 'camp_id',
										'label' => 'City',
										'type'  => 'model_function',
										'function_name' => 'getCity'
									],
									[
										'name' => 'camp_id',
										'label' => 'State',
										'type'  => 'model_function',
										'function_name' => 'getState'
									],
									[
										'name' => 'camp_id',
										'label' => 'Start Date',
										'type'  => 'model_function',
										'function_name' => 'getCampStartDate'
									],
									[
										'name' => 'camp_id',
										'label' => 'Number of Groups',
										'type'  => 'model_function',
										'function_name' => 'getNumberOfGroups'
									],
								]);

        // ------ CRUD FIELDS

        // ------ CRUD COLUMNS

        // ------ CRUD BUTTONS
        $this->crud->removeAllButtons();

        // ------ CRUD ACCESS

        // ------ CRUD REORDER

        // ------ CRUD DETAILS ROW

        // ------ REVISIONS

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        //$this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS

        // ------ ADVANCED QUERIES
        $this->crud->groupBy('camp_id');
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
	
	public function groupDetails($campId)
	{
		$campObj = new ManageCamps();
		$data['campName'] = $campObj->getCampName($campId);
		$groupObj = new ManageGroups();
		$data['groupInvityDetails'] = $groupObj->getGroupDetails($campId);
		$data['campId'] = $campId;
		return view('Admin.groupDetails', $data);
	}
	
	public function inviteMembers()
	{
		$campObj = new ManageCamps();
		$stateObj = new ManageStates();
		$groupObj = new ManageGroups();
		$username = $groupObj->getGroupOrganizerName($_POST['group_code']);
		$campDetails = $campObj->getCamp($_POST['campId']);
		$campDetails[0]->state_name = $stateObj->getStateName($campDetails[0]->State);
		$reg_username = (object)array('name' => $username);
		$job = (new SendGroupInvitationEmail($_POST,$reg_username,$campDetails,$_POST['group_code']))
					->delay(Carbon::now()->addSeconds(2));
		dispatch($job);
		echo 'sent';
	}
	
	public function resendInvite()
	{
		//print_r($_POST); exit;
		$campObj = new ManageCamps();
		$stateObj = new ManageStates();
		$campDetails = $campObj->getCamp($_POST['campId']);
		$campDetails[0]->state_name = $stateObj->getStateName($campDetails[0]->State);
		$job = (new ResendGroupInvitationEmail($_POST,$campDetails))
					->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
	}
	
	function updateInvite()
	{
		//echo "<pre>"; print_r($_POST); exit;
		$groupObj = new ManageGroups();
		$updateInvity = $groupObj->updateInvity($_POST);
	}
	
	function deleteInvity()
	{
		//echo "<pre>"; print_r($_POST); exit;
		$groupObj = new ManageGroups();
		$delete = $groupObj->deleteInvity($_POST['id']);
	}
}
