<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Auth;

use Eyuan\AuthExtend\AuthExtend;
use Memcache;


/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    public function __construct()
    {
//        $this->middleware('member_auth:member');
    }
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

//        $mem= new Memcache();
//        $rel=$mem->addserver("127.0.0.1",11211);;
        javascript()->put([
            'test' => 'it works!',
        ]);

        return view('frontend.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
//        $memcache_obj = memcache_pconnect('127.0.0.1', 11211);
//        dump($memcache_obj);die;
//        $mem=new Memcache;
//        $mem->connect("127.0.0.1",11211);
////        ("127.0.0.1",11211);
//        $val='测试';
//        $key=md5($val);
//        $mem->set($key,$val,0,120);
//        if($k=$mem->get($key)){
//            echo 'fromcache'.$k;
//        }else{
//            echo 'normal';
//        }
        return view('frontend.macros');
    }


    public function test(){
        $auth=AuthExtend::getInstance();
        /*
         * 用户注册接口
         * */
//        return $auth->createUser([
//            'name' => 123456,
//            'username' => '123456',
//            'password' => bcrypt( '123456'),
//        ]);
        /*
         * 用户绑定
         * */
//        return $auth->socialBind(6,'omJqpvxhQvQKdzV8uAkQqj3bV6px','weixin');
        /*
         * 用户第三方授权注册绑定
         * */
        return $auth->socialLogin('omJqpvxhQvQKdzV8uAkQqj3bV6p4','weixin');
    }
}
