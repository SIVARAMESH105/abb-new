<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Models\Admin\ManageProducts;
use App\Models\Admin\ManageColors;
use App\Models\Admin\TshirtSize;
use App\Models\Admin\Location;
use App\Models\Admin\ProductAttributeSize;
use App\Models\Admin\ProductAttributeColor;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManageProductsRequest as StoreRequest;
use App\Http\Requests\ManageProductsRequest as UpdateRequest;

class ManageProductsCrudController extends CrudController
{

    public function setUp()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\ManageProducts');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manageProducts');
        $this->crud->setEntityNameStrings('Product', 'Manage Product');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        //$this->crud->setFromDb();

        // ------ CRUD FIELDS
		$color = new ManageColors();
		$size = new TshirtSize();
		$this->crud->setColumns([
									[
										'name'  => 'pd_name',
										'label' => 'Product Name',
										'type'  => 'text',
									],
									[
										'name'  => 'pd_thumbnail',
										'label' => 'Thumbnail',
										'type' => 'model_function',
										'function_name' => 'showImage',
										
									]
								]);
		$this->crud->addFields([
									[
										'name'  => 'pd_name',
										'label' => 'Product Name<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'label' => 'Category<span class="red">*</span>',
										'name'  => 'pd_category',
										'type'  => 'select_from_array',
										'options' => ['' => 'Select', 'Clothing' => 'Clothing', 'Audio-Video' => 'Audio-Video', 'Equipment' => 'Equipment'],
										'allows_null' => false,
									],
									[
										'name' => 'pd_description',
										'label' => 'Description<span class="red">*</span>',
										'type' => 'ckeditor'
									],
									[
										'name'  => 'pd_shorttitle',
										'label' => 'Short Description',
										'type'  => 'text',
									],
									
									[
										'name'  => 'pd_price',
										'label' => 'Price<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'name'  => 'pd_specialprice',
										'label' => 'Discount Price',
										'type'  => 'text',
									],
									[
										'name'  => 'pd_breakqty',
										'label' => 'Break Qty<span class="red">*</span>',
										'type'  => 'text',
									],
									[
										'label' => 'Color<span class="red">*</span>',
										'name'  => 'pd_color',
										'type'  => 'select_from_array',
										/* 'options' => ['' => 'Select', 'red-white-blue' => 'Red,White and Blue', 'red' => 'Red', 'white' => 'White', 'blue' => 'Blue', 'blue-red' => 'Blue and red', 'red-white' => 'Red and white'], */
										'allows_null' => false,
										'options' =>  $color->getColorDetails()
									],
									[
										'name' => 'pd_size',
										'label' => 'Size<span class="red">*</span>',
										'type' => 'select2_from_array',
										/* 'options' => ['Y-M' => 'Y-M', 'A-S' => 'A-S', 'A-M' => 'A-M', 'A-L' => 'A-L', 'A-XL' => 'A-XL', 'A-XXL' => 'A-XXL'], */
										'allows_null' => false,
										'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
										'options' =>  $size->getSizeDetails()
									],
									[
										'name'  => 'pd_image',
										'label' => 'Main Image',
										'type'  => 'upload',
										'attributes' => ['class' => 'form-control file-browse'],
										'upload' => true,
										'disk' => 'main' // specify the upload disk form config/filesystems.php. if you store files in the /public folder, please ommit this; if you store them in /storage or S3 or other, please specify it;
									],
									[
										'name'  => 'pd_thumbnail',
										'label' => 'Thumbnail Image',
										'type'  => 'upload',
										'attributes' => ['class' => 'form-control file-browse'],
										'upload' => true,
										'disk' => 'thumbnail' // specify the upload disk form config/filesystems.php. if you store files in the /public folder, please ommit this; if you store them in /storage or S3 or other, please specify it;
									],
									
									[
										'name'  => 'pd_staff',
										'label' => 'View only for staff',
										'type'  => 'checkbox',
										'options' => [
														1 => ""
													],
										// optional
										'inline'      => true, // show the radios all on the same line?
									],
									[
										'name'  => 'pd_status',
										'label' => 'Status',
										'type'  => 'radio',
										'options' => [
														1 => "Active",
														0 => "Inactive"
													],
										// optional
										'inline'      => true, // show the radios all on the same line?
									],
									[
										'name' => 'pd_date',
										'label' => 'Create Date',
										'type' => 'datetime',
										'default' => date('Y-m-d H:i:s')
									],
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
        $this->crud->orderBy('pd_name');
    }

    public function store(StoreRequest $request)
    {	$main_img_ext = pathinfo($request->pd_image->getClientOriginalName(), PATHINFO_EXTENSION);
		$thum_img_ext = pathinfo($request->pd_thumbnail->getClientOriginalName(), PATHINFO_EXTENSION);
		if($main_img_ext == 'jpg' || $main_img_ext == 'png' || $main_img_ext == 'jpeg' && $thum_img_ext == 'jpg' || $thum_img_ext == 'png' || $thum_img_ext == 'jpeg'){
			if(isset($request->pd_size)) {
			$request->request->add(['pd_size' => implode(",",$request->pd_size)]);
			}
			$redirect_location = parent::storeCrud($request);
			// your additional operations after save here
			// use $this->data['entry'] or $this->crud->entry
			return $redirect_location;
		}else{
			\Alert::error(trans('backpack::crud.insert_upload_error'))->flash();
			return redirect('admin/manageProducts/create');
		}
	}
	
	public function edit($id)
	{
		// Copied the code from core controller function and modified
		$this->crud->hasAccessOrFail('update');
        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
		$this->data['fields']['pd_size']['value'] = explode(',', $this->data['fields']['pd_size']['value']);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;
        $this->data['id'] = $id;
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
	}

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
		//echo '<pre>'; print_r($request->all());die;
		/* foreach($request->pd_size as $size){
			$ProductSize = new ProductAttributeSize();
			$ProductSize->saveProductSizeDetails($size,$request->pd_id);
		}
		$ProductColor = new ProductAttributeColor();
		$ProductColor->saveProductColorDetails($request->pd_color,$request->pd_id); */
	
		
		if(isset($request->pd_size)) {
			$request->request->add(['pd_size' => implode(",",$request->pd_size)]);
		} else {
			$request->request->add(['pd_size' => '']);
		}
		
		$redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
