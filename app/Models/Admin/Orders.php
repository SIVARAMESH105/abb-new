<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Admin\ManageStates;
use DB;
use Carbon\Carbon;
use Hash;

class Orders extends Model {

    /*
	|--------------------------------------------------------------------------
	| GLOBAL VARIABLES
	|--------------------------------------------------------------------------
	*/

	protected $table = 'tbl_order';
	
	public function getOrdersList()
	{
		$orders = DB::table('tbl_order')
					->select('od_id', 'od_payment_first_name', 'od_payment_last_name', 'od_date', 'od_status')
					->where([
						['od_status', '<>', 'NEW'],
						['od_status', '<>', ''],
					])
					->orWhere('od_payment_type', '<>', '')
					->orderBy('od_date', 'desc')
					->get();
		return $orders;
	}
	
	public function getOrdersSearchResult($parentLastname, $childLastname)
	{
		$searchOrdersQuery = DB::table('tbl_order')
						->select('od_id', 'od_payment_first_name', 'od_payment_last_name', 'od_date', 'od_status');
		$searchOrdersQuery->where(function ($query) {
			$query->where(function ($query) {
					$query->where('od_status', '<>', 'NEW')
						->where('od_status', '<>', '');
			})->orWhere(function ($query) {
				$query->where('od_payment_type', '<>', '');
			});
		});						
		/* $rosters = DB::table('tbl_order_camp')
				->join('tbl_roster', 'tbl_order_camp.roster_id', '=', 'tbl_roster.id')
				->select("tbl_order_camp.od_id")
				->where("tbl_roster.fname", "like", "%$childLastname%")
				->get()
				->toArray(); */
		$rosters = DB::table('tbl_order_camp')
				->join('tbl_roster', 'tbl_order_camp.roster_id', '=', 'tbl_roster.id')
				->join('users', 'users.id', '=', 'tbl_roster.user_id')
				->select("tbl_order_camp.od_id")
				->where("users.name", "like", "%$childLastname%")
				->where("users.fname", "like", "%$parentLastname%")
				->get()
				->toArray();
		$rosterIds = $this->getRosterIds($rosters);		
		if($parentLastname != '' && $childLastname != '')
		{
			$searchOrdersQuery->where("od_payment_last_name", "like", "%$parentLastname%");
			$searchOrdersQuery->whereIn("od_id", $rosterIds);
		}
		else if($parentLastname != '')
		{
			$searchOrdersQuery->where("od_payment_last_name", "like", "%$parentLastname%");
		}
		else if($childLastname != '')
		{
			$searchOrdersQuery->whereIn("od_id", $rosterIds);
		}
		$searchOrdersQuery->orderBy("od_date", "desc");
		$searchOrders = $searchOrdersQuery->get();
		return $searchOrders;
	}
	
	public function getRosterIds($result)
	{
		$od_ids = array();
		foreach($result as $roster)
		{
			array_push($od_ids, $roster->od_id);
		}
		return $od_ids;
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
		return $orderItems;
	}
	
	public function getRegisteredCamp($orderId)
	{
		$stateObj = new ManageStates();
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
			/* $getDetailsFromRoster = DB::table('tbl_roster')
									->where('id', '=', $registeredCamp->roster_id)
									->where('camp_id', '=', $registeredCamp->camp_id)
									->get(); */
			$getDetailsFromRoster = DB::table('tbl_roster')
									->join('users', 'users.id', '=', 'tbl_roster.user_id')
									->where('tbl_roster.id', '=', $registeredCamp->roster_id)
									->where('tbl_roster.camp_id', '=', $registeredCamp->camp_id)
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
	
	public function modifyOrderStatus($inputData)
	{
		$orderId = $inputData['orderId'];
		$status = $inputData['orderStatus'];
		$trackURL =  isset($inputData['trackURL'])?$inputData['trackURL']:'';
		$trackingnumber =  isset($inputData['trackingnumber'])?$inputData['trackingnumber']:'';
		$updateStatus = DB::table('tbl_order')->where('od_id', $orderId)->update(['od_status' => $status, 'od_last_update' => Carbon::now(), 'shipping_tracking_URL' => $trackURL, 'shipping_tracking_number'=>$trackingnumber ]);
	}
	
	public function storeOrder($request)
	{
		if(!isset($request['gender'])) {
			$request['gender'] = '';
		}
		if(!isset($request['basketball_exp'])) {
			$request['basketball_exp'] = '';
		}
		if(!isset($request['basketball_skill'])) {
			$request['basketball_skill'] = '';
		}
		if(!isset($request['payment_type'])) {
			$request['payment_type'] = '';
		}
		if($_POST['payment_amount']){
			$cost = $_POST['payment_amount'];
		}else{
			$cost = $_POST['cost'];
		}
        $password = $request['user_password'];
        $hashedPassword = Hash::make($password);
		$dateTime = date("Y-m-d H:i:s");
        $user_type = '3';
		$userId = DB::table('users')->insertGetId(['name' => $request['name'], 'email' => $request['user_email'], 'password' => $hashedPassword, 'fname' => $request['fname'], 'gender' => $request['gender'], 'dob' => $request['dob'], 'grade' => $request['grade'], 'parent_firstname' => $request['parent_firstname'], 'parent_lastname' => $request['parent_lastname'], 'address' => $request['address'], 'city' => $request['city'], 'state' => $request['state'], 'zip' => $request['zip'], 'country' => $request['country'], 'home_phone' => $request['home_phone'], 'work_phone' => $request['work_phone'], 'parent_email' => $request['parent_email'], 'basketball_exp' => $request['basketball_exp'], 'basketball_exp_desc' => $request['basketball_exp_desc'], 'basketball_skill' => $request['basketball_skill'], 'user_type' => $user_type, 'created_at' => $dateTime, 'updated_at' => $dateTime]);

        $rosterId = DB::table('tbl_roster')->insertGetId(
		['tshirtsize' => $request['tshirtsize'], 'user_id' => $userId, 'camp_id' => $request['new_camp_id'], 'amount_paid' => $cost, 'hear' => $request['Txthear'], 'status' => 'Paid', 'last_update' => $dateTime]
		);
		$orderId = DB::table('tbl_order')->insertGetId(
		['od_date' => $dateTime, 'od_last_update' => $dateTime, 'od_status' => 'Paid', 'user_id' => $userId, 'od_shipping_first_name' => $request['parent_firstname'], 'od_shipping_last_name' => $request['parent_lastname'], 'od_shipping_address1' => $request['address'], 'od_shipping_address2' => '', 'od_shipping_phone' => $request['home_phone'], 'od_shipping_state' => $request['state'], 'od_shipping_city' => $request['city'], 'od_shipping_postal_code' => $request['zip'], 'od_shipping_country' => $request['country'], 'od_shipping_email' => $request['parent_email'], 'od_shipping_cost' => '0.00', 'od_wa_cost' => '0.00', 'od_payment_first_name' => $request['parent_firstname'], 'od_payment_last_name' => $request['parent_lastname'], 'od_payment_address1' => $request['address'], 'od_payment_address2' => '', 'od_payment_phone' => $request['home_phone'], 'od_payment_state' => $request['state'], 'od_payment_city' => $request['city'], 'od_payment_postal_code' => $request['zip'], 'od_payment_country' => $request['country'], 'od_payment_type' => 'Manual Registration', 'od_payment_cctype' => $request['payment_type'], 'od_payment_ccnumber' => $request['credit_card_number'], 'od_payment_transaction_id' => $request['transaction_id']]
		);
		$orderCamp = DB::table('tbl_order_camp')->insert(['od_id' => $orderId, 'camp_id' => $request['new_camp_id'], 'roster_id' => $rosterId, 'user_id' => $userId, 'last_update' => $dateTime]);
	}
}
?>