<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;
use DB;

class Store extends Model
{
    protected $table = 'tbl_product';
	protected $primaryKey = 'id';
    protected $fillable = ['title'];
    public $timestamps = false;
	
	
	public function getStoreDetails(){
		$store = DB::table($this->table)->orderBy('pd_name', 'asc')->get();
		return $store;
	}
	
	public function getProductDetails($pid){
		$product = DB::table($this->table)->where('pd_id',$pid)->orderBy('pd_name', 'asc')->get();
		return $product;
	}
	
	public function getQtyDetails(array $productVals){
		//echo '<pre>'; print_r($productVals);die;
		/* $last_val = 0;
		foreach($productVals['qtychg'] as $key=>$chkQty){
			$last_val += $chkQty;
			$product = DB::table($this->table)->select('pd_breakqty','pd_price','pd_id')->where('pd_id',$productVals['cur_pd_id'])->first();
			//echo '<pre>'; print_r($productVals['cur_pd_id'][$key]);
			if($product->pd_breakqty < $last_val && $product->pd_id == $productVals['cur_pd_id'][$key]){//echo 'if';die;
				return "Required quantity not available!";
			}//echo 'ds';die;
		}//die; */
		
		$fild_val_count = count($productVals['cur_pd_id']);
		$cal_amt = array();
		for ($i=0; $i < $fild_val_count; $i++) {
			$cur_pd_id = $productVals['cur_pd_id'][$i];
			$qtychg = $productVals['qtychg'][$i];
			//echo '<pre>'; print_r($qtychg);
			$product = DB::table($this->table)->select('pd_breakqty','pd_price','pd_id')->where('pd_id',$cur_pd_id)->first();
			//echo '<pre>'; print_r($product);
			if ($qtychg <= $product->pd_breakqty && $cur_pd_id == $product->pd_id) { echo 'ds';
				$cal_amt[$i]['tot_price'] = $qtychg*$product->pd_price;
				$cal_amt[$i]['cur_pd_id'] = $cur_pd_id;
				$cal_amt[$i]['qtychg'] = $qtychg;
			} else {
				return "Required quantity not available!";
			}
		}//die;
		return $cal_amt;
	}
}
