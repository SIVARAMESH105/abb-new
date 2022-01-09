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
use App\Models\Site\AffiliateFees;
use App\Models\Site\Affiliate;
use App\Models\Site\Cards;
use App\Models\Site\Wallet;
use App\Models\Site\ProductAttributeSize;
use App\Models\Site\WebshipReference;
use App\Jobs\SendGroupInvitationEmail;
use App\Jobs\OrderConfirmationEmail;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Session;
use Auth;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
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
					if($EarlyBirdDate > $today){
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
			$data['affcode'] = Session::get('affcode');
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
					if($EarlyBirdDate > $today){
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
		$data['title'] = "Checkout Page";
		$data['affcode'] = Session::get('affcode');
		return view('Site/checkout',$data);
	}
	
	public function paymentChoose(Request $request){  
		$uspsVerification = $this->verifyNewUSPSshippingAddress($request);     
		//$uspsVerification = 0;  
		if($uspsVerification==1) {
			if($request->input('grpchk') == 1) {
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
					return redirect('checkout/checkoutPage')->with('error', 'Group code is not valid.')->withInput($request->all);
				}
				$roster = new Roster();
				$roster_sep_id = $roster->getRosterId($request->input('group_camp')); 
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
					if($EarlyBirdDate > $today){
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
			$data['title'] = "Payment";
			$data['affcode'] = Session::get('affcode');
			//Get Wallet details
			$authId = Auth::id();
			$wallet = new Wallet();
			$data['wallet'] = $wallet->getDetailsByUserId($authId);
			//Webship api code start here
			//To do for shipping amount calcluation
			 if (!empty($_SESSION['product'])) {
				$shippingResponse = $this->getActualShippingFee($request->all());
				$shippingRes = json_decode($shippingResponse);
				$data['shipping_charges'] = '';
				if(!empty($shippingResponse) && !isset($shippingRes->errorCategory)) {
					//calculate the shipping charges 
					$shipping_charges = ($shippingRes->totalAmount/ 100) * 10;
					$data['shipping_charges'] = $shippingRes->totalAmount+$shipping_charges;
					$webShip = $this->postOrderToWebship($data, $request);
					$_SESSION['webShipOrder'] =1;
				}
				//print_r(json_decode($shippingResponse));
				//print_r($data['shipping_charges']);exit;
				
			}
			return view('Site/payment',$data);
		} else {
			return redirect('checkout/checkoutPage')->with('error', 'Address is not valid.')->withInput($request->all);
		}
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
				if($EarlyBirdDate > $today){
					$cost = $details->cost  -$details->EarlyBirdDiscount;
				}else{
					$cost = $details->cost;
				}
                $cost1 += $cost;
			}
            // check products not exist in cart
            if (empty($_SESSION['product']) && empty($_SESSION['training'])) {
                // Reduce amount from wallet
                $myWallet = $request->input('my_wallet');
                $walletDiscount = (!empty($myWallet)) ? $myWallet : '';
                if (!empty($walletDiscount)){
                    $authId = Auth::id();
                    $walletObj = new Wallet();
                    $walletAmount = number_format($walletObj->getDetailsByUserId($authId),2,'.','');
                    $cost1 = number_format($cost1,2,'.','');
                    $data['amount_before_using_wallet'] = $cost1;
                    if ($cost1 <= $walletAmount) {
                        $cost1 = 0;
                    } else {
                        $cost1 = $cost1 - $walletAmount;
                    }
                } 
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
		//shipping charges
		if(!empty($data['productVal'])) {
			$data['shipping_charges']=$request['shipping_total_amt'];
		}
        //exit;
		$data['total_pro_price'] = (isset($_SESSION['total_pro_price'])) ? $_SESSION['total_pro_price'] : array();
		$data['training'] = (isset($_SESSION['training'])) ? $_SESSION['training'] : array();
		$data['total_amount_training'] = (isset($_SESSION['total_amount_training'])) ? $_SESSION['total_amount_training'] : '';
		$data['title'] = "Payment";
		$data['affcode'] = Session::get('affcode');
		return view('Site/paymentconfirmation',$data);
	}
	
	public function confirmPayement(Request $request){
		$total_amount = $request->input('total_amount');
        $amountBeforeUsingwallet = $request->input('amount_before_using_wallet');
        $amountBefore = (!empty($amountBeforeUsingwallet)) ? $amountBeforeUsingwallet : '';
        $usedWallet = false;
        if (!empty($amountBefore) && $amountBefore != $total_amount){
            $amountBefore = number_format($amountBeforeUsingwallet,2,'.','');
            $walletObj = new Wallet();
            $walletExist = $walletObj->checkWalletExistence(Auth::id());
            if (count($walletExist) > 0 ) {
                $walletTableId = $walletExist[0]->id;
                $existingWalletAmount = $walletExist[0]->wallet_amount;
                $updateWalletBalance = ($amountBefore >= $existingWalletAmount) ? '0.00' : $existingWalletAmount-$amountBefore;
                $updateWalletData = array('id'=> $walletTableId,'wallet_amount' => $updateWalletBalance, 'updated_at' => date('Y-m-d H:i:s'));
                $updateWallet = $walletObj->updateWalletDetails($updateWalletData);
                $usedWallet = true;
            }
        }
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
        $order_status = new Orders();
        $roster = new Roster();
        $order_product = new OrderCamps();

        if ($total_amount != 0) {
    		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();   
    		$merchantAuthentication->setName(env('AUTHORIZE_LOGIN_ID','6GW2re6y'));   
    		$merchantAuthentication->setTransactionKey(env('AUTHORIZE_TRANS_KEY','729vF6T9M9xgGcQ6'));   
    		//$merchantAuthentication->setName('6GW2re6y');   
    		//$merchantAuthentication->setTransactionKey('4A7t7z26N22r8ZT4');   
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
    						$od_id = $order_status->saveOrderDetails($_SESSION['billing_details'],$_SESSION['card_details'],$data,$user_id,$shipping_details,$camp_amount);
    						$order_status->saveTransactions($data['trans_id']);

                            $rosterPaymentStatus = $roster->updateRosterPaymentStatus($rosterId['id']);
    						$roster_val = $roster->getRosterDetails($rosterId['id']);
    						$order_product->saveOrderCampDetails($roster_val,$od_id);

    					}
    				}
    				/*Affilite User fees update for each camp register*/
    				if(isset($_SESSION['camp_details']) && Session::get('affcode')!='') {
    					$cost1=0;
    					foreach($_SESSION['camp_details'] as $key=>$cdetails){
    						$startdate = explode("-", $cdetails->startdate); 
    						$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
    						$today = date("Y-m-d");
    						$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$cdetails->EarlyBirdDays.' day' . $Esdate ));
    						if($EarlyBirdDate > $today){
    							$cost = $cdetails->cost  -$cdetails->EarlyBirdDiscount;
    						}else{
    							$cost = $cdetails->cost;
    						} 
    						$cost1 += $cost;
    						$code = Session::get('affcode');
    						$affModel = new Affiliate();
    						$affiliateRes = $affModel->getAffiliateByCode($code);
    						$affFees = new AffiliateFees();
    						$dataArray = array("user_id"=>$user_id,"rosterId"=>$_SESSION['roster_id'][$key]['id'],"affiliateId"=>$affiliateRes->id,"affiliateCommission"=>$affiliateRes->commission_percentage,"cost"=>$cost,"camp_id"=>$_SESSION['camps'][$key]['camp_id']);
    						$save = $affFees->saveAffiliateFees($dataArray);
    					}
    				}
    				/*end*/

    				/*store card details into database*/
    				if(isset($_SESSION['camp_details'])){
    					$cards = new Cards();
    					$dates = date('Y-m-d H:i:s');   
	    				foreach($_SESSION['camp_details'] as $key=>$cdetails){
	    					$storeDetails = array('card_camp_id'=>$_SESSION['camps'][$key]['camp_id'], 'card_user_id'=> $user_id,'card_roster_id'=>$_SESSION['roster_id'][$key]['id'],'last_four_digit'=>substr($_SESSION['card_details']['card_no'],-4),'payment_type'=>$_SESSION['card_details']['payment_type'],'created_at'=>$dates);
	    					$getCardId = $cards->storeDetails($storeDetails);
	    				}
    				}
    				/*end*/


    				if(isset($_SESSION['product'])){
    					if(isset($_SESSION['user_id'])){
    						$user_id = $_SESSION['user_id'];
    					}else if(isset($_SESSION['cur_user_id'])){
    				      $user_id = $_SESSION['cur_user_id'];
    			     	}else{
    				      $user_id = '';
    			     	}
                        $webship_id = (!empty($_SESSION['webship_order_id'])) ? $_SESSION['webship_order_id'] : '';
    					foreach($_SESSION['product'] as $products){
    						if(isset($_SESSION['shipping_details'])){
    							$shipping_details = $_SESSION['shipping_details'];
    						}else{
    							$shipping_details = array();
    						}
    						$order_status = new Orders();
    						$od_id = $order_status->saveOrderDetails($_SESSION['billing_details'],$_SESSION['card_details'],$data,$user_id,$shipping_details,$product_amount);
    						$order_status->saveTransactions($data['trans_id']);
    						$order_product = new WebshipReference();
                            $order_product->saveWebshipOrderReference($webship_id,$od_id);

    						$order_product = new OrderItem();
    						$order_product->saveOrderProductDetails($products,$user_id,$od_id);
    					}
    					//email confirmation for webship order
    					if(isset($_SESSION['webShipOrder'])){
	    					if($_SESSION['webShipOrder']==1) {
	    						if(!empty($_SESSION['billing_details'])) {
	    							//$inputData = $_SESSION['billing_details'];
	    							//$name = $_SESSION['billing_details']['first_name'].' '.$_SESSION['billing_details']['last_name'];
	    							$name = $_SESSION['billing_details']['first_name'];
	    							$email = $_SESSION['billing_details']['email'];
	    							$inputData = array('name'=>$name, 'email'=>$email);
	    						} else {
	    							//$inputData = $_SESSION['shipping_details'];
	    							//$name = $_SESSION['shipping_details']['txtShippingFirstName'].' '.$_SESSION['billing_details']['txtShippingLastName'];
	    							$name = $_SESSION['shipping_details']['txtShippingFirstName'];
	    							$email = $_SESSION['billing_details']['email'];
	    							$inputData = array('name'=>$name, 'email'=>$email);
	    						}
	    						//print_r($inputData);exit;
	    						dispatch(new OrderConfirmationEmail($inputData));
	    						$_SESSION['webShipOrder']=0;
	    					}
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
    				    $interval->setLength(30);
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
    					//forgot session: unset specific key value from session (after register success)
    					Session::forget('affcode');
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
        }
        if ($usedWallet && $total_amount == 0) {
            if(isset($_SESSION['roster_id'])){
                $user_id = Auth::id();
                $wallet_card['payment_type'] = 'Wallet';
                $wallet_card['card_no'] = '0000000000000000';
                $walletResponse['trans_id'] = 'Wallet'; 
                $walletResponse['auth_code'] = 'Wallet'; 
                foreach($_SESSION['roster_id'] as $key=>$rosterId){
                    $shipping_details = array();
                    $od_id = $order_status->saveOrderDetails($_SESSION['billing_details'],$wallet_card,$walletResponse,$user_id,$shipping_details,$camp_amount);
                    $rosterPaymentStatus = $roster->updateRosterPaymentStatus($rosterId['id']);
                    $roster_val = $roster->getRosterDetails($rosterId['id']);
                    $order_product->saveOrderCampDetails($roster_val,$od_id);

                }
            }
            $data['response'] = 'success';
        }
		$data['title'] = "Payment";
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
			//get product weight using product id
			$productObj = new ProductAttributeSize();
			$productDetail = $productObj->getProductSize($request->input('pd_id'));
			$pd_weight ='';
			if(count($productDetail) >0) {
				$pd_weight = $productDetail[0]->pd_weight;
			} 
			$_SESSION['product'][] = array('pd_price'=> $amount,'pd_specialprice'=>$request->input('pd_specialprice'),'pd_id'=>$request->input('pd_id'),'pd_qty'=>$request->input('pd_qty'),'pro_size'=>$request->input('pro_size'),'pro_color'=>$request->input('pro_color'),'pd_name'=>$request->input('pd_name'), 'pd_weight'=>$pd_weight);
		}
		if(!empty($_SESSION['camp_cart_id'])) {
				$data['camp_details'] = $_SESSION['camp_details'];
				$cost1 = 0;
				foreach($data['camp_details'] as $details){
					$startdate = explode("-", $details->startdate); 
					$Esdate=date("Y-m-j", mktime(0, 0, 0, $startdate[1], $startdate[2], $startdate[0]));
					$today = date("Y-m-d");
					$EarlyBirdDate  =  date("Y-m-d", strtotime ( '-'.$details->EarlyBirdDays.' day' . $Esdate ));
					if($EarlyBirdDate > $today){
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
	
	public function removeProductCart($pid,$pd_price,$pd_color,$pd_size=''){
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
					if($EarlyBirdDate > $today){
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

	/*
	* This function is used to check the address on the user ups shipping 
	* @param array $data 
	* return result of object  
	*/

	public function verifyNewUSPSshippingAddress($request) {
		//Verify the address using USPS
		//If product is available then we should verify the address using for usps api
		$verify = new \USPS\AddressVerify(env('USPS_USERNSME','643ADVAN1042')); 
		$address = new \USPS\Address();  
		

		if(isset($_SESSION['product'])) {


			if($request->input('same_ship_adr')==1) {

				$myname= $request->input('first_name');
				$myaddress= $request->input('address');
				$mycity = $request->input('city');
				$mystate = $request->input('state');
				$myzip_code = $request->input('zip_code');

				$address->setFirmName($myname);
				$address->setApt('100');
				$address->setAddress($myaddress);
				$address->setCity($mycity);
				$address->setState($mystate);  
				$address->setZip5($myzip_code);   
				$address->setZip4('');

			}else {	  	
						$myname= $request->input('txtShippingFirstName');
						$myaddress= $request->input('txtShippingAddress1');
						$mycity = $request->input('txtShippingCity');
						$mystate = $request->input('txtShippingState');
						$myzip_code = $request->input('txtShippingPostalCode');
						$address->setFirmName($myname);
						$address->setApt('100');
						$address->setAddress($myaddress);
						$address->setCity($mycity);
						$address->setState($mystate);  
						$address->setZip5($myzip_code);   
						$address->setZip4('');
					
				}
					

			// Add the address object to the address verify class
			$verify->addAddress($address);

			// Perform the request and return result
			$verify->verify();
			$verify->getArrayResponse();

			// See if it was successful
			if ($verify->isSuccess()) {
			    return 1;
			} else { 
			     return 0;
			} 
		}
		else{
			
			 return 1;
		}   
		
	}  

	public function verifyUSPSshippingAddress($request) {
		//Verify the address using USPS
		//If product is available then we should verify the address using for usps api
		if(isset($_SESSION['product'])) {
			$addresses = array();
			if($request->input('same_ship_adr')==1) {
				$addresses =  array('Apartment'=> 'Apartment', 'Address'=> $request->input('address'), 'City'=>$request->input('city'), 'State'=>$request->input('state'), 'Zip'=> $request->input('zip_code'));
				$addIs = $request->input('address').' '.$request->input('city').' '.$request->input('state').' '.$request->input('zip_code');
			} else {
				$addresses =  array('Apartment'=> 'Apartment', 'Address'=> $request->input('txtShippingAddress1'), 'City'=>$request->input('txtShippingCity'), 'State'=>$request->input('txtShippingState'), 'Zip'=> $request->input('txtShippingPostalCode'));
				$addIs = $request->input('txtShippingAddress1').' '.$request->input('txtShippingCity').' '.$request->input('txtShippingState').' '.$request->input('txtShippingPostalCode');
			}
			//print_r($addresses);
			$usps = new USPSController();
			$isVerify = $usps->addressVerify($addresses);
			if(isset($isVerify->original['address'])) {
				$logObj = new Logger('USPS Address');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/usps.log')), Logger::INFO);
				$logObj->info("Address is:".$addIs);
				$logObj->info("Success: valid");
				return 1;
			} elseif(isset($isVerify->original['error'])) {
				$logObj = new Logger('USPS Address');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/usps.log')), Logger::INFO);
				$logObj->info("Address is:".$addIs);
				$logObj->info("Error:".$isVerify->original['error']);
				return 0;
			} else {
				// need to check
				return 2;
			}
		} else {
            return 1;
        }
	}

	/* 
		This function is used to post the order into webship API 
		
	*/
	private function postOrderToWebship($inputData, $request) {
		try {
			$json=array();
			$json['orderId'] = $this->generateRandomNumber();
			$json['orderDate'] = date("Y-m-d");
			$json['orderNumber'] = null;
			$json['fulfillmentStatus'] = "pending";
			$json['shippingService'] = "Standard";
			$json['shippingTotal'] = "".$inputData['total_pro_price']."";
			$json['weightUnit'] = null;
			$json['dimUnit'] = null;
			$json['dueByDate'] = null;
			$json['orderGroup'] ="Workstation 1";
			$json['sender'] = array("name"=>"MICHAEL HUMMEL", "company"=>"HUMMEL ENTERPRISES INC","address1"=>"19825 CYPRESS WAY","address2"=>"","city"=>"LYNNWOOD","state"=>"WA","zip"=>"98036", "country"=>"US","phone"=>"425-670-8877", "email"=>"info@advantagebasketball.com");
			if($request->input('same_ship_adr')==1) {
				$name = $_SESSION['billing_details']['first_name'].' '.$_SESSION['billing_details']['last_name'];
				$company = "New Tech Web";
				$address1 = $_SESSION['billing_details']['address'];
				$address2 = '';
				$city = $_SESSION['billing_details']['city'];
				$state = $_SESSION['billing_details']['state'];
				$zip = $_SESSION['billing_details']['zip_code'];
				$country = $_SESSION['billing_details']['country'];
				$phone = $_SESSION['billing_details']['home_phone'];
				$email = $_SESSION['billing_details']['email'];
				$json['receiver'] = array("name"=>$name, "company"=>$company,"address1"=>$address1,"address2"=>$address2,"city"=>$city,"state"=>$state,"zip"=>$zip, "country"=>$country,"phone"=>$phone, "email"=>$email);
			} else {
				$name = $_SESSION['shipping_details']['txtShippingFirstName'].' '.$_SESSION['shipping_details']['txtShippingLastName'];
				$company = "New Tech Web";
				$address1 = $_SESSION['shipping_details']['txtShippingAddress1'];
				$address2 = '';
				$city = $_SESSION['shipping_details']['txtShippingCity'];
				$state = $_SESSION['shipping_details']['txtShippingState'];
				$zip = $_SESSION['shipping_details']['txtShippingPostalCode'];
				$country = $_SESSION['shipping_details']['txtShippingCountry'];
				$phone = $_SESSION['shipping_details']['txtShippingPhone'];
				$email = $_SESSION['billing_details']['email'];
				$json['receiver'] = array("name"=>$name, "company"=>$company,"address1"=>$address1,"address2"=>$address2,"city"=>$city,"state"=>$state,"zip"=>$zip, "country"=>$country,"phone"=>$phone, "email"=>$email);
			}
			foreach($inputData['productVal'] as $key=>$product) {
				$json['items'] = [["productId"=>$product['pd_id'], "sku"=>null, "title"=>$product['pd_name'], "price"=>"".$product['pd_price']."","quantity"=>(int)$product['pd_qty'],"weight"=>"".$product['pd_weight']."", "imgUrl"=>null,"htsNumber"=>null, "countryOfOrigin"=>null,"lineId"=>null]];	
				$json['packages'] = [["weight"=>"".$product['pd_weight']."", "length"=>null, "width"=>null, "height"=>null,"insuranceAmount"=>null,"declaredValue"=>null]];	
			}
			
			$postFields = json_encode($json);
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://ixpship.rocksolidinternet.com/restapi/v1/customers/27600060/integrations/2834/orders/".$json['orderId'],
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_CUSTOMREQUEST => "PUT",
			  CURLOPT_POSTFIELDS => $postFields,
			  CURLOPT_HTTPHEADER => array(
			    "authorization: RSIS MLl0GtWVPAfVGP7SDF15BlpjkdSrZNPM",
			    "cache-control: no-cache",
			    "content-type: application/json"
			  ),
			));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
			  	echo "cURL Error #:" . $err;
			 	$logObj = new Logger('Inxpress webship Curl');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
				$logObj->info("cURL Error #:" . $err);
			} else {
                $_SESSION['webship_order_id'] = $json['orderId'];
			  	$logObj = new Logger('Inxpress webship response');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
				$logObj->info("response true");
			}
		} catch(Exception $e) {
			$logObj = new Logger('Inxpress webship API');
			$logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
			$logObj->info($e->getMessages());
		}
	}
	/*This function is used to generate the random number*/
	private function generateRandomNumber($length = 10) {
		$characters = '786123basketball';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	/*This function is used to shipping for InXpress API*/
	private function getActualShippingFee($inputData) {
		try {
			$json=array();
			$json['carrierCode'] = "usps";
			$json['serviceCode'] = "usps_priority";
			$json['packageTypeCode'] = "usps_custom_package";
			$json['sender'] = array("country"=>"US","zip"=>"98036");
			if(isset($inputData['same_ship_adr'])) {
			if($inputData['same_ship_adr']==1) {
					$city = $_SESSION['billing_details']['city'];
					$state = $_SESSION['billing_details']['state'];
					$zip = $_SESSION['billing_details']['zip_code'];
					$country = $_SESSION['billing_details']['country'];
					$phone = $_SESSION['billing_details']['home_phone'];
					$email = $_SESSION['billing_details']['email'];
					$json['receiver'] = array("city"=>$city, "country"=>$country,"zip"=>$zip, "email"=>$email);
				} else {
					$city = $_SESSION['shipping_details']['txtShippingCity'];
					$state = $_SESSION['shipping_details']['txtShippingState'];
					$zip = $_SESSION['shipping_details']['txtShippingPostalCode'];
					$country = $_SESSION['shipping_details']['txtShippingCountry'];
					$phone = $_SESSION['shipping_details']['txtShippingPhone'];
					$email = $_SESSION['billing_details']['email'];
					$json['receiver'] = array("city"=>$city, "country"=>$country,"zip"=>$zip, "email"=>$email);
				}
			}else{

				$city = $_SESSION['shipping_details']['txtShippingCity'];
					$state = $_SESSION['shipping_details']['txtShippingState'];
					$zip = $_SESSION['shipping_details']['txtShippingPostalCode'];
					$country = $_SESSION['shipping_details']['txtShippingCountry'];
					$phone = $_SESSION['shipping_details']['txtShippingPhone'];
					$email = $_SESSION['billing_details']['email'];
					$json['receiver'] = array("city"=>$city, "country"=>$country,"zip"=>$zip, "email"=>$email);  

			}


			$json['residential'] = true;
			$json['signatureOptionCode'] = null;
			$json['contentDescription'] = 'USPS DELIVERY';
			$json['weightUnit'] = 'lb';
			$json['dimUnit'] = 'in';
			$json['currency'] = 'USD';
			$json['customsCurrency'] = 'USD';
			foreach($_SESSION['product'] as $key=>$product) {
				$json['pieces'] = [["weight"=>"".$product['pd_weight']."", "length"=>null,"width"=>null, "height"=>null,"insuranceAmount"=>null,"declaredValue"=>null]];	
			}
			$json['billing'] = array("party"=>"sender");
			
			$postFields = json_encode($json);
			//print_r($postFields);exit;
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://ixpship.rocksolidinternet.com/restapi/v1/customers/27600060/quote",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $postFields,
			  CURLOPT_HTTPHEADER => array(
			    "authorization: RSIS MLl0GtWVPAfVGP7SDF15BlpjkdSrZNPM",
			    "cache-control: no-cache",
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);

			if ($err) {
			  	echo "cURL Error #:" . $err;
			 	$logObj = new Logger('Inxpress webship quote curl');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
				$logObj->info("cURL Error #:" . $err);
			} else {
			  	$logObj = new Logger('Inxpress webship quote response');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
				//$logObj->info("response" . $response);
			}
		} catch(Exception $e) {
			$logObj = new Logger('Inxpress webship quote API');
			$logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
			$logObj->info($e->getMessages());
		}
		return $response;
	}

}
