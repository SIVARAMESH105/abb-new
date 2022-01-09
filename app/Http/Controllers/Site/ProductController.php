<?php
namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Store;
use App\Models\Site\tshirtSize;
use App\Models\Site\ProductAttributeColor;
use Carbon\Carbon;
session_start();

class ProductController extends Controller
{
    public function ProductDetail($pid){
		$Product = new Store();
		$data['details'] = $Product->getProductDetails($pid);
		if(count($data['details'])>0) {
			$ProductSize = new tshirtSize();
			$get_product_size = $ProductSize->getProductSizeDetails($data['details'][0]->pd_size);
			if(!empty($get_product_size[0])) {
				$data['get_product_size'] = $get_product_size;
			} else {
				$data['get_product_size'] = '';
			}
			
			
			//echo '<pre>'; print_r($data['get_product_size']);die;
			/* $ProductSize = new ProductAttributeSize();
			$data['get_product_size'] = $ProductSize->getProductSizeDetails($pid);
			if($data['get_product_size']->isEmpty()){
				$data['product_size'] = $ProductSize->getProductSize($pid);
				//echo '<pre>'; print_r($data['product_size']);die;
			} */
			$ProductColor = new ProductAttributeColor();
			$data['get_product_color'] = $ProductColor->getProductColorDetails($pid);
			if($data['get_product_color']->isEmpty()){
				$data['product_color'] = $ProductColor->getProductColor($pid);
			}
		}
		return view('Site/product_detail', $data);
	}
}
?>