<?php

namespace App\Http\Controllers\Site;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use App;
//use Johnpaulmedina\Usps;     

class MyUSPSController extends Controller
{
	
    public function addressVerify() {  

    
    	$verify = new \USPS\AddressVerify(env('USPS_USERNSME','643ADVAN1042'));

		// During test mode this seems not to always work as expected
		//$verify->setTestMode(true);

			$address = new \USPS\Address();  
			$address->setFirmName('mike');
			$address->setApt('100');
			$address->setAddress('12712 SE 223RD DR');
			$address->setCity('KENT');
			$address->setState('WA');  
			$address->setZip5(98031);
			$address->setZip4('');

			// Add the address object to the address verify class
			$verify->addAddress($address);

			// Perform the request and return result
			print_r($verify->verify());
			print_r($verify->getArrayResponse());

			var_dump($verify->isError());

			// See if it was successful
			if ($verify->isSuccess()) {
			    echo 'Done';
			} else {
			    echo 'Error: '.$verify->getErrorMessage();
			}
    }

    


    /*public function trackConfirmRevision1() {
        return response()->json(
            Usps::trackConfirm( 
                Request::input('id'),
                'Acme, Inc'
            )
        );
    }


    public function createLabel() {
		// Initiate and set the username provided from usps
		$label = new \Usps\PriorityLabel(env('USPS_USERNSME'));

		// During test mode this seems not to always work as expected
		$label->setTestMode(true);

		$label->setFromAddress('Mike', 'Mike', '', '12712 SE 223RD DR', 'KENT', 'WA', '98031', '', '', '7894561238');
		$label->setToAddress('Mike', 'Mike', '', '12712 SE 223RD DR', 'KENT', 'WA', '98031', '', '', '7894561238');
		$label->setWeightOunces(1);
		$label->setField(36, 'LabelDate', '02/25/2019');

		//$label->setField(32, 'SeparateReceiptPage', 'true');

		// Perform the request and return result
		$label->createLabel();

		//print_r($label->getArrayResponse());
		//print_r($label->getPostData());
		//var_dump($label->isError());

		// See if it was successful
		if ($label->isSuccess()) {
			//echo 'Done';
			//echo "\n Confirmation:" . $label->getConfirmationNumber();

			$label = $label->getLabelContents();

			if ($label) {
				$contents = base64_decode($label);
				header('Content-type: application/pdf');
				header('Content-Disposition: inline; filename="label.pdf"');
				header('Content-Transfer-Encoding: binary');
				header('Content-Length: ' . strlen($contents));
				echo $contents;
				exit;
			}
		} else {
			echo 'Error: ' . $label->getErrorMessage();
		}
    }*/
}