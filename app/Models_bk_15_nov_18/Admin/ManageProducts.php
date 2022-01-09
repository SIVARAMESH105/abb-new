<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class ManageProducts extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_product';
    protected $primaryKey = 'pd_id';
	public $timestamps = false;
    protected $fillable = [ 'pd_id', 'pd_name', 'pd_thumbnail','pd_category', 'pd_shorttitle', 'pd_description','pd_price','pd_color','pd_size','pd_specialprice','pd_breakqty','pd_qty','pd_image','pd_staff','pd_status','pd_date'];
	
    // protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	function showImage() {  
		$url = url('/');
		$path = $url .'/public/uploads/images/products/thumbnail/'.$this->pd_thumbnail;
		return "<img src='" . $path . "' width=100>";
	}

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
	/*file upload for product main image*/
	public function setPdImageAttribute($value) {	#function name should defind in camelcase with respective DB field
        $attribute_name = "pd_image";
        $disk = "main";
        $destination_path = "";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
	/*file upload for product thumbnail image*/
	public function setPdThumbnailAttribute($value) {	#function name should defind in camelcase with respective DB field
        $attribute_name = "pd_thumbnail";
        $disk = "thumbnail";
        $destination_path = "";
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
