<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Site\Users;
use App\Models\Site\Affiliate;
use Auth;
use Lang;
use Session;
use DataTables;

class AffiliateDashboardController extends Controller
{
	/* construct method*/
	public function __construct()
	{
		$this->userObj = new Users();
		$this->affiliate= new Affiliate();
	}
	
	/*Affiliate index function*/
	public function index()
	{
		$value = Session::get('username');
		if(!empty($value)) {
			$data['title']="Dashboard";
			$data['username'] = $value;
			$data['social_links'] = 1;
			return view('Site/affiliateDashboard', $data);
		} else {
			Auth::logout();
			return \Redirect::to('affliate/login');
		}
			
	}

	/* 
		* This function is used to list the banner
	*/
	public function bannerlist() {
		$value = Session::get('username');
		$data['title'] = "Banner Lists";
		$data['username'] = $value;
		//Active camp list

		//get affiliate user details
		$authId = Auth::id();
		$data['affiliate'] = $this->affiliate->getAffiliateById($authId);
		return view("Site/bannerlist",$data);

	}
	
    /* 
        * This function is used to view the affiliate commission payment status
    */
	public function commissionStatus() {
        $value = Session::get('username');
        $data['title'] = "Affiliate Commission";
        $data['username'] = $value;
        $authId = Auth::id();
        $getCommissionAmount = $this->affiliate->getPaidAndDueAmount($authId);
        $data['getDueAmount'] = ($getCommissionAmount['due'][0]->dueamount) ? $getCommissionAmount['due'][0]->dueamount : '0.00' ;
        $data['getPaidAmount'] = ($getCommissionAmount['paid'][0]->paidamount) ? $getCommissionAmount['paid'][0]->paidamount : '0.00' ;
        return view("Site/commissionStatus",$data);
    }
	

    /**
     * Show the affiliate Report List for affiliate dashboard
     *
     * @return datatable object 
     */
    public function getAffiliateReportList()
    {
        $authId = Auth::id();
        $affiliateReportDetails = $this->affiliate->getAffiliateReportList($authId);
        return DataTables::of($affiliateReportDetails)
            ->editColumn('is_paid', function ($affiliateReportDetails) { 
                return ($affiliateReportDetails->is_paid == 1) ? 'Received' : 'Pending'; 
            })->rawColumns(['is_paid'])
        ->make(true);
    }

    /**
		* This function is used to get the all users for affiliate reference website
		* @return view file 
	**/
	public function userlists() {
		$data['title'] = "User Lists";
        $data['username'] = Session::get('username');
		return view("Site/user_list_to_affiliate",$data);
	}

    /**
		* This function is used to get the all users for affiliate reference website
		* @return datatable object 
	**/
	public function getReferenceUsers() {
		$authId = Auth::id();
		$getUsers = $this->affiliate->getReferenceUsers($authId);
		return DataTables::of($getUsers)->editColumn('created_at', function($getUsers) {
			return date('m-d-Y H:i:s',strtotime($getUsers->created_at));
		})->make(true);
	}
	
}