<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Affiliate;
use App\Models\Admin\User;
use App\Jobs\WelcomeEmailForAdminCreatedUsers;
use App\Jobs\SendEmailToAdmin;
use App\Jobs\CommissionPaidStatusForAffiliator;
use Carbon\Carbon;
use Auth;
use DB;
use DataTables;
use Hash;



class AffiliateController extends Controller
{
    public function __construct()
	{
		$this->affiliate= new Affiliate();
		$this->user= new User();
    }
	/**
     * Show the affiliate Register.
     *
     * @return redirect to page 
     */
	public function affiliateList()
	{
		return view('Admin.affiliate_lists');
	}
	
	/**
     * Show the affiliate Create.
     *
     * @return redirect to page  
     */
	public function createAffiliate()
	{
		return view('Admin.create_affiliate');
	}
	
	
	/**
     * Save the affiliate.
     * @param array $request
     * @return redirect to page 
     */
	
	public function storeAffiliate(Request $request)
    {
		$checkEmail = $this->affiliate->checkEmail($request['email']);
		if($checkEmail>0) {
			\Alert::error('The submitted email address is already taken!')->flash();
			return \Redirect::to('admin/createAffiliate');
		} else {
			if(count($request['URL'])>0) {
				$url = implode(",",$request['URL']);
			} else {
				$url = $request['URL'];
			}
			$inputData = array("name"=>$request['name'],"address"=>$request['address'],"phone"=>$request['phone'],"email"=>$request['email'],"URL_links"=>$url,"commission_percentage"=>$request['commission_percentage']);
			
			$save = $this->affiliate->saveAffiliate($inputData);
			//Mail has send to admin
			dispatch(new SendEmailToAdmin($inputData));
			\Alert::success('Affiliate added successfully')->flash();
			return \Redirect::to('admin/manageAffiliate');	
		
		}
    }
	
	
	
	/**
     * Edit the affiliate user.
     * @param int $id
     * @return redirect to page 
     */
	public function editAffiliate($id) {
		$data['result'] = $this->affiliate->getResultById($id);
		$explode = explode(",", $data['result']->URL_links);
		if(count($explode)==1) {
			$data['countURL'] = 5-count($explode);
		} elseif(count($explode)==2) {
			$data['countURL'] = 5-count($explode);
		} elseif(count($explode)==3) {
			$data['countURL'] = 5-count($explode);
		} elseif(count($explode)==4) {
			$data['countURL'] = 5-count($explode);
		} else {
			$data['countURL'] = 5-count($explode);
		}
		return view('Admin.edit_affiliate',$data);
	}
	
	/**
     * Update the affiliate user.
     * @param array $request
     * @return redirect to page 
     */
	public function updateAffiliate(Request $request) {
		$checkEmail = $this->affiliate->checkEmailExceptEditId($request['email'],$request['editId']);
		if($checkEmail>0) {
			\Alert::error('The submitted email address is already taken!')->flash();
			return \Redirect::to('admin/manageAffiliate');
		} else {
			if(count($request['URL'])>0) {
				$url = implode(",",$request['URL']);
			} else {
				$url = $request['URL'];
			}
			$inputData = array("name"=>$request['name'],"address"=>$request['address'],"phone"=>$request['phone'],"email"=>$request['email'],"URL_links"=>$url,"commission_percentage"=>$request['commission_percentage'], "editId"=>$request['editId']);
			
			$save = $this->affiliate->updateAffiliate($inputData);
			\Alert::success('Affiliate update successfully')->flash();
			return \Redirect::to('admin/manageAffiliate');
		}
	}
	
	/**
     * Delete the affiliate List.
     * @param $id int
     * @return redirect to page 
     */
	public function deleteAffiliate($id)
    {       
        $affiliate = Affiliate::find($id);
		//delete user table reference id first
		$userId =$affiliate['userId'];
		$user = User::find($userId);
		$userStatus =$user->delete();
        $status =$affiliate->delete();
        if($status == 'ok') {
            \Alert::success('Affiliate deleted successfully')->flash();
            return \Redirect::to('admin/manageAffiliate');
        } else {
            \Alert::error('Affiliate delete action failed')->flash();
            return \Redirect::to('admin/manageAffiliate');
        }
    }
	
	
	/**
     * Show the affiliate List.
     *
     * @return obeject 
     */
	public function getAffiliateList(Request $request)
    {
        $affiliateDetails = DB::table('tbl_affiliate_users')->get();
		return DataTables::of($affiliateDetails)
			->editColumn('is_approved', function ($details){
				if($details->is_approved==1) {
					return '<input type="checkbox" name="approved" disabled checked id="approved'.$details->id.'" onclick="isApprove('.$details->id.')" value="'.$details->id.'"/>';
				} else {
					return '<input type="checkbox" name="approved" id="approved'.$details->id.'" onclick="isApprove('.$details->id.')" value="'.$details->id.'"/>';
				}
			})->addColumn('action', function ($details) {
                return '<a href="'.url('admin/editAffiliate/'.$details->id).'" class="btn btn-xs btn-default"><i class="fa fa-edit" ></i> Edit</a><a href="javascript:void(0);" onclick="confirmationDelete('.$details->id.');return false;"  class="btn btn-xs btn-default"><i class="fa fa-trash" ></i> Delete</a>';
        })->rawColumns(['is_approved', 'action'])->make(true);
    }
    
	/**
     * This function is used to affilaite user approve from admin.
     * @param $id int
     * @return redirect to page 
     */
    public function affiliateApprove(Request $request) {
		$getAffiliateUser = $this->affiliate->getResultById($request['approveId']);
		//insert user table
		if($request['isApprove']==1) {
			//user inserted
			$password = str_random(8);
			$inputData = array("name"=>$getAffiliateUser->name,"email"=>$getAffiliateUser->email,"password"=>$password, "user_type"=>5,"created_at"=>date('Y-m-d H:i:s'));
			$userId = $this->user->insertAffiliateUser($inputData);
			//Update affiliate user table for reference
			$update = $this->affiliate->updateAffiliateUserIdById($userId,$request['approveId']);
			//Job mail to affiliate user
			if($userId != '') {
				dispatch(new WelcomeEmailForAdminCreatedUsers($inputData)); #Created job to send welcome email
			}
			return $userId;
		} else {
			return 0;
		}
		
    }

    /**
     * Show the affiliate report page.
     *
     * @return redirect to page  
     */
    public function affiliateReports() {
        $getCommissionAmount = $this->affiliate->getPaidAndDueAmount();
        $data['getDueAmount'] = ($getCommissionAmount['due'][0]->dueamount) ? $getCommissionAmount['due'][0]->dueamount : '0.00' ;
        $data['getPaidAmount'] = ($getCommissionAmount['paid'][0]->paidamount) ? $getCommissionAmount['paid'][0]->paidamount : '0.00' ;
        return view('Admin.affiliate_reports', $data);
    }   

    /**
     * Show the affiliate Report List.
     *
     * @return obeject 
     */
    public function getAffiliateReportList()
    {
        $affiliateReportDetails = $this->affiliate->getAffiliateReportList();

        return DataTables::of($affiliateReportDetails)
            ->editColumn('is_paid', function ($affiliateReportDetails) { 
                $pendingSelection = ($affiliateReportDetails->is_paid == 0) ? 'selected' : '';       
                $paidSelection = ($affiliateReportDetails->is_paid == 1) ? 'selected' : '';       
                return '<select name="affiliatePaymentStatus" id="change-payment-'.$affiliateReportDetails->id.'" class="form-control input-sm" onchange="changePaymentStatus('.$affiliateReportDetails->id.')" ><option value="0" '.$pendingSelection.'>Pending</option><option value="1" '.$paidSelection.'>Paid</option></select>';
            })->rawColumns(['is_paid'])
        ->make(true);
    }

    /**
     * Change affiliate commission payment status
     * @param array $request
     * @return null
     */
    public function ajaxAffiliatePaymentStatus(Request $request) {
        $updateIsPaid = $this->affiliate->ajaxAffiliatePaymentStatus($request);
        if ($request['paymentStatus'] == 1 && $updateIsPaid) {
            $getMailInputs = $this->affiliate->getaffiliateMailDetails($request);
            if(count($getMailInputs)>0) {
            	$mailInputs = $getMailInputs[0];
            	dispatch(new CommissionPaidStatusForAffiliator($mailInputs)); #Created job to send commission paid mail notification to affiliator	
            }
        }
    }
}
