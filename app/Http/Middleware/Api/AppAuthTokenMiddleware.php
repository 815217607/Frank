<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15/10/12
 * Time: 19:28
 */

namespace App\Http\Middleware\Api;



use App\Core\Facades\AppUserAuth;
use App\Util\ResponseUtil;
use Closure;

class AppAuthTokenMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $token = $request->header('token', null);
        $userInfo = null;
        if(!AppUserAuth::authByToken($token))
            return ResponseUtil::error(ResponseUtil::CODE_AUTH_FAIL, '未登录', 10002);

        return $next($request);
    }

}