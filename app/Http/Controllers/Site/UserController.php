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
use App\Models\Site\Roster;
use App\Models\Site\Wallet;
use App\Models\Site\WebshipReference;
use App\Jobs\SendGroupInvitationEmail;
use App\Jobs\ResendGroupInvitationEmail;
use App\Jobs\CancelCampRegistraionEmail;
use App\Http\Requests\EditCampRequest;
use Carbon\Carbon;
use Hash;
use DataTables;
use DB;
use DateTime;
use Redirect;
session_start();

class UserController extends Controller
{
    public function __construct(){
		DB::enableQueryLog();
        $this->rosterObj = new Roster();
        $this->userObj = new Users();
        $this->campObj = new Camps();
        $this->walletObj = new Wallet();
        $this->webshipObj = new WebshipReference();
    }
	
	public function editProfile(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$data['UserVal'] = $userObj->getUser($_SESSION['cur_user_id']);
		$countryObj = new CountrySite();
		$data['country_details'] = $countryObj->countryList();
		$data['title'] = "Profile"; 
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
    	$data['title'] = "Registered Camps"; 
		return view('Site/user_camp_history',$data);
	}
	
	public function getlist(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$campDetails = $userObj->getCampDetails();
		$length = count($campDetails);
		for ($i = 0; $i < $length; $i++) { 
			$campDetails[$i]->amt = $campDetails[$i]->amount_paid;
			$campDetails[$i]->cost = '$'.number_format($campDetails[$i]->amount_paid,2,'.','');
			$startDateTime = $campDetails[$i]->starttime;
			$campDetails[$i]->starttime = date('h:i A', strtotime($startDateTime));
			$endDateTime = $campDetails[$i]->endtime;
			$campDetails[$i]->endtime = date('h:i A', strtotime($endDateTime));
			$createDate = new DateTime($campDetails[$i]->last_update);
			$campDetails[$i]->last_update = $createDate->format('Y-m-d');
		}
		return DataTables::of($campDetails)->addColumn('action', function ($campDetails) {
				if($campDetails->cancelcamp==1) {
					return '<span style="font-size:12px;color:#ff6666">Cancelled</span>';
				} else {
					//return '<a id="cancelcamp" href="'.url('user/cancelCamp/'.$campDetails->id).'">Cancel</a>';
					$discount ='';
					if($campDetails->group_discount=='yes') {
						$discount = 'yes';
					}
					$cost = number_format($campDetails->amt,2,'.','');
					return '<a id="cancelcamp" data-attr="'.$campDetails->c_id.'" data-rosterId="'.$campDetails->id.'" data-discount="'.$discount.'" data-amt="'.$cost.'">Cancel</a> | <a href="'.url('user/getCampRegistration/'.base64_encode($campDetails->id)).'">Edit</a>';
				}
            })->make(true);
	}

	public function userGroups(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
    	$data['title'] = "Groups";
		return view('Site/user_groups',$data);
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
                return '<a href="'.url('user/editGroup/'.$group->group_id).'"><i class="table-icon fa fa-edit"></i></a>';
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
		$data['title'] = "Groups"; 
		return view('Site/edit_user_group', $data);
    }
	
	public function addGroup(){
		if(!Auth::check()){
    		return redirect("/login");
    	}
		$userObj = new Users();
		$data['campDetails'] = $userObj->getCampDetails();
		$data['title'] = "Groups";
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
    	$data['title'] = "Purchase Products"; 
		return view('Site/user_purchase_products',$data);
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

	/**
		** This function is used to cancel the camp registeration 
		** Mail send to admin and customer
		** @param int $rosterId
		** return redirect to camp registration list
	**/
	public function cancelCamp($rosterId) {
		$roster = new Roster();
		$userObj = new Users();
		$campObj = new Camps();
		$getRoster = $roster->getRosterDetails($rosterId);
		if(count($getRoster) > 0) {
			$getUser = $userObj->getUser($getRoster[0]->user_id);
			$getCamp = $campObj->getCamp($getRoster[0]->camp_id);
			$campname = (count($getCamp) > 0)?$getCamp[0]->camp_focus:'';
			$location = (count($getCamp) > 0)?$getCamp[0]->Location:'';
			$userName = $getUser->name;
			$userEmail = $getUser->email;
			$update = $roster->updateCancelCamp($rosterId);
			if($update) {
				//mail to admin and customer
				$date = date('m-d-Y H:i:s');//US format
				$inputData = array('campname'=>$campname,'location'=>$location, 'username'=>$userName, 'useremail'=>$userEmail, 'canceldate'=>$date);
				dispatch(new CancelCampRegistraionEmail($inputData));
			}
		}
		return redirect ('user/regCamps')->with(array('status'=>'Your camp is successfully cancelled!'));
	}

	/**
		** This function is used to check 24hrs date before cancel registeration 
		** 
		** @param int $campId
		** return boolean 
	**/
	public function getCheckDate(Request $request) {
		$campObj = new Camps();
		$campId = $request['campid'];
		$getCamps = $campObj->getCamp($campId);
		// This is just an example. In application this will come from Javascript (via an AJAX or something)
		$timezone_offset_minutes = $request['timezone_offset_minutes'];

		// Convert minutes to seconds
		$timezone_name = timezone_name_from_abbr("", $timezone_offset_minutes*60, false);

		$hrs='';
		if(count($getCamps) > 0) {
			date_default_timezone_set($timezone_name);
			$startdate = date('Y-m-d H:i:s');
			$enddate = $getCamps[0]->startdate.' '.$getCamps[0]->starttime;
			$pastorfuture = $this->getPastOrFuture($enddate);
			if($pastorfuture =='future') {
				$hrs = $this->differenceInHours($startdate, $enddate);
			} else {
				$hrs ='past';
			}
			
		} 
		return $hrs;
	}

	/**
		** This function is used to check difference between two dates
		** 
		** @param dates $startdate,$enddate
		** return difference  
	**/
	function differenceInHours($startdate,$enddate){
		$starttimestamp = strtotime($startdate);
		$endtimestamp = strtotime($enddate);
		$difference = round(abs($endtimestamp - $starttimestamp)/3600);
		return $difference;
	}


	/**
		* This function is used to Checking if a date is in the past or future
		* 
		* @param dates $enddate
		* return string  
	**/
	function getPastOrFuture($enddate) {
		$dateis ='';
	 	if(strtotime($enddate) > time()) {
	     # date is in the future
	 		$dateis = 'future';
	   	}
		if(strtotime($enddate) < time()) {
		 # date is in the past
			$dateis = 'past';
		}
		if(strtotime($enddate) == time()) {
		 # date is right now
			$dateis = 'now';
		}
		return $dateis;
	}

    /**
    * This function is used to fetch database data for edit the camp in user camp registration 
    * @param int $rosterId 
    * return array

    */
    function getCampRegistration($rosterId) {
        $data['roster_id'] = base64_decode($rosterId);
        $getRoster = $this->rosterObj->getRosterDetails($data['roster_id']);
        if(count($getRoster) > 0) {
            $countryObj = new CountrySite();
            
            $data['country_details'] = $countryObj->countryList();
            $data['camp_id'] = $getRoster[0]->camp_id;
            
            if (Auth::id() == $getRoster[0]->user_id) {
                $data['camp_details'] = $this->campObj->getRegisterCampDetails($data['camp_id'],'editpage');
                $campDateTime = strtotime($data['camp_details'][0]->startdate.' '.$data['camp_details'][0]->starttime);
                $tommorrowDateTime = strtotime(date('Y-m-d H:i:s',strtotime('24 hours')));  
                if ($campDateTime > $tommorrowDateTime) {
                    $data['user_details'] = $this->userObj->getUser($getRoster[0]->user_id);
                    $data['countrysele'] = ($data['camp_details'][0]->Country == 1) ? 'US' : 'AUS';
                    $data['existinghearabout'] = $getRoster[0]->hear;
                    $data['title'] = 'Edit Camp';
                    $data['month_values']= array('1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December');
                    $data['hearabout']= array('Refer from a friend'=>'Refer from a friend','Search engines'=>'Search engines','Link from another website'=>'Link from another website','Magazine article'=>'Magazine article','Newspaper'=>'Newspaper','Other'=>'Other');
                    return view('Site/edit_camp',$data);
                } else {
                    return Redirect::back()->withErrors(['You can only able to edit 24 Hrs before from camp start time']);
                }   
            } else {
                return Redirect::back()->withErrors(['You are not a authorized user to access this camp']);
            }
        }
    }

    /**
    * This function is used to edit the camp in user camp registration
    * @param array $request 
    * return redirect
    */
    function editRegisteredCamp(EditCampRequest $request) {
        $rosterId = $request['roster_id'];
        $getRoster = $this->rosterObj->getRosterDetails($rosterId);
        if(count($getRoster) > 0) {
            if (Auth::id() == $getRoster[0]->user_id) {
                $data['camp_id'] = $getRoster[0]->camp_id;
                $data['camp_details'] = $this->campObj->getRegisterCampDetails($data['camp_id'],'editpage');
                $campDateTime = strtotime($data['camp_details'][0]->startdate.' '.$data['camp_details'][0]->starttime);
                $tommorrowDateTime = strtotime(date('Y-m-d H:i:s',strtotime('24 hours')));  
                if ($campDateTime > $tommorrowDateTime) {
                    $editCampChildDetails = $this->userObj->editCampChildDetails(Auth::id(), $request->all());
                    if ($editCampChildDetails) {
                        return Redirect ('user/regCamps')->with(array('status'=>'Your camp edited successfully !!!'));
                    } else {
                        return Redirect ('user/regCamps')->withErrors(['The email id that you have entered is already exist']);
                    }
                } else {
                    return Redirect ('user/regCamps')->withErrors(['You can only able to edit 24 Hrs before from camp start time']);
                }
            } else {
                return Redirect ('user/regCamps')->withErrors(['You are not a authorized user to access this camp']);
            }
        }
    }

    /**
    	* This function is used to refund via authorize.net or enrollment for future camp
    	* @param array request  
    	* return array
    */
    public function refundEnroll(Request $request) {
        $data['title'] = "Refund"; 
        $data['campid'] = $request['camp-id'];
        $data['rosterid'] = $request['roster-id'];
        if($request['refund']=='refund') {
        	return view('Site/refund_card',$data);
        } else {
        	//Store into wallet table
        	$inputData = array('uw_camp_id' => $request['camp-id'], 'uw_user_id' => Auth::id(), 'uw_roster_id' => $request['roster-id'], 'uw_amount' => $request['camp-amt'], 'uw_created_at' => date('Y-m-d H:i:s'));
        	$insertReferenceId = $this->walletObj->storeDetails($inputData);
        	//store user wallet
        	$walletExist = $this->walletObj->checkWalletExistence(Auth::id());
            if (count($walletExist) > 0 ) {
                $walletTableId = $walletExist[0]->id;
                $existingWalletAmount = $walletExist[0]->wallet_amount;
                $updateWalletData = array('id'=> $walletTableId,'wallet_amount' => $existingWalletAmount+$request['camp-amt'], 'updated_at' => date('Y-m-d H:i:s'));
                $insertId = $this->walletObj->updateWalletDetails($updateWalletData);
            } else {
                $walletData = array('user_id' => Auth::id(), 'wallet_amount' => $request['camp-amt'], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));
                $insertId = $this->walletObj->storeWalletDetails($walletData);
            }
            
        	if($insertId) {
        		/* update the cancel status*/
        		$update = $this->rosterObj->updateCancelCamp($request['roster-id']);
        		return Redirect ('user/regCamps')->with(array('status'=>'Your account has been credited for the amount of your registration, $'.$request['camp-amt'].'.  To use this credit, simply register for another camp and apply the credit upon checkout'));
        	} else {
        		return Redirect ('user/regCamps')->withErrors(['Your wallet is not store properly']);
        	}
        }
		
    }

    /**
     * To track a order by using tracking number
     * @return view file
     */
    public function webshipOrderTracking() {
        return view('Site/weship_order_tracking');
    }
    /**
     * To track a order by using tracking number
     * @return results to view file
     */
    public function checkWebshipOrderTracking(Request $request) {
        $this->validate($request,[
            'trackingNumber'=>'required'
        ]);
        $data['trackingNumber'] = trim($request->input('trackingNumber'));
        $shipmentStatus = $this->webshipObj->checkWebshipOrderTrackingStatus($data['trackingNumber']);
        // echo '<pre>'; print_r($shipmentStatus); exit;
        if (!$shipmentStatus) {
            $data['currentShipmentStatus'] = 0; //not booked
        } else {
            $data['orderDetails'] = $shipmentStatus[0];
            $data['currentShipmentStatus'] = 1; //booked
        }
        return view('Site/weship_order_tracking', $data);
    }

    public function login(Request $request){
         //print_r($request->all());exit; 
		if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();
			$id = Auth::id();
			$_SESSION['cur_user_id'] = $id;
            return redirect()->intended('')->with(array('status'=>'Login Successfully'));
        }else{
			return redirect('/login')->with(array('error'=>'Sorry please check your credentials'));
		} 
	}
}
