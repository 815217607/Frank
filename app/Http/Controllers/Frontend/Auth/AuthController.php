<?php

namespace App\Http\Controllers\Frontend\Auth;


use App\Models\Member;

use App\Services\Access\Traits\UseSocialite;
use Auth;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
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
        return Socialite::with($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::with($provider)->user();

        // $user->token;
    }

}















