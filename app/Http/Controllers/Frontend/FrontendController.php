<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use Auth;
use Eyuan\Payment\Wechat\Models\PaymentOrderModel;
use Eyuan\Payment\Wechat\Payment;
use Illuminate\Support\Facades\DB;


/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    public function __construct()
    {
        $this->middleware('member_auth:member'
            , ['except' => 'index']
        );
    }
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

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

        return view('frontend.macros');
    }


    public function test(){
//        $auth=AuthExtend::getInstance();
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
//        return $auth->socialLogin('omJqpvxhQvQKdzV8uAkQqj3bV6p4','weixin');

        /*
         *微信测试
         */
        $order=[
            'user_id'=>6,
            'product_id'=>62,
            'order_no'=>'TC'.time(),
            'order_name'=>'测试支付1元',
            'price'=>'1',
            'product_type'=>'1',
            'payment_platform'=>'1',
        ];
        $send=Payment::getInstance();

        $info=$send->createOrder($order,'/','/');

      return view(($info?'frontend.payment.success':'frontend.pay_error'),$info);

    }
}
