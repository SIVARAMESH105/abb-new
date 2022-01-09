<?php

namespace App\Models\Site;

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
	
	public function getProductSize($pid){
		$size = DB::table('tbl_product')
					->join('tbl_tshirt_size', 'tbl_tshirt_size.id', '=', 'tbl_product.pd_size')
					->where('tbl_product.pd_id', '=', $pid)
					->get();
		return $size;
	}
	
	public function saveProductSizeDetails($size,$pd_id){
		$size_val = DB::table('tbl_tshirt_size')->where('id',$size)->first();
		$this->pd_attr_size	= $size_val;
		$this->pd_attr_productid	= $pd_id;
		$this->save();
		return $this->pd_attr_size_id;
	}
}
