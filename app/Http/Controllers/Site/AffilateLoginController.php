<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Site\Users;
use Auth;
use Lang;
use Session;

class AffilateLoginController extends Controller
{

	public function __construct()
	{
		$this->userObj = new Users();
		
	}
	
	/*
		Affliate login
		return login or dashboard
	*/
	public function affliateLogin()
	{
		if(!Auth::id() || Auth::user()->user_type == 5) {
			$data['title'] = 'Affiliate Login';
			return view('Affiliate/login', $data);
		} else {
			return redirect('affiliate/dashboard');
		}
	}
	
	/**
     * Checking login credentials and allowing into site.
     *
     * @param  array $request
     * @redirect dashboard if credentials correct
     */
	public function doLogin(Request $request)
	{
		if(Auth::attempt(['email' => $request->all()['email'], 'password' => $request->all()['password'], 'user_type'=>5])) {
            Session::put('username', Auth::user()->name);
            Session::put('cur_user_id', Auth::id());
			Session::put('user_type', Auth::user()->user_type);           
			return redirect('affiliate/dashboard');
		} else {
			$request->session()->flash('error', "These credentials do not match our records.");
		}
		return \Redirect::to('affliate/login');
	}
	
	/**
     * Logout admin.
     *
     * @redirect login page
     */
	public function logout()
	{
		Auth::logout();
		Session::flush();
        return \Redirect::to('affliate/login');
	}
	
	
}