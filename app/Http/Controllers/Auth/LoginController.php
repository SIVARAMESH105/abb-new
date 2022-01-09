<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Site\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
session_start();
use Session;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       $this->middleware('guest', ['except' => 'logout']);
    }
	
	public function logout(Request $request)
    {  
		unset($_SESSION['product'],$_SESSION['camps'],$_SESSION['camp_details'],$_SESSION['camp_cart_id'],$_SESSION['roster_id'],$_SESSION['cur_user_id']);
        Auth::logout();
		Session::flush();
		return redirect ('')->with(array('status'=>'Logout Successfully'));
	}
	
	public function login(Request $request){  
       // print_r($request->all());exit;    
		if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password'),'user_type'=>3])) {
            $user = Auth::user();
			$id = Auth::id();
			$_SESSION['cur_user_id'] = $id;  
            return redirect()->intended('')->with(array('status'=>'Login Successfully'));
        }else{
			return redirect('/login')->with(array('error'=>'Sorry please check your credentials'));
		} 
	}

     
}
