<?php

namespace App\Http\Controllers\Site;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Usps;
//use Johnpaulmedina\Usps;     

class USPSController extends Controller
{
	
    public function addressVerify($inputData) {

       return response()->json(Usps::validate($inputData));
    }

    public function trackConfirm() {
    	$inputData = 'EJ123456780US';
		return response()->json(Usps::trackConfirm($inputData));
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