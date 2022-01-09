<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Models\Site\Cards;
use App\Models\Site\Camps;
use App\Models\Site\Roster;
use App\Models\Site\Users;
use App\Http\Controllers\Controller;
use App\Jobs\CreditSuccessEmail;
use Carbon\Carbon;
use DateTime;
use Session;
use Auth;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
#Authorize.net
require 'vendor/autoload.php';
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
define("AUTHORIZENET_LOG_FILE", "phplog");

class RefundController extends Controller {
	
	public function __construct() {
		$this->cards = new Cards();
	}
	
	public function validCard(Request $request) {
		$inputData = array('campId' =>$request['camp-id'], 'rosterId'=>$request['roster-id']);
		$cardInfo = $this->cards->getDetails($inputData);
		$postLast4digit = substr($request['card_no'],-4);
		$postPaymentType = $request['payment_type'];
		$regLast4digit = $cardInfo->last_four_digit;
		$regPaymentType = $cardInfo->payment_type;
		/*we have compared the register card infor with refund card information details*/
		if(($regLast4digit == $postLast4digit) && ($regPaymentType == $postPaymentType)) {
			$refTransId =0;
			$amount = 95;
			$year =$request['year'];
			$month =$request['month'];
			$cardDetails = array('cardNo'=> $request['card_no'], 'year'=>$year, 'month'=>$month, 'last4digit'=>$postLast4digit);
			$result = $this->refundTransaction($refTransId,$amount, $cardDetails);
			$response = $result->getMessages();
			$resultCode = $response->getresultCode();
			$resultMsg = $response->getMessage()[0]->getText();
			if($resultCode=='Ok' && $resultMsg=='Successful.') {
				$roster = new Roster();
				$userObj = new Users();
				$campObj = new Camps();
				$getRoster = $roster->getRosterDetails($request['roster-id']);
				if(count($getRoster) > 0) {
					$getUser = $userObj->getUser($getRoster[0]->user_id);
					$getCamp = $campObj->getCamp($getRoster[0]->camp_id);
					$campname = (count($getCamp) > 0)?$getCamp[0]->camp_focus:'';
					$location = (count($getCamp) > 0)?$getCamp[0]->Location:'';
					$userName = $getUser->name;
					$userEmail = $getUser->email;
					/* update the cancel status*/
					$update = $roster->updateCancelCamp($request['roster-id']);
					if($update) {
						$date = date('m-d-Y H:i:s');//US format
						$inputData = array('campname'=>$campname,'location'=>$location, 'username'=>$userName, 'useremail'=>$userEmail, 'canceldate'=>$date, 'amount'=>$amount);
						//mail to admin and customer
						dispatch(new CreditSuccessEmail($inputData));
					}
				}
				$crAmount = number_format($amount,2,'.','');
				return redirect('user/regCamps')->with(array('status'=>"Your refund has been processed.  You should see a credit from Advantage Basketball Camps appearing on your next credit card statement for the amount of $".$crAmount.".  Thank you."));
			} else {
				return redirect('user/regCamps')->with(array('status-error'=>"Transaction Failed"));
			}
		} else {
			return redirect('user/regCamps')->with(array('status-error'=>"Please use the same credit card you used when registering for this camp. The last four digits are:".$regLast4digit.""));
		}
	}

	function refundTransaction($refTransId, $amount,$cardDetails)
	{
		/* Create a merchantAuthenticationType object with authentication details
		   retrieved from the constants file */
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		$merchantAuthentication->setName(env('AUTHORIZE_LOGIN_ID'));   
		$merchantAuthentication->setTransactionKey(env('AUTHORIZE_TRANS_KEY'));
		
		// Set the transaction's refId
		$refId = 'ref' . time();

		// Create the payment data for a credit card
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($cardDetails['cardNo']);
		//$creditCard->setExpirationDate("XXXX");
		$creditCard->setExpirationDate($cardDetails['year'].'-'.$cardDetails['month']);
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($creditCard);
		//create a transaction
		$transactionRequest = new AnetAPI\TransactionRequestType();
		$transactionRequest->setTransactionType( "refundTransaction"); 
		$transactionRequest->setAmount($amount);
		$transactionRequest->setPayment($paymentOne);
		$transactionRequest->setRefTransId($refTransId);
	 

		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($merchantAuthentication);
		$request->setRefId($refId);
		$request->setTransactionRequest( $transactionRequest);
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

		if ($response != null)
		{
		  if($response->getMessages()->getResultCode() == "Ok")
		  {
			$tresponse = $response->getTransactionResponse();
			
			if ($tresponse != null && $tresponse->getMessages() != null)   
			{
				echo " Transaction Response code : " . $tresponse->getResponseCode() . "\n";
				echo "Refund SUCCESS: " . $tresponse->getTransId() . "\n";
				echo " Code : " . $tresponse->getMessages()[0]->getCode() . "\n"; 
				echo " Description : " . $tresponse->getMessages()[0]->getDescription() . "\n";
				$logObj = new Logger('Refund Transaction');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/transaction.log')), Logger::INFO);
				$logObj->info(" Transaction Response code : " . $tresponse->getResponseCode() );          
				$logObj->info("Refund SUCCESS: " . $tresponse->getTransId() );          
				$logObj->info(" Code : " . $tresponse->getMessages()[0]->getCode() );
				$logObj->info(" Description : " . $tresponse->getMessages()[0]->getDescription() );
			}
			else
			{
			  echo "Transaction Failed \n";
			  if($tresponse->getErrors() != null)
			  {
					echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
					echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";  
					$logObj = new Logger('Refund Transaction');
					$logObj->pushHandler(new StreamHandler(storage_path('logs/transaction.log')), Logger::INFO);
					$logObj->info("Transaction Id" .$refTransId);          
					$logObj->info(" Error code  : " . $tresponse->getErrors()[0]->getErrorCode() );          
					$logObj->info(" Error message : " . $tresponse->getErrors()[0]->getErrorText() );          
			  }
			}
		  }
		  else
		  {
			echo "Transaction Failed \n";
			$tresponse = $response->getTransactionResponse();
			if($tresponse != null && $tresponse->getErrors() != null)
			{
			  	echo " Error code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
			  	echo " Error message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
			  	$logObj = new Logger('Refund Transaction');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/transaction.log')), Logger::INFO);
				$logObj->info("Transaction Id" .$refTransId);          
				$logObj->info(" Error code  : " . $tresponse->getErrors()[0]->getErrorCode() );          
				$logObj->info(" Error message : " . $tresponse->getErrors()[0]->getErrorText() );                         
			}
			else
			{
			  	echo " Error code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
			  	echo " Error message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
			 	$logObj = new Logger('Refund Transaction');
				$logObj->pushHandler(new StreamHandler(storage_path('logs/transaction.log')), Logger::INFO);
				$logObj->info("Transaction Id" .$refTransId);
				$logObj->info(" Error code  : " . $response->getMessages()->getMessage()[0]->getCode());
				$logObj->info(" Error message : " . $response->getMessages()->getMessage()[0]->getText() );
			}
		  }      
		}
		else
		{
		  	echo  "No response returned \n";
		  	$logObj = new Logger('Refund Transaction');
			$logObj->pushHandler(new StreamHandler(storage_path('logs/transaction.log')), Logger::INFO);
			$logObj->info("Transaction Id" .$refTransId);
			$logObj->info("No response returned");

		}
		
		return $response;
	  }
}
?>
