<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Session;
use DB;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$type)
    {	//
		$user = Auth::user();
		$id = Auth::id();
		//echo $type.'---'. $user['user_type'];die;
		if($type == 'web' && $user['user_type'] == 3){
			return $next($request);	
		}else{
			return redirect('admin/login');
		}
		return $next($request);	
	}
}
