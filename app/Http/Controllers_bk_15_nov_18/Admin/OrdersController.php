<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Orders;
use URL;
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
		$data['orderItems'] = $ordersObj->getOrderItems($orderId);
		$data['registeredCamps'] = $ordersObj->getRegisteredCamp($orderId);
		//echo '<pre>'; print_r($data['registeredCamps']);die;
		$data['orderId'] = $orderId;
		$data['statusOptions'] = array('','New','Paid','Shipped','Completed','Canceled','Refunded','Future Camp');
		return view('Admin.viewOrder', $data);
	}
	
	public function modifyOrderStatus($orderId, $status)
	{
		if ($orderId != '' && $orderId > 0 && $status != '') {
			$orderObj = new Orders();
			$status = $orderObj->modifyOrderStatus($orderId, $status);
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