<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\Events\Frontend\Auth\UserLoggedIn;
use App\Exceptions\GeneralException;
use App\Models\Access\User\SocialLogin;
use App\Models\Member;

use App\Services\Access\Traits\UseSocialite;
use Auth;
use App\Http\Controllers\Controller;

use Eyuan\Cart\AuthExtend;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


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
     * @param MemberContract $user
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


    public function redirectToProvider(Request $request,$provider)
    {
        if (! in_array($provider, $this->getAcceptedProviders()))
            return redirect()->route('frontend.index')->withFlashDanger(trans('auth.socialite.unacceptable', ['provider' => $provider]));

        /**
         * The first time this is hit, request is empty
         * It's redirected to the provider and then back here, where request is populated
         * So it then continues creating the user
         */

            return $this->getAuthorizationFirst($provider);
    }

    public function handleProviderCallback(Request $request,$provider)
    {

        $returnurl=Session::has('returnurl')?Session::get('returnurl'):$this->redirectPath();
        Session::forget('returnurl');
        $info=$this->getSocialUser($provider);

        $user = $this->findOrCreateSocial($info, $provider);
        auth()->guard('member')->login($user, true);

        /**
         * Throw an event in case you want to do anything when the user logs in
         */
        event(new UserLoggedIn($user));

        /**
         * Set session variable so we know which provider user is logged in as, if ever needed
         */
        session([config('access.socialite_session_name') => $provider]);

        return redirect()->intended($returnurl);
    }


    /**
     * @param $email
     * @return bool
     */
    private function findByEmail($email) {
        $user = Member::where('username', $email)->first();

        if ($user instanceof Member)
            return $user;

        return false;
    }


    /**
     * @param $data
     * @param $provider
     * @return EloquentMemberRepository
     */
    private function findOrCreateSocial($data, $provider)
    {
        /**
         * Check to see if there is a user with this email first
         */
        $user = $this->findByEmail($data->id);

        /**
         * If the user does not exist create them
         * The true flag indicate that it is a social account
         * Which triggers the script to use some default values in the create method
         */
        if (! $user) {
            $user = $this->create([
                'name'  => $data->nickname,
                'username' => $data->id,
                'password' => $data->id,
                'email' => $data->email
            ], true);
        }
        return $user;
    }

    /**
     * @param array $data
     * @param bool $provider
     * @return static
     */
    public function create(array $data, $provider = false)
    {
//        if ($provider) {
            $user = Member::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => bcrypt( $data['username']),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => 1,
                'status' => 1,
            ]);

        /**
         * Return the user object
         */
        return $user;
    }

}















