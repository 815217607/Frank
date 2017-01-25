<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Models\Backend\Admin;
use App\Services\Access\Traits\AuthenticatesAndRegistersUsers;
use App\Services\Access\Traits\UseSocialite;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins,UseSocialite;
    public function __construct()
    {

        $this->middleware('admin_auth', ['except' => ['logout']]);
    }

    //登录
    public function login(Request $request)
    {

        if ($request->isMethod('post')) {
            $validator = $this->validateLogin($request->input());

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if (Auth::guard('admin')->attempt(['username'=>$request->username, 'password'=>$request->password])) {
                return Redirect::to('admin/dashboard')->with('success', '登录成功！');     //login success, redirect to admin
            } else {
                return back()->with('error', '账号或密码错误')->withInput();
            }
        }
        return view('backend.auth.login');
    }
    //登录页面验证
    protected function validateLogin(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|alpha_num',
            'password' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求'
        ], [
            'username' => '账号',
            'password' => '密码'
        ]);
    }

    //退出登录
    public function logout()
    {
        if(Auth::guard('admin')->user()){
            Auth::guard('admin')->logout();
        }
        return Redirect::to('manage/login');
    }
    //注册
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateRegister($request->input());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $user = new Admin();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->create_time = time();
            $user->update_time = time();
            if($user->save()){
                return redirect('admin/login')->with('success', '注册成功！');
            }else{
                return back()->with('error', '注册失败！')->withInput();
            }
        }
        return view('admin.register');
    }
    protected function validateRegister(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|alpha_num|max:255',
            'username' => 'required|alpha_num|unique:admins',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|'
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'confirmed' => '两次输入的密码不一致',
            'unique' => '该账户已存在',
            'alpha_num' => ':attribute 必须为字母或数字',
            'max' => ':attribute 长度过长'
        ], [
            'name' => '昵称',
            'username' => '账号',
            'password' => '密码',
            'password_confirmation' => '确认密码'
        ]);
    }
}
