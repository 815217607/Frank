<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthMember
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
        if (Auth::guard('member')->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                $returnurl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                if(isset($_SERVER['QUERY_STRING'])&&empty($_SERVER['QUERY_STRING']))$returnurl.'?'.$_SERVER['QUERY_STRING'];
                Session::put('returnurl',$returnurl);
                return redirect()->to('/member/login');
            }
        }

        return $next($request);
    }
}
