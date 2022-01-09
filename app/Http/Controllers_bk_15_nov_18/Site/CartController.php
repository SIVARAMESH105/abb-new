<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\Site\Campcart;
use App\Models\Site\Groups;
use App\Models\Site\GroupInvites;
use App\Models\Site\Roster;
use App\Models\Site\Orders;
use App\Models\Site\OrderItem;
use App\Models\Site\OrderOneOnOne;
use App\Models\Site\OrderCamps;
use App\Models\Site\CountrySite;
use App\Models\Site\Users;
use App\Models\Site\Store;
use App\Jobs\SendGroupInvitationEmail;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
session_start();

#Authorize.net
require 'vendor/autoload.php'; 
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
define("AUTHORIZENET_LOG_FILE","phplog");


class CartController extends Controller
{
	public function cartPage(){
		$data = array();
		
		if(!empty($_SESSION['camp_cart_id'])) {
				$data['camp_details'] = $_SESSION['camp_details'];
				$cost1 = 0;
				foreach($data['camp_details'] as $details){
					$startdate = explode("-", $details->startdate); 
					$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
					$today = date("Y-m-d");
					$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
					if($EarlyBirdDate < $today){
						$cost = $details->cost  -$details->EarlyBirdDiscount;
					}else{
						$cost = $details->cost;
					} 
					 $cost1 += $cost;
				}
				$data['total_amount'] = $cost1;
			}else{
				$data['total_amount']='';
				$data['camp_details'] = array();
			}
			$data['productVal'] = (isset($_SESSION['product'])) ? $_SESSION['product'] : array();
			$data['training'] = (isset($_SESSION['training'])) ? $_SESSION['training'] : array();
			$data['total_pro_price'] = (isset($_SESSION['total_pro_price'])) ? $_SESSION['total_pro_price'] : array();
			$data['total_amount_training'] = (isset($_SESSION['total_amount_training'])) ? $_SESSION['total_amount_training'] : '';
		return view('Site/cart',$data);
	}
	
	public function checkoutPage(){
		if(!empty($_SESSION['camp_cart_id'])) {
			$camp_cart_id = $_SESSION['camp_cart_id'];
			//$camp_id = $_SESSION['camp_id'];
		}
		$data = array();
		if(!empty($_SESSION['camp_cart_id'])) {
			$data['camp_details'] = $_SESSION['camp_details'];
			$cost1 = 0;
				foreach($data['camp_details'] as $details){
					$startdate = explode("-", $details->startdate); 
					$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
					$today = date("Y-m-d");
					$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
					if($EarlyBirdDate < $today){
						$cost = $details->cost  -$details->EarlyBirdDiscount;
					}else{
						$cost = $details->cost;
					} 
					 $cost1 += $cost;
				}
			$data['total_amount'] = $cost1;
			$billing = new Users();
			$data['billing_val'] = $billing->getUser($_SESSION['user_id']);
		}else{
			$data['total_amount'] = '';
			$data['camp_details'] = array();
			$data['billing_val'] = array();
		}
		$data['productVal'] = (isset($_SESSION['product'])) ? $_SESSION['product'] : array();
		$data['total_pro_price'] = (isset($_SESSION['total_pro_price'])) ? $_SESSION['total_pro_price'] : array();
		$data['training'] = (isset($_SESSION['training'])) ? $_SESSION['training'] : array();
		$data['total_amount_training'] = (isset($_SESSION['total_amount_training'])) ? $_SESSION['total_amount_training'] : '';
		$sid = '';
		$countryObj = new CountrySite();
		$data['country_details'] = $countryObj->countryList($sid);
		return view('Site/checkout',$data);
	}
	
	public function paymentChoose(Request $request){
		if($request->input('grpchk') == 1){
			$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$group_code = "";
			for ($i = 0; $i < 8; $i++) {
				$group_code .= $chars[mt_rand(0, strlen($chars)-1)];
			}
			$group = new Groups();
			$group_id = $group->saveGroup($_SESSION['user_id'],$request->input('group_camp'),$group_code);
			
			$i=0;
			foreach($request->input('username') as $invites){
				$firstname = $request->input('username')[$i];
				$lastname = $request->input('lastname')[$i];
				$user_email = $request->input('grpemail')[$i];
				$groupinvites = new GroupInvites();
				if($firstname !='' && $lastname !='' && $user_email !=''){
					$invite_id = $groupinvites->saveGroupInvites($request->input('group_camp'),$user_email,$firstname,$lastname,$_SESSION['user_id'],$group_id);
				}
				$i++;
			}
			
			$user = new Users();
			$reg_username = $user->getUser($_SESSION['user_id']);
			
			$job = (new SendGroupInvitationEmail($request->all(),$reg_username->name,$_SESSION['camp_details'],$group_code))
					->delay(Carbon::now()->addSeconds(5));
			dispatch($job);
		}
		elseif($request->input('group_code') !=''){
			$group = new Groups();
			$group_id = $group->chkGroupCode($request->input('group_code'),$request->input('group_camp'));
			if($group_id == 'no'){
				return redirect('checkout/checkoutPage')->with('error', 'Group code is not valid.');
			}
			$roster = new Roster();
			$roster_sep_id = $roster->getRosterId($request->input('group_camp'));
			$roster = new Roster();
			$roster_id = $roster->updateGroupRoster($roster_sep_id->id,$group_id);
		}
		
		$_SESSION['billing_details'] = array('first_name'=>$request->input('first_name'),'last_name'=>$request->input('last_name'),'address'=>$request->input('address'),'city'=>$request->input('city'),'state'=>$request->input('state'),'zip_code'=>$request->input('zip_code'),'country'=>$request->input('country'),'email'=>$request->input('email'),'confirm_email'=>$request->input('confirm_email'),'home_phone'=>$request->input('home_phone'),'other_phone'=>$request->input('other_phone')); 
		
		$_SESSION['shipping_details'] = array('txtShippingFirstName'=>$request->input('txtShippingFirstName'),'txtShippingLastName'=>$request->input('txtShippingLastName'),'txtShippingAddress1'=>$request->input('txtShippingAddress1'),'txtShippingCity'=>$request->input('txtShippingCity'),'txtShippingState'=>$request->input('txtShippingState'),'txtShippingPostalCode'=>$request->input('txtShippingPostalCode'),'txtShippingCountry'=>$request->input('txtShippingCountry'),'txtShippingPhone'=>$request->input('txtShippingPhone'),'txtShippingWorkPhone'=>$request->input('txtShippingWorkPhone'));
		
		if(!empty($_SESSION['camp_cart_id']) && !empty($request->input('group_camp'))) {
			$camp_cart_id = $_SESSION['camp_cart_id'];
			$camp_id = $request->input('group_camp');
		}
		$data = array();
		if(!empty($_SESSION['camp_cart_id']) || !empty($request->input('group_camp'))) {
			$data['camp_details'] = $_SESSION['camp_details'];
			$cost1 = 0;
			foreach($data['camp_details'] as $details){
				$startdate = explode("-", $details->startdate); 
				$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
				$today = date("Y-m-d");
				$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
				if($EarlyBirdDate < $today){
					$cost = $details->cost  -$details->EarlyBirdDiscount;
				}else{
					$cost = $details->cost;
				} 
				 $cost1 += $cost;
			}
			$data['total_amount'] = $cost1;
			$countryObj = new CountrySite();
			$data['country_details'] = $countryObj->getCountryDetails($request->input('group_camp'));
		}else{
			$data['total_amount'] = '';
			$data['camp_details'] = array();
		}
		$data['productVal'] = (isset($_SESSION['product'])) ? $_SESSION['product'] : array();
		$data['total_pro_price'] = (isset($_SESSION['total_pro_price'])) ? $_SESSION['total_pro_price'] : array();
		$data['training'] = (isset($_SESSION['training'])) ? $_SESSION['training'] : array();
		$data['total_amount_training'] = (isset($_SESSION['total_amount_training'])) ? $_SESSION['total_amount_training'] : '';
		return view('Site/payment',$data);
	}
	
	public function paymentConfirmation(Request $request){
		if($request->input('city') == 1){
			$country='US';
		}else{
			$country='AUS';
		}
		$_SESSION['card_details'] = array('payment_type'=>$request->input('payment_type'),'card_no'=>$request->input('card_no'),'cvv'=>$request->input('cvv'),'month'=>$request->input('month'),'year'=>$request->input('year')); 

		if(!empty($_SESSION['camp_id'])) {
		$camp_cart_id = $_SESSION['camp_cart_id'];
		}
		$data = array();
		if(!empty($_SESSION['camp_cart_id'])) {
			$data['camp_details'] = $_SESSION['camp_details'];
			$cost1 = 0;
				foreach($data['camp_details'] as $details){
					$startdate = explode("-", $details->startdate); 
					$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
					$today = date("Y-m-d");
					$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
					if($EarlyBirdDate < $today){
						$cost = $details->cost  -$details->EarlyBirdDiscount;
					}else{
						$cost = $details->cost;
					} 
					 $cost1 += $cost;
			}
			$data['total_amount'] = $cost1;
			$countryObj = new CountrySite();
			$data['country_details'] = $countryObj->getCountryDetails();
			$data['billing_details'] =  $_SESSION['billing_details'];
		}else{
			$data['total_amount'] = '';
			$data['camp_details'] = array();
			$data['billing_details'] =  $_SESSION['billing_details'];
		}
		$data['productVal'] = (isset($_SESSION['product'])) ? $_SESSION['product'] : array();
		$data['total_pro_price'] = (isset($_SESSION['total_pro_price'])) ? $_SESSION['total_pro_price'] : array();
		$data['training'] = (isset($_SESSION['training'])) ? $_SESSION['training'] : array();
		$data['total_amount_training'] = (isset($_SESSION['total_amount_training'])) ? $_SESSION['total_amount_training'] : '';
		return view('Site/paymentconfirmation',$data);
	}
	
	public function confirmPayement(Request $request){
		$total_amount = $request->input('total_amount');
		/* One-on-One */
		$parent_first_name = $request->input('parent_first_name');
		$parent_last_name = $request->input('parent_last_name');
		$playername = $request->input('playername');
		$gender = $request->input('gender');
		$grade_level = $request->input('grade_level');
		$address = $request->input('address');
		$city = $request->input('city');
		$state = $request->input('state');
		$zip_code = $request->input('zip_code');
		$phone = $request->input('phone');
		$team_name = $request->input('team_name');
		$user_email = $request->input('user_email');
		$time_mon = $request->input('time_mon');
		$time_tue = $request->input('time_tue');
		$time_wed = $request->input('time_wed');
		$time_thur = $request->input('time_thur');
		$total_amount_training = $request->input('total_amount_training');
		/* One-on-One Ends*/
		$product_amount = $request->input('product_amount');
		$camp_amount = $request->input('camp_amount');
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();   
		$merchantAuthentication->setName("7v2B6R9hF");   
		$merchantAuthentication->setTransactionKey("4333entNN997uCuw");   
		$refId = 'ref' . time();
		// Create the payment data for a credit card
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($_SESSION['card_details']['card_no']);  
		$creditCard->setExpirationDate($_SESSION['card_details']['year'].'-'.$_SESSION['card_details']['month']);
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($creditCard);
		
		// Create a transaction
		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType("authOnlyTransaction");   
		$transactionRequestType->setAmount($request->input('total_amount'));
		$transactionRequestType->setPayment($paymentOne);
		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($merchantAuthentication);
		$request->setRefId($refId);
		$request->setTransactionRequest($transactionRequestType);
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);   

		if ($response != null) {
			$tresponse = $response->getTransactionResponse();
			if (($tresponse != null) && ($tresponse->getResponseCode()=="1")) {
				$data['response'] = 'success';
				$data['auth_code'] = $tresponse->getAuthCode();
				$data['trans_id'] = $tresponse->getTransId();
				if(isset($_SESSION['roster_id'])){
					if(isset($_SESSION['user_id'])){
						$user_id = $_SESSION['user_id'];
					}else{
						$user_id = $_SESSION['cur_user_id'];
					}
					foreach($_SESSION['roster_id'] as $key=>$rosterId){
						$shipping_details = array();
						$order_status = new Orders();
						$od_id = $order_status->saveOrderDetails($_SESSION['billing_details'],$_SESSION['card_details'],$data,$user_id,$shipping_details,$camp_amount);
						$order_status->saveTransactions($data['trans_id']);
						
						$roster = new Roster();
						$roster_val = $roster->getRosterDetails($rosterId['id']);
						$order_product = new OrderCamps();
						$order_product->saveOrderCampDetails($roster_val,$od_id);
					}
				}
				
				if(isset($_SESSION['product'])){
					if(isset($_SESSION['user_id'])){
						$user_id = $_SESSION['user_id'];
					}else if(isset($_SESSION['cur_user_id'])){
				      $user_id = $_SESSION['cur_user_id'];
			     	}else{
				      $user_id = '';
			     	}
					foreach($_SESSION['product'] as $products){
						if(isset($_SESSION['shipping_details'])){
							$shipping_details = $_SESSION['shipping_details'];
						}else{
							$shipping_details = array();
						}
						$order_status = new Orders();
						$od_id = $order_status->saveOrderDetails($_SESSION['billing_details'],$_SESSION['card_details'],$data,$user_id,$shipping_details,$product_amount);
						$order_status->saveTransactions($data['trans_id']);
						
						$order_product = new OrderItem();
						$order_product->saveOrderProductDetails($products,$user_id,$od_id);
					}	
				}
				if(isset($_SESSION['training'])){
					if(isset($_SESSION['user_id'])){
						$user_id = $_SESSION['user_id'];
					}else if(isset($_SESSION['cur_user_id'])){
				      $user_id = $_SESSION['cur_user_id'];
			     	}else{
				      $user_id = '';
			     	}

					if(isset($_SESSION['shipping_details'])){
						$shipping_details = $_SESSION['shipping_details'];
					}else{
						$shipping_details = array();
					}
					$order_status = new Orders();
					$od_id = $order_status->saveOrderDetails($_SESSION['billing_details'],$_SESSION['card_details'],$data,$user_id,$shipping_details,$total_amount_training);
					$order_status->saveTransactions($data['trans_id']);
					
					$order_one_on_one = new OrderOneOnOne();
					$order_one_on_one->saveOrderTrainingDetails($parent_first_name, $parent_last_name, $playername, $gender, $address, $city, $state, $phone, $zip_code, $team_name, $user_email, $time_mon, $time_tue, $time_wed, $time_thur,$data['trans_id'], $user_id, $od_id);

					// Subscription Type Info
				    $subscription = new AnetAPI\ARBSubscriptionType();
				    $subscription->setName("One-On-One Training");
				    $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
				    $interval->setLength(7);
				    $interval->setUnit("days");
				    $paymentSchedule = new AnetAPI\PaymentScheduleType();
				    $paymentSchedule->setInterval($interval);
				    $paymentSchedule->setStartDate(new DateTime(date('Y-m-d')));
				    $paymentSchedule->setTotalOccurrences("9999");
				    $paymentSchedule->setTrialOccurrences("1");
				    $subscription->setPaymentSchedule($paymentSchedule);
				    $subscription->setAmount(140);
				    $subscription->setTrialAmount("0.00");
				    $payment = new AnetAPI\PaymentType();
				    $payment->setCreditCard($creditCard);
				    $subscription->setPayment($payment);
				    $billTo = new AnetAPI\NameAndAddressType();
				    $billTo->setFirstName($_SESSION['billing_details']['first_name']);
				    $billTo->setLastName($_SESSION['billing_details']['last_name']);
				    $subscription->setBillTo($billTo);
				    $subcription_request = new AnetAPI\ARBCreateSubscriptionRequest();
				    $subcription_request->setmerchantAuthentication($merchantAuthentication);
		    		$subcription_request->setRefId($refId);
				    $subcription_request->setSubscription($subscription);
				    $sub_controller = new AnetController\ARBCreateSubscriptionController($subcription_request);
				    $subcription_response = $sub_controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
				    if ($subcription_response != null) 
					{
						if($subcription_response->getMessages()->getResultCode() == "Ok")
						{
							//$data['response'] = 'sub_success';
							$order_one_on_one->updateSubscriptionId($data['trans_id'], $subcription_response->getSubscriptionId());
						}
						else
						{
							$data['response'] = 'invalid_response';
						}
					}
					else
					{
						$data['response'] = 'null_error';
					}
				}
				unset($_SESSION['product'],$_SESSION['camps'],$_SESSION['camp_details'],$_SESSION['camp_cart_id'],$_SESSION['roster_id'], $_SESSION['training']);
				//return view('Site/paymentsuccess',$data);
			}
			else{
				$data['response'] = 'card_error';
				//return view('Site/paymentsuccess',$data);
			}
		}  
		else{	
			$data['response'] = 'null_error';
			//return view('Site/paymentsuccess',$data);
		}
		return view('Site/paymentsuccess',$data);
	}
	
	public function removeCampCart($cid){
		$campcart = new Campcart();
		$campcart->deleteCampcart($cid);
		foreach($_SESSION['camps'] as $key=>$camp_id){
			if(in_array($cid,$camp_id)){
				unset($_SESSION['camps'][$key]);
				
			}
		}
		foreach($_SESSION['camp_details'] as $key=>$campDet){
			if($cid == $campDet->id){
				unset($_SESSION['camp_details'][$key]);
			}
		}
		return redirect('cart/cartPage');
	}
	
	public function addProductCart(Request $request){
		$prod         = (isset($_SESSION['product'])) ? $_SESSION['product'] : array();
		$curr_prod_id = $request->input('pd_id');
		$curr_pro_size = $request->input('pro_size');
		$curr_pro_color = $request->input('pro_color');
		$flag = 0;
		
		foreach($prod as $key=>$val) {
			if($val['pd_id'] == $curr_prod_id){
				if($val['pro_size'] == $curr_pro_size && $val['pro_color'] == $curr_pro_color) {
					
					$_SESSION['product'][$key]['pd_price'] += ($request->input('pd_price') * $request->input('pd_qty'));
					$pd_ttl = ($request->input('pd_price') * $request->input('pd_qty'));
					$_SESSION['product'][$key]['pd_qty']   += $request->input('pd_qty');
					$_SESSION['total_pro_price'] += $pd_ttl;
					$flag = 1;
					
				}
				if($val['pro_size'] != $curr_pro_size && $val['pro_color'] == $curr_pro_color) {//echo '11';die;
					
					$amount = $request->input('pd_price') * $request->input('pd_qty');
					if(isset($_SESSION['total_pro_price'])){
						$_SESSION['total_pro_price'] += $amount;
					} else {
						$_SESSION['total_pro_price'] = $amount;
					}
				}
				if($val['pro_size'] == $curr_pro_size && $val['pro_color'] != $curr_pro_color){
					$amount = $request->input('pd_price') * $request->input('pd_qty');
					if(isset($_SESSION['total_pro_price'])){
						$_SESSION['total_pro_price'] += $amount;
					} else {
						$_SESSION['total_pro_price'] = $amount;
					}
				}
				if($val['pro_size'] != $curr_pro_size && $val['pro_color'] != $curr_pro_color){
					$amount = $request->input('pd_price') * $request->input('pd_qty');
					if(isset($_SESSION['total_pro_price'])){
						$_SESSION['total_pro_price'] += $amount;
					} else {
						$_SESSION['total_pro_price'] = $amount;
					}
				}
			}
		}
		
		if(!$flag) {
			$amount = $request->input('pd_price') * $request->input('pd_qty');
			if(isset($_SESSION['total_pro_price'])){
				$_SESSION['total_pro_price'] += $amount;
			} else {
				$_SESSION['total_pro_price'] = $amount;
			}
			$_SESSION['product'][] = array('pd_price'=> $amount,'pd_specialprice'=>$request->input('pd_specialprice'),'pd_id'=>$request->input('pd_id'),'pd_qty'=>$request->input('pd_qty'),'pro_size'=>$request->input('pro_size'),'pro_color'=>$request->input('pro_color'),'pd_name'=>$request->input('pd_name'));
		}
		if(!empty($_SESSION['camp_cart_id'])) {echo '1';exit;
				$data['camp_details'] = $_SESSION['camp_details'];
				$cost1 = 0;
				foreach($data['camp_details'] as $details){
					$startdate = explode("-", $details->startdate); 
					$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
					$today = date("Y-m-d");
					$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
					if($EarlyBirdDate < $today){
						$cost = $details->cost  -$details->EarlyBirdDiscount;
					}else{
						$cost = $details->cost;
					} 
					 $cost1 += $cost;
				}
				$data['total_amount'] = $cost1;
			}else{
				$data['total_amount']='';
				$data['camp_details'] = array();
			}
		
		$data['productVal'] = $_SESSION['product'];
		$data['total_pro_price'] = $_SESSION['total_pro_price'];
		return redirect('cart/cartPage');
		//return view('Site/cart',$data);
	}
	
	public function removeProductCart($pid,$pd_price,$pd_size,$pd_color){
		foreach($_SESSION['product'] as $key=>$pro_id){
			if(in_array($pid,$pro_id)){
				if($pro_id['pro_size'] == $pd_size && $pro_id['pro_color'] == $pd_color) {//echo '11';
					unset($_SESSION['product'][$key]);
				}
			}
		}
		$_SESSION['total_pro_price'] = $_SESSION['total_pro_price'] - $pd_price;
		return redirect('cart/cartPage');
	}
	
	public function UpdateQtyInfo(Request $request){
		$Product = new Store();
		$data['details'] = $Product->getQtyDetails($request->all());
		if ($data['details'] != "Required quantity not available!") {
			$session_data = $_SESSION['product'];
			//echo '<pre>'; print_r($session_data);die;
			$cost1 = 0;
			foreach($session_data as $key => $value) {
				foreach($data['details'] as $key1 => $value1){
					if($value['pd_id'] == $value1['cur_pd_id']) {
						$_SESSION['product'][$key]['pd_price'] = $value1['tot_price'];
						$_SESSION['product'][$key]['pd_qty'] = $value1['qtychg'];
						$amt_val = $value1['tot_price'];
						$cost1 += $amt_val;
						$_SESSION['total_pro_price'] = $cost1;
					}
				}
			}
		} else {
			return redirect ('cart/cartPage')->with(array('error'=>'Required quantity not available!'));
		}
		return redirect('cart/cartPage');
	}

	public function addOneOnOne(Request $request){
		$training         = (isset($_SESSION['training'])) ? $_SESSION['training'] : array();
		$_SESSION['training']['parent_first_name'] = $request->input('parent_first_name');
		$_SESSION['training']['parent_last_name'] = $request->input('parent_last_name');
		$_SESSION['training']['playername'] = $request->input('playername');
		$_SESSION['training']['gender'] = $request->input('gender');
		$_SESSION['training']['grade_level'] = $request->input('grade_level');
		$_SESSION['training']['address'] = $request->input('address');
		$_SESSION['training']['city']= $request->input('city');
		$_SESSION['training']['state'] = $request->input('state');
		$_SESSION['training']['zip_code'] = $request->input('zip_code');
		$_SESSION['training']['phone'] = $request->input('phone');
		$_SESSION['training']['team_name'] = $request->input('team_name');
		$_SESSION['training']['user_email'] = $request->input('user_email');
		$_SESSION['training']['time_mon'] = $request->input('time-mon');
		$_SESSION['training']['time_tue'] = $request->input('time-tue');
		$_SESSION['training']['time_wed'] = $request->input('time-wed');
		$_SESSION['training']['time_thur'] = $request->input('time-thur');
		$_SESSION['training']['unlimited_training'] = $request->input('unlimited_training');
		$_SESSION['total_amount_training'] = 140;
		
		if(!empty($_SESSION['camp_cart_id'])) {
				$data['camp_details'] = $_SESSION['camp_details'];
				$cost1 = 0;
				foreach($data['camp_details'] as $details){
					$startdate = explode("-", $details->startdate); 
					$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
					$today = date("Y-m-d");
					$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
					if($EarlyBirdDate < $today){
						$cost = $details->cost  -$details->EarlyBirdDiscount;
					}else{
						$cost = $details->cost;
					} 
					 $cost1 += $cost;
				}
				$data['total_amount'] = $cost1;
			}else{
				$data['total_amount']='';
				$data['camp_details'] = array();
			}
		
		$data['training'] = $_SESSION['training'];
		$data['total_amount_training'] = $_SESSION['total_amount_training'];
		return redirect('cart/cartPage');
		//return view('Site/cart',$data);
	}

	public function removeTrainingCart(){	
		unset($_SESSION['training']);
		return redirect('cart/cartPage');
	}
}
