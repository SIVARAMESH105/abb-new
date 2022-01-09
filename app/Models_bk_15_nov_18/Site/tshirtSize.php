<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use DB;

class TshirtSize extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'tbl_tshirt_size';
    protected $primaryKey = 'id';
    //public $timestamps = false;
    // protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function getSizeDetails() {
		$sizes = $this->get()->toArray();
		$ret_array = array();
		foreach($sizes as $key=>$value) {
			$ret_array[$value['id']] = $value['sizecode'];
		}
		return $ret_array;
	}
	
	public function getProductSizeDetails($p_sizeId){
		$s_id = explode(',',$p_sizeId);
		foreach($s_id as $id){
			$size[] = DB::table('tbl_tshirt_size')
					->where('tbl_tshirt_size.id', '=', $id)
					->first();
		}
		return $size;
		
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
}
