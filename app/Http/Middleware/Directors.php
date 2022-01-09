<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Directors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if ( backpack_auth()->check() && (backpack_auth()->user()->user_type == 4 || backpack_auth()->user()->user_type == 1) )
        {
			return $next($request);
        } else {
			return abort(403);
		}
    }
}
