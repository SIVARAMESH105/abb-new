<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Users;
use App\Models\Site\Affiliate;
use App\Jobs\SendEmailToAdmin;
use Carbon\Carbon;
use Hash;
use DataTables;
use DB;


use App\Http\Requests\Affiliate as AffiliateRequest;


class AffiliateController extends Controller
{
	/* construct method*/
    public function __construct(){
		$this->affiliate= new Affiliate();
    }
	/**
     * Show the affiliate Register.
     *
     * @return Register 
     */
	public function affiliateRegisterPage()
	{
		$data['title'] = 'Affiliate Registration';
		return view('Site/affiliate_register',$data);
	}
	/**
     * Handle Register data.
     * $request array
     * @return Register success message
     */
	public function affiliateregisterSave(AffiliateRequest $request)
	{
		$checkEmail = $this->affiliate->checkEmail($request['email']);
		if($checkEmail>0) {
			$request->session()->flash('error', "The submitted email address is already taken!");
		} else {
			if(count($request['URL'])>0) {
				$url = implode(",",$request['URL']);
			} else {
				$url = $request['URL'];
			}
			$inputData = array("name"=>$request['name'],"address"=>$request['address'],"phone"=>$request['phone'],"email"=>$request['email'],"URL_links"=>$url);
			
			$save = $this->affiliate->saveAffiliate($inputData);
			//Mail has send to admin
			dispatch(new SendEmailToAdmin($inputData));
			$request->session()->flash('status', "Register Successfully!");
		}
		return \Redirect::to('affiliate/register');
	}
}
