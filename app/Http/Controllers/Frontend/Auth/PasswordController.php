<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;

use App\Repositories\Frontend\User\UserContract;
use App\Services\Access\Traits\ChangePasswords;
use Illuminate\Foundation\Auth\ResetsPasswords;

/**
 * Class PasswordController
 * @package App\Http\Controllers\Frontend\Auth
 */
class PasswordController extends Controller
{

    use  ResetsPasswords;

    /**
     * Where to redirect the user after their password has been successfully reset
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    protected $guard = 'member';
    protected $broker = 'member';
//    protected $guard = 'member';
    /**
     * @param UserContract $user
     */
    public function __construct()
    {
        $this->middleware('guest:member', ['except' => 'logout']);

    }
}