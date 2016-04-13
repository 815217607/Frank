<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15/10/13
 * Time: 00:14
 */

namespace App\Core\Facades;


use App\Models\User;
use App\Models\UserSession;

class AppUserAuth
{

    /**
     * @var $user User
     */
    private static $user;

    public static function setUser(User $user) {
        self::$user = $user;
    }

    public static function getUser() {
        return self::$user;
    }

    public static function authByToken($token) {
        $user = null;
        if($token!==null) {
            $userSession = UserSession::query()->where('token',$token)->with(['user'])->first();
            if($userSession){

                $user = $userSession->user;
                if(isset($userSession->radio_type))$user->user_type=$userSession->radio_type;
            }
        }

        if($user===null) {
            return false;
        }else {
            self::setUser($user);
            return true;
        }
    }

}