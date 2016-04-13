<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 15/10/13
 * Time: 22:55
 */

namespace App\Util;

use Illuminate\Support\Facades\URL;

class Util
{

    public static function generate_str($length = 8,$chars='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789')
    {
        $strs = '';
        for ($i = 0; $i < $length; $i++) {
            $strs .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $strs;
    }

    public static function valid_email($address) 
    {
    		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? FALSE : TRUE;
    }

    public static function generate_orderSn(){
        $sn1 = date("ymd");
        $sn2 = '0' . '00';
        $sn3 = self::generate_str(7,'0123456789');//7位随机数
        return $sn1 . $sn2 . $sn3;
    }


   public static function createFolder($path, $chmod = 777) {
        if (!file_exists($path)) {
            self::createFolder(dirname($path));
            @mkdir($path);
            @chmod($path, $chmod);
        }
    }

    /**
     * 获取自定义扩展配置
     * @param string $key
     * @return string
     */
public static function C($key = '') {
        $info = app('config')->get('extent_conf');
        return empty($info[$key]) ? '' : $info[$key];
    }

    /**
     * 创建写入并创建文件
     * @param $path
     * @param $str
     */
    public static function create_file($path, $str) {
        if (!file_exists($path)) {
            $service_file = fopen($path, "w") or die("Unable to open file!");
            fwrite($service_file, $str);
            fclose($service_file);
        }
    }

    /**
     * 根据模板文件生成新文件
     * @param $file
     * @param $newfile
     * @param $name
     * @return bool
     */
    public static function file_replace($file, $newfile, $name, $home = '', $lname = '') {
        $data = file_get_contents($file);
        $lname=strtolower(str_replace('/','.',$home)).'.'.$lname;
        $home=str_replace('/','\\',$home);
        $info = str_replace(array('{name}', '{home}', '{lname}'), array($name, $home, $lname), $data);
        return self::create_file($newfile, $info) ? true : false;
    }

    /**
     * 统一返回成功信息
     * @param $data
     * @param $code
     * @param $msg
     * @param bool|false $json
     * @return array|string
     */
    public static function success($data=[], $code = 1, $msg = '成功！', $json = false,$url='') {
        if($code==1)
            $info=['info' => $data,'code' => $code,'msg'=>$msg,'url'=>$url];
        else{
            $info = ['info' => $data,'code' => $code, 'msg' =>trans('msg.' . $code),'url'=>$url];
        }
//    $info = ['info' => $data, 'code' => $code, 'msg' => !empty(trans('global_error.' . $code)) ? trans('global_error.' . $code) : $msg];
        return $json ? json_encode($info) : $info;
    }

    /**
     * 统一返回错误信息
     * @param $code
     * @param $msg
     * @param bool|false $json
     * @return array|string
     */
    public static function error($code = 0, $msg = '失败！', $json = false,$url='') {

        if(!$code)
            $info=['code' => $code,'msg'=>$msg,'url'=>$url];
        else{
            $info = ['code' => $code, 'msg' => trans('msg.' . $code),'url'=>$url];
        }
        return $json ? json_encode($info) : $info;
    }

    /**
     * 返回格式化后的时间
     * @return bool|string
     */
    public static function created_times() {
        return date("Y-m-d H:i:s", time());
    }

    /**
     * POST请求
     * @param $url
     * @param $params
     * @return mixed
     */
    public static function curl_post($url, $params = [], $times = 30) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
//    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // Post提交的数据包
//    curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息
        curl_setopt($curl, CURLOPT_TIMEOUT, $times); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
//    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $info = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }
        curl_close($curl);
        return $info;
    }

    /**
     * GET  请求
     * @param $url
     * @param $params
     * @return mixed
     */
    public static  function curl_get($url, $params = [], $times = 30) {

        $url = empty($params) ? $url : $url . '?' . http_build_query($params, '&');
        //初始化
        $curl = curl_init();

        //设置选项，包括URL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, $times);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //执行并获取HTML文档内容
        $info = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl);
        }
        //释放curl句柄
        curl_close($curl);
        return $info;
    }

    /**
     * 百度距离计算
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @return float
     */
    public static function BD_Distance($oldgeo, $newgeo) {
        $IN_MATER = 6378137;
        //将角度转为狐度
        $radLat1 = deg2rad($oldgeo[1]);
        $radLat2 = deg2rad($newgeo[1]);
        $radLng1 = deg2rad($oldgeo[0]);
        $radLng2 = deg2rad($newgeo[0]);

        //结果
        $s = acos(cos($radLat1) * cos($radLat2) * cos($radLng1 - $radLng2) + sin($radLat1) * sin($radLat2)) * $IN_MATER;

        return round($s);
    }

    /**
     * 1、键值自然排序
     * 2、转大写
     * 3、拼接app_key
     * 4、MD5
     * @param $pa
     * @return bool
     */
    public static function encryption_check($params, $key = false) {
        ksort($params);
        $data = strtoupper(md5(strtoupper(str_replace('&', '', http_build_query($params))) . 'App_key=' . env('APP_KEY')));
        if (!$key) {
            return $data;
        } else {
            return $key === $data ? true : false;
        }
    }

    public static function data_remove_pid($data, $pid = 0) {
        $info = array();
        foreach ($data as $key => $val) {
            $info[] = array('text' => $val['name'], 'id' => $val['id'], 'pid' => $val['pid'], 'state' => array('opened' => true, 'selected' => false));
        }
        return $info;
    }

    /**
     * 数组根据父id生成树
     * @staticvar int $depth 递归深度
     * @param array $data 数组数据
     * @param integer $pid 父id的值
     * @param string $key id在$data数组中的键值
     * @param string $chrildKey 要生成的子的键值
     * @param string $pKey 父id在$data数组中的键值
     * @param int $maxDepth 最大递归深度，防止无限递归
     * @return array 重组后的数组
     */
    public static function array_to_tree($sourceArr, $key, $parentKey, $childrenKey) {
        $tempSrcArr = array();

        $allRoot = TRUE;
        foreach ($sourceArr as $v) {
            $isLeaf = TRUE;
            foreach ($sourceArr as $cv) {
                if (($v[$key]) != $cv[$key]) {
                    if ($v[$key] == $cv[$parentKey]) {
                        $isLeaf = FALSE;
                    }
                    if ($v[$parentKey] == $cv[$key]) {
                        $allRoot = FALSE;
                    }
                }
            }
            if ($isLeaf) {
                $leafArr[$v[$key]] = $v;
            }
            $tempSrcArr[$v[$key]] = $v;
        }
        if ($allRoot) {
            return $tempSrcArr;
        } else {
            unset($v, $cv, $sourceArr, $isLeaf);
            foreach ($leafArr as $v) {
                if (isset($tempSrcArr[$v[$parentKey]])) {
                    $tempSrcArr[$v[$parentKey]][$childrenKey] = (isset($tempSrcArr[$v[$parentKey]][$childrenKey]) && is_array($tempSrcArr[$v[$parentKey]][$childrenKey])) ? $tempSrcArr[$v[$parentKey]][$childrenKey] : array();
                    array_push($tempSrcArr[$v[$parentKey]][$childrenKey], $v);
                    unset($tempSrcArr[$v[$key]]);
                }
            }
            unset($v);
            return self::array_to_tree($tempSrcArr, $key, $parentKey, $childrenKey);
        }
    }

    public static function Json_from_obj_arr($data, $key = 'name', $val = 'value') {
        $info = [];
        foreach ($data as $k => $v) {
            $info[] = array($k[$key] => $v[$val]);
        }
        return $info;
    }

    /**
     * 上传图片
     * @param String $base_str
     * @param String $path
     * @return String
     */
    public static function upload_image($base_str, $path) {
        if (!$base_str) {
            return '';
        }

        $exp = explode('/', explode(';', $base_str)[0])[1];
        $file_name = str_random(6) . '_' . date("Y-m-d-His", time()) . '.' . $exp;
        self::createFolder(public_path() . $path);
        $file_path = public_path() . $path . $file_name;
        $img_data = base64_decode(str_replace('data:image/png;base64,', '', $base_str));
        file_put_contents($file_path, $img_data);

        return asset($path . $file_name);
    }

    /**
     * 2个时间间隔
     *
     * @param date $start_time
     * @param date $end_time
     */
    public static function date_between($start_time, $end_time) {

        if($end_time <= $start_time) {
            return 0;
        }
        return floor((strtotime($end_time) - strtotime($start_time)) / 86400);
    }


    //*****************************************************************//
    //函数名:myreaddir($dir)
    //作用:读取目录所有的文件名
    //参数:$dir 目录地址
    //返回值:文件名数组
    //*****************************************************************//
    public static function myreaddir($dir) {
        $handle=opendir($dir);
        $i=0;
        while($file=readdir($handle)) {
            if (($file!=".")and($file!="..")) {
                $list[$i]=$file;
                $i=$i+1;
            }
        }
        closedir($handle);
        return $list;
    }


}