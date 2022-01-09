<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Orders;
use App\Models\Admin\ManageStates;
use URL;
use App\Jobs\SendEmailToCustomer;
use App\Http\Requests\OrderRequest as StoreRequest;

class OrdersController extends Controller
{
    public function orderList()
    {
		$ordersObj = new Orders();
		$data['orders'] = $ordersObj->getOrdersList();
        return view('Admin.orders', $data);
    }
	
	public function searchOrdersWithLastname()
	{
		$ordersObj = new Orders();
		$data['orders'] = $ordersObj->getOrdersSearchResult($_POST['parentLastname'], $_POST['childLastname']);
		$data['parentLastname'] = $_POST['parentLastname'];
		$data['childLastname'] = $_POST['childLastname'];
		return view('Admin.orders', $data);
	}
	
	public function viewOrder($orderId)
	{
		$ordersObj = new Orders();
		$data['orderDetails'] = $ordersObj->getOrderDetails($orderId);
		//print_r($data['orderDetails']);exit;
		$data['orderItems'] = $ordersObj->getOrderItems($orderId);
		$data['registeredCamps'] = $ordersObj->getRegisteredCamp($orderId);
		//echo '<pre>'; print_r($data['registeredCamps']);die;
		$data['orderId'] = $orderId;
		$data['statusOptions'] = array('','New','Paid','Shipped','Completed','Canceled','Refunded','Future Camp');
		return view('Admin.viewOrder', $data);
	}
	
	/*public function modifyOrderStatus($orderId, $status)
	{
		if ($orderId != '' && $orderId > 0 && $status != '') {
			$orderObj = new Orders();
			$status = $orderObj->modifyOrderStatus($orderId, $status);
		}
		return \Redirect::to('admin/orders');
	}*/

	public function modifyOrderStatus(Request $request)
	{
		$orderId = $request['orderId'];	
		$status = $request['orderStatus'];
		if ($orderId != '' && $orderId > 0 && $status != '') {
			$this->orderObj = new Orders();
			$updateStatus = $this->orderObj->modifyOrderStatus($request->all());
			if(trim($status)==='Shipped') {
				$data['orderDetails'] = $this->orderObj->getOrderDetails($orderId);
				if(count($data['orderDetails']) > 0) {
					$statesObj = new ManageStates();
					$stateCode = $statesObj->getStateCodeByName($data['orderDetails'][0]->od_shipping_state);
					$inputData = array("shipping_first_name"=>$data['orderDetails'][0]->od_shipping_first_name,"shipping_last_name"=>$data['orderDetails'][0]->od_shipping_last_name,"shipping_address"=>$data['orderDetails'][0]->od_shipping_address1,"shipping_address2"=>$data['orderDetails'][0]->od_shipping_address2,"shipping_phone"=>$data['orderDetails'][0]->od_shipping_phone,"shipping_work_phone"=>$data['orderDetails'][0]->od_shipping_work_phone,"shipping_city"=>$data['orderDetails'][0]->od_shipping_city,"shipping_state"=>$data['orderDetails'][0]->od_shipping_state,"shipping_postal_code"=>$data['orderDetails'][0]->od_shipping_postal_code,"shipping_country"=>$data['orderDetails'][0]->od_shipping_country,"shipping_email"=>$data['orderDetails'][0]->od_shipping_email, "tracking_url"=>$data['orderDetails'][0]->shipping_tracking_URL, "tracking_number"=>$data['orderDetails'][0]->shipping_tracking_number, 'stateCode'=>$stateCode);
					//Mail has send to customer
					dispatch(new SendEmailToCustomer($inputData));
				}
				$request->session()->flash('status', "Order status updated successfully!");
			}
		}
		return \Redirect::to('admin/orders');
	}
	
	public function createOrder()
	{
		return view('Admin.createOrder');
	}
	
	public function store(StoreRequest $request)
	{
		$orderObj = new Orders();
		$status = $orderObj->storeOrder($request->all());
		\Alert::success('Order inserted successfully')->flash();
		return \Redirect::to('admin/orders');
	}
}