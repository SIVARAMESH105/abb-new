<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

use App\Models\Site\Cron;
use DB;

class CronController extends Controller
{    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	 
	public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Update the Webship tracking number
     *
     * @return homepage 
     */
    public function updateWebshipTrackingNumber(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://ixpship.rocksolidinternet.com/restapi/v1/customers/27600060/shipments",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_SSL_VERIFYPEER => false,
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
            $logObj = new Logger('Inxpress webship Cron Curl');
            $logObj->pushHandler(new StreamHandler(storage_path('logs/webship.log')), Logger::INFO);
            $logObj->info("cURL Error #:" . $err);
        } else {
            $response = json_decode($response, TRUE);
            $cronObj = new Cron();
            if (count($response['shipments']) > 0) {
                foreach($response['shipments'] as $shipment) {
                    $checkStatus = $cronObj->checkExistingReference($shipment['shipmentReference']);
                    if($checkStatus) {
                        $cronObj->updateTrackingNumber($shipment['shipmentReference'], $shipment['trackingNumber']);
                    }
                }
            }
        }
    }
}