<?php

namespace App\Models\Site;

use \App\Models\Site\States;
use Illuminate\Database\Eloquent\Model;
use DB;

class Orders extends Model
{
    protected $table = 'tbl_order';
    protected $primaryKey = 'od_id';
    protected $fillable = ['title'];
	public $timestamps = false;
	
	
	public function saveOrderDetails(array $billing_details ,array $card_details,array $response,$user_id,array $shipping_details,$total_amount){
		//echo '<pre>'; print_r($shipping_details);die;
		if($billing_details['other_phone'] !=''){
			$other_phone = $billing_details['other_phone'];
		}else{
			$other_phone = '';
		}
		$card_no = substr_replace($card_details['card_no'], str_repeat("X", 12), 0, 12);
		$this->od_date = date('Y-m-d h:i:s'); 
		$this->od_status = 'Paid'; 
		$this->user_id = $user_id;
		$this->od_wa_cost = $total_amount;
		$this->od_shipping_email = $billing_details['email']; 
		$this->od_payment_first_name = $billing_details['first_name']; 
		$this->od_payment_last_name = $billing_details['last_name'];  
		$this->od_payment_address1 = $billing_details['address'];  
		$this->od_payment_work_phone = $other_phone; 
		$this->od_payment_city	 = $billing_details['city'];
		$this->od_payment_state	 = $billing_details['state'];
		$this->od_payment_postal_code = $billing_details['zip_code'];
		$this->od_payment_country = $billing_details['country']; 
		$this->od_payment_cctype = $card_details['payment_type'];
		$this->od_payment_ccnumber =  $card_no;
		$this->od_payment_transaction_id = $response['trans_id']; 
		$this->od_payment_approval_code = $response['auth_code']; 
		
		if(!empty($shipping_details['txtShippingFirstName'])){
			$this->od_shipping_first_name = $shipping_details['txtShippingFirstName'];
			$this->od_shipping_last_name = $shipping_details['txtShippingLastName'];
			$this->od_shipping_address1 = $shipping_details['txtShippingAddress1'];
			$this->od_shipping_phone = $shipping_details['txtShippingPhone'];
			$this->od_shipping_work_phone = $shipping_details['txtShippingWorkPhone'];
			$this->od_shipping_city = $shipping_details['txtShippingCity'];
			$this->od_shipping_state = $shipping_details['txtShippingState'];
			$this->od_shipping_postal_code = $shipping_details['txtShippingPostalCode'];
			$this->od_shipping_country = $shipping_details['txtShippingCountry'];
		}else{
			$this->od_shipping_first_name = $billing_details['first_name'];
			$this->od_shipping_last_name = $billing_details['last_name'];  
			$this->od_shipping_address1 = $billing_details['address'];  
			$this->od_shipping_work_phone = $other_phone; 
			$this->od_shipping_city = $billing_details['city'];
			$this->od_shipping_state = $billing_details['state'];
			$this->od_shipping_postal_code = $billing_details['zip_code'];
			$this->od_shipping_country = $billing_details['country'];
		}
		$this->save();
		$order_id = $this->od_id;
		return $order_id;
	}
	
	public function getOrderDetails($orderId)
	{
		$orderDetails = DB::table('tbl_order')->where('od_id', $orderId)->get();
		return $orderDetails;
	}
	
	public function getOrderItems($orderId)
	{
		$orderItems = DB::table('tbl_product')
					->join('tbl_order_item', 'tbl_order_item.pd_id', '=', 'tbl_product.pd_id')
					->where('tbl_order_item.od_id', '=', $orderId)
					->orderBy('od_id')
					->get();
		//echo '<pre>'; print_r($orderItems);die;
		return $orderItems;
	}
	
	public function getRegisteredCamp($orderId)
	{
		$stateObj = new States();
		$registeredCamps = DB::table('tbl_order_camp')
							->join('tbl_camp', 'tbl_order_camp.camp_id', '=', 'tbl_camp.id')
							->join('tbllocation', 'tbl_camp.LocationId', '=', 'tbllocation.Id')
							->select('tbl_camp.camp_focus', 'tbl_camp.cost', 'tbl_camp.startdate', 'tbl_camp.enddate', 'tbllocation.Location', 'tbllocation.City', 'tbllocation.State', 'tbl_order_camp.camp_id', 'tbl_order_camp.roster_id', 'tbl_order_camp.od_id')
							->where('tbl_order_camp.od_id', '=', $orderId)
							->orderBy('od_id')
							->get();
		$camps = array();
		foreach($registeredCamps as $registeredCamp)
		{
			$getDetailsFromRoster = DB::table('tbl_roster')
									->where('id', '=', $registeredCamp->roster_id)
									->where('camp_id', '=', $registeredCamp->camp_id)
									->get();
			$registeredCamp->State = $stateObj->getStateCode($registeredCamp->State);
			if(count($getDetailsFromRoster) > 0) {
				$registeredCamp->name = $getDetailsFromRoster[0]->name.' '.$getDetailsFromRoster[0]->fname;
				$registeredCamp->amount_paid = $getDetailsFromRoster[0]->amount_paid;
				$registeredCamp->comments = $getDetailsFromRoster[0]->comments;
				$registeredCamp->hear = $getDetailsFromRoster[0]->hear;
			} else {
				$registeredCamp->name = '';
				$registeredCamp->amount_paid = 0;
				$registeredCamp->comments = '';
				$registeredCamp->hear = '';
			}
			$camps[] = $registeredCamp;
		}
		return $camps;
	}

	public function saveTransactions($transaction_id)
	{
		DB::table('tbl_transactions')->insert(
			array(
				'transaction_id' => $transaction_id
			)
		);
	}
}
