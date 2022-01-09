<?php

namespace App\Models\Site;

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
	
	public function getProductColor($pid){
		$color = DB::table('tbl_product')
					->join('tbl_color', 'tbl_color.color_id', '=', 'tbl_product.pd_color')
					->where('tbl_product.pd_id', '=', $pid)
					->get();
		return $color;
	}
	
	public function saveProductColorDetails($color,$pd_id){
		$this->pd_attr_color	= $color;
		$this->pd_attr_productid	= $pd_id;
		$this->save();
		return $this->pd_attr_id;
	}
}
