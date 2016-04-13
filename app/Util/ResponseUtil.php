<?php
/**
 * User: yang163_yang@hotmail.com
 * Date: 15/7/1
 * Time: 15:32
 */

namespace App\Util;


class ResponseUtil {

    const CODE_REQUEST_INVALID = 400;
    const CODE_AUTH_FAIL = 401;
    const CODE_NO_PRIVILEGE = 403;
    const CODE_RESOURCE_NOT_FOUND = 404;
    const CODE_INTERNAL_ERROR = 500;

    const ERROR_CODE_400 = 400;//参数错误
    const ERROR_CODE_404 = 404;//资源无法找到
    const ERROR_CODE_500 = 500;//操作失败, 请稍后再试

    const ERROR_CODE_10000 = 10000;//验证码错误
    const ERROR_CODE_10001 = 10001;//密码必须为4-20个字符
    const ERROR_CODE_10002 = 10002;//用户名或密码错误
    const ERROR_CODE_10003 = 10003;//手机号已被注册
    const ERROR_CODE_10004 = 10004;//旧密码输入错误
    const ERROR_CODE_10005 = 10005;//两次输入密码不一致
    const ERROR_CODE_10006 = 10006;//非律师用户

    const ERROR_CODE_20000 = 20000;//你不在项目组中
    const ERROR_CODE_20001 = 20001;//目标用户没有找到
    const ERROR_CODE_20002 = 20002;//用户已经在项目中
    const ERROR_CODE_20003 = 20003;//文件太大
    const ERROR_CODE_30001 = 30001;//已签到

    public static function success($data='', $statusCode=200, $headers=[]) {
        return response($data, $statusCode, $headers);
    }

    public static function error($statusCode, $msg='',$errorCode=0, $errors=[], $headers=[]) {
        if(!$msg) {
            $msg = trans('global_error.'.$errorCode);
        }
        return response([
            'msg' => $msg ? $msg : '',
            'error_code' => $errorCode,
            'errors' => $errors
        ], $statusCode, $headers);
    }

}
