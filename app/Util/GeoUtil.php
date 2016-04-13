<?php
/**
 * User: yang163_yang@hotmail.com
 * Date: 15/7/15
 * Time: 14:44
 */

namespace App\Util;


class GeoUtil {

    const EARTH_RADIUS_IN_MILE = 3963.2;
    const EARTH_RADIUS_IN_METER = 6378137;
    const BAIDU_AK = 'PjAbF8vG3Ka8ecSVsYoa0QoA';

    /**
     * 英里转换成米
     * @param $miles
     * @return float
     */
    public static function convertMileToMeter($miles) {
        return 1.60931 * $miles * 1000;
    }

    /**
     * 米转换成英里
     * @param $meters
     * @return float
     */
    public static function convertMeterToMile($meters) {
        return $meters/1.60931/1000;
    }

    /**
     * 两点间坐标距离计算
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @return float
     */
    public static function getDistance($lng1,$lat1,$lng2,$lat2) {
        //将角度转为狐度
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);

        //结果
        $s = acos(cos($radLat1)*cos($radLat2)*cos($radLng1-$radLng2)+sin($radLat1)*sin($radLat2))*self::EARTH_RADIUS_IN_METER;

        return  round($s);
    }
    /**
     * 百度坐标系转换成标准GPS坐系
     *
     * @param float $lnglat
     *            坐标(如:106.426, 29.553404)
     * @return string 转换后的标准GPS值:
     */
    public static function BD09LLtoWGS84($fLng,$fLat){ // 经度,纬度

        $Baidu_Server="http://api.map.baidu.com/ag/coord/convert?from=0&to=4&x={$fLng}&y={$fLat}";
        $result=@file_get_contents($Baidu_Server);
        $json=json_decode($result);
        if($json->error==0){
            $bx=base64_decode($json->x);
            $by=base64_decode($json->y);
            $GPS_x=2*$fLng-$bx;
            $GPS_y=2*$fLat-$by;
            return array('lng'=>$GPS_x,'Lat'=>$GPS_y); // 经度,纬度
        }else
            return array('lng'=>$fLng,'Lat'=>$fLat);
    }

    /**
     * 百度地址解析接口(根据详细地址找坐标)
     * **/
    public static function badumapaddress($adr){
        $priont=false;
        if(!empty($adr)){
            $Baidu_Server="http://api.map.baidu.com/geocoder/v2/?address=".$adr."&output=json&ak=".self::BAIDU_AK;
            $priont=@file_get_contents($Baidu_Server);
        }
        return $priont;
    }
}
