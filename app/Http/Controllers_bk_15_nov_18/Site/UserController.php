<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Users;
use App\Models\Site\CountrySite;
use App\Models\Site\Groups;
use App\Models\Site\GroupInvites;
use App\Models\Site\Store;
use App\Models\Site\OrderItem;
use App\Models\Site\Orders;
use App\Models\Site\Camps;
use App\Jobs\SendGroupInvitationEmail;
use App\Jobs\ResendGroupInvitationEmail;
use Carbon\Carbon;
use Hash;
use DataTables;
use DB;
use DateTime;
session_start();

class UserController extends Controller
{
    public function __construct(){
		DB::enableQueryLog();
		if(!Auth::check()){//echo 'd';die;
    		return redirect("/login");
    	}
    }
	
	public function editProfile(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$data['UserVal'] = $userObj->getUser($_SESSION['cur_user_id']);
		$countryObj = new CountrySite();
		$data['country_details'] = $countryObj->countryList();
		return view('Site/edit_profile', $data);
    }
	
	public function changeUserProfile(Request $request){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$UserExVal = $userObj->getUser($request['id']);
		if($UserExVal->name != $request['user_name'] && $UserExVal->email != $request['user_email']){
			$UserVal = $userObj->getUserInfo($request['user_email']);
			if(empty($UserVal)){
				$userObj->updateUserEmailWithAll($request->all());
				$userObj->updateUserNameWithAll($request->all());
				return redirect ('user/editProfile')->with(array('status'=>'Email updated successfully!'));
			}else{
				return redirect ('user/editProfile')->with(array('error'=>'Email already exists please enter different!'));
			}
		}else if($UserExVal->name != $request['user_name']){
			$userObj->updateUserNameWithAll($request->all());
			return redirect ('user/editProfile')->with(array('status'=>'Username updated successfully!'));
		}
		else if($UserExVal->email != $request['user_email']){ 
			$UserVal = $userObj->getUserInfo($request['user_email']);
			if(empty($UserVal)){
				$userObj->updateUserEmailWithAll($request->all());
				return redirect ('user/editProfile')->with(array('status'=>'Email updated successfully!'));
			}else{
				return redirect ('user/editProfile')->with(array('error'=>'Email already exists please enter different!'));
			}
		}else{
			$userObj->updateProfile($request->all());
			return redirect ('user/editProfile')->with(array('status'=>'Profile updated successfully!'));
		}
	}
	
	public function changeUserPwd(Request $request){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$UserExVal = $userObj->getUser($request['id']);
		if(Hash::check($request['old_password'], $UserExVal->password)){
			$userObj->updateUserPwd($request->all());
			return redirect ('user/editProfile')->with(array('status'=>'Password updated successfully!'));
		}else{
			return redirect ('user/editProfile')->with(array('error'=>'Old password does not match!'));
		}
	}
	
	public function regCamps(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		return view('Site/user_camp_history');
	}
	
	public function getlist(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$campDetails = $userObj->getCampDetails();
		$length = count($campDetails);
		for ($i = 0; $i < $length; $i++) { 
			$campDetails[$i]->cost = '$'.$campDetails[$i]->cost;
			$startDateTime = $campDetails[$i]->starttime;
			$campDetails[$i]->starttime = date('h:i A', strtotime($startDateTime));
			$endDateTime = $campDetails[$i]->endtime;
			$campDetails[$i]->endtime = date('h:i A', strtotime($endDateTime));
			$createDate = new DateTime($campDetails[$i]->last_update);
			$campDetails[$i]->last_update = $createDate->format('Y-m-d');
		}
		//echo '<pre>'; print_r($campDetails);die;
		return DataTables::of($campDetails)->make(true);
	}
	
	public function userGroups(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		return view('Site/user_groups');
	}
	
	public function getGroupslist(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$groupDetails = $userObj->getGroupDetails();
		$length = count($groupDetails);
		for ($i = 0; $i < $length; $i++) {
			$groupDetails[$i]->counts = DB::table('tbl_group_invites')->where('group_id', '=', $groupDetails[$i]->group_id)->where('user_id','=',$_SESSION['cur_user_id'])->count();
		}
		return DataTables::of($groupDetails)
            ->addColumn('action', function ($group) {
                return '<a href="'.url('user/editGroup/'.$group->group_id).'" class="btn btn-primary"><i class="table-icon icon-edit" ></i> Edit</a>';
            })->make(true);
	}
	
	public function editUserGroup($g_id){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$groupObj = new Groups();
		$data['GroupVal'] = $groupObj->getGroupVal($g_id);
		$campObj = new Camps();
		$data['campName'] = $campObj->getCampName($data['GroupVal']->camp_id);
		$data['groupInvityDetails'] = $groupObj->getGroupDetails($g_id);
		$data['campId'] = $data['GroupVal']->camp_id;
		return view('Site/edit_user_group', $data);
    }
	
	public function addGroup(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$data['campDetails'] = $userObj->getCampDetails();
		return view('Site/add_user_group', $data);
	}
	
	public function inviteUserGroup(Request $request){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$campsObj = new Camps();
		$campDetails = $campsObj->getRegisterdCamp($request['group_camp']); 
		
		$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$group_code = "";
		for ($i = 0; $i < 8; $i++) {
			$group_code .= $chars[mt_rand(0, strlen($chars)-1)];
		}
		
		$group = new Groups();
		$group_id = $group->saveGroup($_SESSION['cur_user_id'],$request->input('group_camp'),$group_code);
		
		$i=0;
		foreach($request->input('username') as $invites){
			$firstname = $request->input('username')[$i];
			$lastname = $request->input('lastname')[$i];
			$user_email = $request->input('grpemail')[$i];
			$groupinvites = new GroupInvites();
			$invite_id = $groupinvites->saveGroupInvites($request->input('group_camp'),$user_email,$firstname,$lastname,$_SESSION['cur_user_id'],$group_id);
			$i++;
		}
		
		$user = new Users();
		$reg_username = $user->getUser($_SESSION['cur_user_id']);
		
		$job = (new SendGroupInvitationEmail($request->all(),$reg_username->name,$campDetails,$group_code))
				->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
		return redirect ('user/userGroups')->with(array('status'=>'Successfully Invited'));
	}
	
	public function resendInvite(){ 
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$campObj = new Camps();
		$campDetails = $campObj->getSingleCampDetails($_POST['campId']);
		//echo '<pre>'; print_r($campDetails);die;
		$campDetails->state_name = $campObj->getStateName($campDetails->State);
		$job = (new ResendGroupInvitationEmail($_POST,$campDetails))
					->delay(Carbon::now()->addSeconds(5));
		dispatch($job);
	}
	
	public function deleteGroupInvite($g_id,$id,$camp_id){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$groupinvites = new GroupInvites();
		$groupinvites->deleteGroupInvite($g_id,$id,$camp_id);
		return redirect ('user/editGroup/'.$g_id)->with(array('status'=>'Deleted successfully.'));
	}
	
	public function editInvite(){ 
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$groupinvites = new GroupInvites();
		$invite_val[] = $groupinvites->getGroupInvite($_POST['id']);
		return $invite_val;
	}
	
	public function updateUserGroup(Request $request){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$groupinvites = new GroupInvites();
		$groupinvites->updateUserGroupInvite($request->all());
		return redirect ('user/editGroup/'.$request->input('group_id'))->with(array('status'=>'Updated successfully.'));
	}
	
	public function purchaseProducts(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		return view('Site/user_purchase_products');
	}
	
	public function getPurchaseProductslist(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$order_product_details = $userObj->getOrderProductDetails($_SESSION['cur_user_id']);
		$length = count($order_product_details);
		for ($i = 0; $i < $length; $i++) { 
			$order_product_details[$i]->od_wa_cost = '$'.$order_product_details[$i]->od_qty*$order_product_details[$i]->pd_price;
		}
		return DataTables::of($order_product_details)
            ->addColumn('action', function ($product_details) {
                return '<a href="'.url('viewOrder/'.$product_details->od_id).'" class="btn btn-primary"><i class="table-icon icon-edit" ></i>View Order</a>';
		})->make(true);
	}
	
	public function viewOrder($orderId){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$ordersObj = new Orders();
		$data['orderDetails'] = $ordersObj->getOrderDetails($orderId);
		$data['orderItems'] = $ordersObj->getOrderItems($orderId);
		$data['registeredCamps'] = $ordersObj->getRegisteredCamp($orderId);
		$data['orderId'] = $orderId;
		$data['statusOptions'] = array('','New','Paid','Shipped','Completed','Canceled','Refunded','Future Camp');
		return view('Site/viewUserOrder', $data);
	}

    
}
