<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderItem extends Model
{
    protected $table = 'tbl_order_item';
	protected $primaryKey = 'od_id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	public function saveOrderProductDetails(array $products,$user_id,$od_id){
		$this->od_id	= $od_id;
		$this->pd_id	= $products['pd_id'];
		$this->od_qty	= $products['pd_qty'];
		$this->od_size 	= $products['pro_size'];
		$this->od_color = $products['pro_color']; 
		$this->od_user_id 	= $user_id;
		$this->sts 		=  1;
		$this->save();
		return $this->od_id;
	}
}
