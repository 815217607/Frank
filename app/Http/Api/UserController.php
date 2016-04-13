<?php

/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15/10/7
 * Time: 22:07
 */

namespace App\Http\Controllers\Api;

use App\Core\Auth\AppUserAuth;
use App\Core\Auth\SmsService;


use App\Core\Facades\UserService;

use App\Models\Access\User\User;

use App\Models\UserSession;
use App\Util\ResponseUtil;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Request;
use Webpatser\Uuid\Uuid;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('app_user_auth', [
            'only' => [
                'editProfile']
        ]);
    }

    /**
     * 发送验证码
     * @param $phone
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function sendCode($phone) {
        $code = rand(100000, 999999);
        SmsService::send($phone, $code);
        Cache::put('phone/' . $phone . '/code', $code, 10);
//        return ResponseUtil::success('{}');
        return ResponseUtil::success(['code'=>$code]);
    }

    /**
     * 校验验证码
     * @param $phone
     * @param $code
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function verifyCode($phone, $code) {
        $correctCode = Cache::get('phone/' . $phone . '/code');
        if($correctCode==$code) {
            return ResponseUtil::success('{}');
        }else {
            return ResponseUtil::error(400,'',ResponseUtil::ERROR_CODE_10000);
        }
    }

    /**
     * 注册
     */
    public function signUp() {
        $phone = Request::get('phone','');
        $code = Request::get('code','');
        $password = Request::get('password','');
        $correctCode = Request::get('phone/' . $phone . '/code', '');
        if($code==='' || $correctCode!=$code) {
            return ResponseUtil::error(400,'',ResponseUtil::ERROR_CODE_10000);
        }
        if(mb_strlen($password,'utf8')<1 || mb_strlen($password,'utf8')>20) {
            return ResponseUtil::error(400,'',ResponseUtil::ERROR_CODE_10001);
        }
        if(User::where('phone',$phone)->count()) {
            return ResponseUtil::error(400,'',ResponseUtil::ERROR_CODE_10003);
        }
        $user = UserService::register([
            'phone'=>$phone,
            'password'=>$password
        ]);
        if($user) {
            $userSession = UserSession::create([
                'user_id' => $user->id,
                'token' => str_replace('-', '', Uuid::generate())
            ]);
            $user->token = $userSession->token;
            Cache::forget('phone/' . $phone . '/code');
            return ResponseUtil::success($user);
        }else {
            return ResponseUtil::error(ResponseUtil::CODE_INTERNAL_ERROR,'',ResponseUtil::ERROR_CODE_500);
        }
    }

    /**
     * 登录
     */
    public function signIn() {
        $phone = Request::get('phone', '');
        $password = Request::get('password', '');
        $user = User::where('phone',$phone)->first();
        if(!$user || !Hash::check($password, $user->password)) {
            return ResponseUtil::error(400,'',ResponseUtil::ERROR_CODE_10002);
        }

        $userSession = UserSession::create([
            'user_id'=>$user->id,
            'token'=>str_replace('-', '', Uuid::generate())
        ]);

        $user->token = $userSession->token;
        return ResponseUtil::success($user);
    }

    /**
     * 第三方登录
     */
    public function oauth() {
        $params = Request::all();
        $validator = Validator::make($params, [
            'openid' => ['required','min:1'],
            'plat' => ['required','integer'],
            'nickname' => ['required', 'min:1'],
            'avatar'=>['required','min:1']
        ]);
        if($validator->fails()) {
            return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID,'',400,$validator->errors());
        }
        $user = User::query()->where(['openid'=>$params['openid'],'plat'=>$params['plat']])->first();
        if(!$user)
            $user = UserService::register($params);
        if($user) {
            return ResponseUtil::success($user);
        }else {
            return ResponseUtil::error(400,'',500);
        }
    }

    /**
     * 获取个人信息
     * @param $user_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getProfile($user_id) {
        $user = User::find($user_id);
        if($user)
            return ResponseUtil::success($user);
        else
            return ResponseUtil::error(400, '', 404);
    }


    /**
     * 修改个人信息,密码
     * @param $user_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function editProfile() {
        $user = AppUserAuth::getUser();
        $params = array_only(Request::all(), ['nickname','avatar','email','company_name']);
        if($password=Request::get('password')) {
            $oldPassword = Request::get('old_password');
            if(Hash::check($oldPassword, $user->password))
                $params['password'] = Hash::make($password);
            else {
                return ResponseUtil::error(400,'', ResponseUtil::ERROR_CODE_10004);
            }
        }
        $user->update($params);
        return ResponseUtil::success($user);
    }



    /**
     * 获取通讯录用户
     * @return mixed
     */
    public function searchPhoneBook() {
        $user = AppUserAuth::getUser();
        $phones = Request::all();
        if(isset($phones['_elapsed']))
            unset($phones['_elapsed']);
        $users = User::query()->whereIn('phone', $phones)->get();
        $usersMap = [];
        foreach($users as $user) {
            $usersMap[$user->phone] = $user;
        }
        foreach($phones as &$phone) {
            $phone = ['phone'=>$phone, 'user'=>array_get($usersMap, $phone)];
        }
        return ResponseUtil::success($phones);
    }

    /**
     *
     * 忘记登陆密码,身份验证
     * @param $request
     */
    public function forgetPassword(Request $request) {
        $params = $request->all();
        if (Cache::get('phone/' . $params['username'] . '/code') != $params['code'])
            return ResponseUtil::error(ResponseUtil::ERROR_CODE_10000, '验证码不正确', 10000);

        $user = User::query()->where('username', $params['username'])->first();
        Cache::put('user/updatePassword'.$params['username'],$user,10);
        return $user?ResponseUtil::success(['username'=>$params['username']]):ResponseUtil::error(ResponseUtil::ERROR_CODE_404, '用户不存在', 10001);
    }

    /**
     *
     * 忘记登陆密码,重置登陆密码
     * @param $request
     */
    public function updatePassword(Request $request) {
        $params = $request->all();
        if($params['password']!=$params['password1'])return ResponseUtil::error(ResponseUtil::ERROR_CODE_10005, '请验证用户身份', 10005);

        $user_info=Cache::get('user/updatePassword'.$params['username']);
        if (!$user_info)
            return ResponseUtil::error(ResponseUtil::ERROR_CODE_404, '请验证用户身份', 10001);

        $user = User::query()->where('phone', $user_info->phone)->first();
        if (!$user) {
            return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '用户不存在', 10001);
        }

        $user->password = Hash::make($params['password']);
        $falg=$user->save();
        return $falg?ResponseUtil::success([]):ResponseUtil::error(ResponseUtil::ERROR_CODE_500, '操作失败', 500);

    }

    /**
     * 验证用户是否存在
     * @param $name
     * @return bool
     */
    public function  verification_phone($name){
        $query=User::query()->where('username',$name)->orWhere('email',$name)->orWhere('phone',$name);
        $info=$query->first();
        return !$info?true:false;
    }

    /**
     * 手机号码修改
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update_phone(){
        if (Cache::get('phone/' . Request::get('username') . '/code') != Request::get('code'))
            return ResponseUtil::error(ResponseUtil::ERROR_CODE_10000, '验证码不正确', 10000);
        $auth_user=AppUserAuth::getUser();
        $user_info=User::query()->find($auth_user->id);
        if(!$user_info) return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID,null,ResponseUtil::CODE_RESOURCE_NOT_FOUND);
        $user_info->phone=Request::get('username');
        $falg=$user_info->save();
        return $falg?ResponseUtil::success():ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID,null,ResponseUtil::ERROR_CODE_404);
    }

}
