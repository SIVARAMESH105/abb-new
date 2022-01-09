<?php
namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Site\OrderOneOnOne;

#Authorize.net
require 'vendor/autoload.php'; 
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
//use AuthnetWebhook;
define("AUTHORIZENET_LOG_FILE","phplog");
defined('AUTHNET_SIGNATURE') || define('AUTHNET_SIGNATURE', 'A9CD442D6138E7A20882564C8DAC0BE1C2CE420ECF80A8F1D727A95D6E9964CEBAB47E46554050E3EB63910E6ED7F62C4D5E62B05D042F48F67D1591C5C8C9DA');
defined('AUTHNET_LOGIN') || define('AUTHNET_LOGIN', '7v2B6R9hF');
defined('AUTHNET_TRANSKEY') || define('AUTHNET_TRANSKEY', '4333entNN997uCuw');

class WebhookController extends Controller
{

	public function getRecurring()
	{
		$input = @file_get_contents("php://input");
		$file = fopen(public_path().'/pdf/recurring.txt',"w");
		fwrite($file,$input);
		fclose($file);
		$event_json = array();
		if($input != ''){
			$event_json = json_decode($input, true);
			if($event_json['payload']['entityName'] == 'subscription'){
				$subscriptionId =  $event_json['payload']['subscriptionId'];
				$OrderOneOnOne = new OrderOneOnOne();
				$OrderOneOnOne->updateSubcriptionDate($subscriptionId);
			}
		}
	}

}