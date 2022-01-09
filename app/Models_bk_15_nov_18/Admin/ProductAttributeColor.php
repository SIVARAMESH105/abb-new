<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductAttributeColor extends Model
{
    protected $table = 'tbl_product_attribute_color';
	protected $primaryKey = 'pd_attr_id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function getProductColorDetails($pid){
		
		$color = DB::table($this->table)->where('pd_attr_productid',$pid)->get();
		return $color;
	}
	
	public function saveProductColorDetails($color,$pd_id){
		$product = DB::table($this->table)->where('pd_attr_productid',$pd_id)->first();
		$color_val = DB::table('tbl_color')->where('color_id',$color)->first();
		if(empty($product)){
			$this->pd_attr_color	= $color_val->color_name;
			$this->pd_attr_productid	= $pd_id;
			$this->save();
			return $this->pd_attr_id;
		}else{
			DB::table($this->table)->where('pd_attr_productid',$pd_id)->update(['pd_attr_color'=> $color_val->color_name]);
			return;
		}
		
	}
}
