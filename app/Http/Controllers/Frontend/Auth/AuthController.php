<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\Models\Member;
use App\Services\Access\Traits\UseSocialite;
use Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Socialite;

/**
 * Class AuthController
 * @package App\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins,UseSocialite;
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $redirectTo = '/';
    protected $guard = 'member';
    protected $loginView = 'frontend.auth.login';
    protected $registerView = 'frontend.auth.register';
    protected $username = 'username';

    /**
     * Where to redirect users after they logout
     *
     * @var string
     */
    protected $redirectAfterLogout = '/member/login';

    /**
     * @param UserContract $user
     */
    public function __construct()
    {
        $this->middleware('guest:member', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        if (view()->exists($this->loginView)) {
            return view($this->loginView)->withSocialiteLinks($this->getSocialLinks());
        }

        return view($this->loginView)->withSocialiteLinks($this->getSocialLinks());
    }
    public function showRegistrationForm()
    {
        return view($this->registerView);
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'sometimes|required|max:255|unique:members',
            'mobile' => 'sometimes|required|max:255|unique:members',
            'email' => 'sometimes|required|max:255|unique:members',
            'password' => 'required|confirmed|min:6',
        ]);

    }

    protected function createUser(array $data)
    {
        $this->validator($data);

        return Member::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

    }

//    /**
//     * Handle a login request to the application.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function login(Request $request)
//    {
//        if($data=$request->all()){
//            if(isset($data['username'])){
//                $this->username='username';
//            }elseif(isset($data['mobile'])){
//                $this->username='mobile';
//            }elseif(isset($data['email'])){
//                $this->username='email';
//            }
//        }
//        $this->validateLogin($request);
////        dump(23423);die;
////dump($request);die;
//        // If the class is using the ThrottlesLogins trait, we can automatically throttle
//        // the login attempts for this application. We'll key this by the username and
//        // the IP address of the client making these requests into this application.
//        $throttles = $this->isUsingThrottlesLoginsTrait();
//
//        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//
//            return $this->sendLockoutResponse($request);
//        }
//
//        $credentials = $this->getCredentials($request);
//
//        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
//            return $this->handleUserWasAuthenticated($request, $throttles);
//        }
//
//        // If the login attempt was unsuccessful we will increment the number of attempts
//        // to login and redirect the user back to the login form. Of course, when this
//        // user surpasses their maximum number of attempts they will get locked out.
//        if ($throttles && ! $lockedOut) {
//            $this->incrementLoginAttempts($request);
//        }
//
//        return $this->sendFailedLoginResponse($request);
//    }
//
//
//    /**
//     * Get the login username to be used by the controller.
//     *
//     * @return string
//     */
//    public function loginUsername()
//    {
//        return property_exists($this, 'username') ? $this->username : 'email';
//    }


    public function redirectToProvider($driver){
        return Socialite::driver($driver)->redirect();
    }

    public function handleProviderCallback($driver){
        $user = Socialite::driver($driver)->user();
    }
}















