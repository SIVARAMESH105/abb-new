<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProfileCrudRequest as StoreRequest;
use App\Http\Requests\ProfileCrudRequest as UpdateRequest;

class ProfileCrudController extends CrudController {

	public function setup() {
        $this->crud->setModel("App\Models\Admin\Profile");
        $this->crud->setRoute("admin/profile");
        $this->crud->setEntityNameStrings('profile', 'profiles');

        $this->crud->setColumns([
									[
										'name'  => 'name',
										'label' => 'Name',
										'type'  => 'text',
									],
									[
										'name'  => 'email',
										'label' => 'Email',
										'type'  => 'text',
									]
								]);
		$this->crud->removeButton('create');
		$this->crud->removeButton('delete');
        $this->crud->addFields([
								[
									'name' => 'name',
									'label' => "Name",
								],
								[
									'name' => 'email',
									'label' => "Email",
								]
							]);
    }

	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
}
?>