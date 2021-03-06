<?php

namespace App\Http\Controllers\Backend\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\Access\Traits\ConfirmUsers;
use App\Services\Access\Traits\UseSocialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Repositories\Frontend\User\UserContract;
use App\Services\Access\Traits\AuthenticatesAndRegistersUsers;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ConfirmUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Where to redirect users after they logout
     *
     * @var string
     */
    protected $redirectAfterLogout = '/admin/login';

//    protected $redirectToLogin='';
    protected $loginView='backend.auth.login';
    /**
     * @param UserContract $user
     */
    public function __construct(UserContract $user)
    {

        $this->user = $user;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        $loginView=property_exists($this, 'loginView') ? $this->loginView : 'frontend.auth.login';
        return view($loginView);
    }

}















