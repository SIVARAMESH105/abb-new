<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductAttributeSize extends Model
{
    protected $table = 'tbl_product_attribute_size';
	protected $primaryKey = 'pd_attr_size_id ';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function getProductSizeDetails($pid){
		
		$size = DB::table($this->table)->where('pd_attr_productid',$pid)->get();
		return $size;
	}
	
	public function saveProductSizeDetails($size,$pd_id){
		$product = DB::table($this->table)->where('pd_attr_productid',$pd_id)->first();
		$size_val = DB::table('tbl_tshirt_size')->where('id',$size)->first();
		if(empty($product)){
			$size_val = DB::table('tbl_tshirt_size')->where('id',$size)->first();
			//echo '<pre>'; print_r($size_val->sizecode);die;
			$this->pd_attr_size	= $size_val->sizecode;
			$this->pd_attr_productid	= $pd_id;
			$this->save();
			return $this->pd_attr_size_id;
		}else{
			DB::table($this->table)->where('pd_attr_productid',$pd_id)->update(['pd_attr_size'=> $size_val->sizecode]);
			return;
		}
	}
}
