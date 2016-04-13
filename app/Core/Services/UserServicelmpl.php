<?php
 /**
 * User: fuqixue1987@163.com
 */

namespace App\Core\Services;

use App\Core\Facades\UserService;

use App\Models\Access\User\User;

use App\Models\UserSession;
use App\Util\ResponseUtil;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserServicelmpl
   {
    /**
     * 创建数据
     * 1、验证验证码
     * 2、确认用户是否存在
     * 3、创建用户
     * @param $param
     * @return array|static
     */
    public function  create($param){
        $code=Cache::get('phone/' . $param['username'] . '/code');
//        if(!isset($param['code'])||empty($param['code'])||$param['code']!=$code) return error(10013);
        unset($param['code']);
        Cache::forget('phone/' . $param['username'] . '/code');
        $param['created_at']=ResponseUtil::created_times();
        $param['password']=Hash::make($param['password']);
        $user_info=User::query()->where('username',$param['username'])->first();
        if($user_info)return error(10011);
        $info= User::create($param);
        return isset($info->id)?success($info):error();
    }

    /**
     * 根据ID获取数据
     * @param $id
     * @return mixed
     */
    public function findById($id){
       return User::find($id);
    }

    /**
     * 根据条件获取数据
     * @param $param
     * @param array $fields
     * @return mixed
     */
    public function info($param,$fields=array('')){
      return  User::where($param['where'])->get();
    }

    /**
     * 跟新数据
     * @param $param
     * @return array|string
     */
    public function update($param){
        $data=User::find($param['id']);
        if(empty($data)) return error();
        unset($param['id']);
        foreach($param as $key=>$val){
            $data->$key=$val;
        }
        $falg=$data->save();
        return $falg;
    }

    /**
     * 删除数据
     * @param $id
     */
    public function delById($id){
        $data=User::find($id);
        return $data->delete();
    }

    /**
     * 用户登录
     * @param $params
     * @return array|string
     */
    public function login($params){
        $validator = Validator::make($params, [
            'username' => ['required'],
            'password' => ['required']
        ]);
        if($validator->fails()) {
            return error(0,$validator->messages());
        }else {
            $user = User::query()->where('username',$params['username'])->first();
            if(!empty($user->toArray()) && Hash::check($params['password'], $user['password'])) {
                $array=$user;
                $array['access_key']=$data =  Crypt::encrypt($params['username']);
                $array['access_token'] =$data=  md5($params['username'].time());
                UserSession::create(array('access_token'=> $array['access_token'],'user_id'=>$array['id'],'created_at'=>created_times()));
                return response($array);
            }else {
                return error(400);
            }
        }
    }

    /**
     * 用户注销
     * @param $params
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function cancel($params){
        $validator = Validator::make($params, [
            'user_id'=>['required'],
        ]);
        if($validator->fails()) {
            return response(error(400));
        }
        return UserSession::where('user_id', $params['user_id'])->delete();
        }

    /**
     * 发送验证码
     * @param Request $request
     * @return mixed
     */
    public function  sendCode($params){
        //1、验证access_token
        //2、验证号码
        $validator = Validator::make($params, [
            'phone'=>['required','regex:/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/'],
        ]);
        if($validator->fails()) {
            return response(error(400));
        }
        $info=User::where('phone',$params['phone'])->first();
        if(empty($info)) return response(error(10008));
        $pwdinfo=PasswordResets::where('phone',$params['phone'])->where('token',$params['token'])->first();
        $sms=new LeanCloudSms();
        //3、验证码是否过期
        if(strtotime($pwdinfo['created_at'])-time()-$sms->ttl<0)return response(error(10009));
        $sms->phone=$params['phone'];
        $ref=$sms->smsCode();
        if(empty($ref))PasswordResets::create($params);
    }

    /**
     * 验证短信验证码
     * @param Request $request
     * @return mixed
     */
    public function codeCheck($params){
        //1、验证access_token

        //2、验证号码
        $validator = Validator::make($params, [
            'phone'=>['required','regex:/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/'],
        ]);
        if($validator->fails()) {
            return response(error(400));
        }
        $info=User::where('phone',$params['phone'])->first();
        if(empty($info)) return response(error(10008));
        $pwdinfo=PasswordResets::where('phone',$params['phone'])->where('token',$params['token'])->first();
        //3、验证码是否进行密码重置
        if($pwdinfo)return response(error(10010));
        $sms=new LeanCloudSms();

        $sms->phone=$params['phone'];
        return $sms->verifySmsCode($params);
    }
    /**
     * 初次设置支付密码
     * @param $params
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function payPassword($params) {
        $info = DB::transaction(function() use ($params) {
            $user_info = User::find($params['user_info']->id);
            if (!$user_info->pay_passwd_exist) {
                $user_info->pay_passwd_exist = 1;
                $user_info->pay_passwd = md5($params['password']);
                $user_info->save();
                foreach ($params['secure_answer'] as $val) {
                    $question = SecureQuestion::find($val['question_id']);
                    if (!$question)
                        return false;
                    $val['user_id'] = $user_info->id;
                    $val['question'] = $question->question;
                    UserSecureAnswer::create($val);
                }
                return true;
            } else
                return false;
        });
        return $info ? ResponseUtil::success('{}') : ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', ResponseUtil::CODE_REQUEST_INVALID);
    }

    /**
     * 初次设置登录密码
     * @param $params
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function loginPassword($params) {
        $info = DB::transaction(function() use ($params) {
            $user_info = User::find($params['user_info']->id);
            if (!$user_info->passwd_exist) {
                $user_info->passwd_exist = 1;
                $user_info->password = md5($params['password']);
                $user_info->save();

                return true;
            } else
                return false;
        });
        return $info ? ResponseUtil::success('{}') : ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', ResponseUtil::CODE_REQUEST_INVALID);
    }

    /**
     * 用户注销
     * @param $params
     * @return array|string
     */
    public function logout($params){
        $info=UserSession::query()->where('user_id',$params['user_id'])->delete();
        return $info;
    }
   }