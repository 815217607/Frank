<?php
 /**
 * User: fuqixue1987@163.com
 */

namespace App\Core\Services;

use App\Models\LeanCloud;

use Illuminate\Support\Facades\Log;
use LeanCloud\LeanClient;
use LeanCloud\LeanPush;

class LeanCloudServiceImpl
   {
    private $app_id;
    private $app_key;
    private $master_key;
    private $leanpush;
    public function __construct() {

        $this->app_id = C('LEANCLOUD_APP_ID');
        $this->app_key = C('LEANCLOUD_APP_KEY');
        $this->master_key = C('LEANCLOUD_MASTER_KEY');
        LeanClient::initialize($this->app_id, $this->app_key, $this->master_key);
        $this->leanpush=new LeanPush();
    }

    /**
     * 推送
     * @param $params
     * @param bool|false $falg
     * @return array
     */
    public function LeanCloudPush($params,$filed='user_id',$falg=false){

        $this->leanpush->setOption('prod','dev');
        $this->leanpush->setExpirationInterval(60);
        $this->leanpush->setData('alert',$params['title']);
        $this->leanpush->setData('action','com.avos.UPDATE_STATUS');
        $this->leanpush->setData('where',[$filed=>$params[$filed]]);
        if(isset($params['data'])&&is_array($params['data'])){
            foreach($params['data'] as $key=> $val){
                $this->leanpush->setData($key,$val);
            }
        }
        if(C('LEANCLOUD_PROD_FLAG',$falg))
            $this->leanpush->setOption('prod','prod');
        else
            $this->leanpush->setOption('prod','dev');

        $info=$this->leanpush->send();
        Log::info($info);
        return  $info;
    }
    public function leanPushTest($params,$falg=true){
//        $leanpush=new LeanPush();
//        $leanpush->setExpirationInterval(60);
//        $leanpush->setData('alert',$params['title']);
//        $leanpush->setData('action','com.avos.UPDATE_STATUS');
//        $leanpush->setData('model',$params['model']);
//        $leanpush->setData('where',['user_id'=>$params['user_id']]);
//        if($falg)
//            $leanpush->setOption('prod','prod');
//        else
//            $leanpush->setOption('prod','dev');
//        return  $leanpush->send();



        //        $leanpush=new LeanPush();
        $this->leanpush->setExpirationInterval(60);
        $this->leanpush->setData('alert',$params['title']);
        $this->leanpush->setData('action','com.avos.UPDATE_STATUS');
        $this->leanpush->setData('model',$params['model']);
        $this->leanpush->setData('where',['user_id'=>$params['user_id']]);
        if($falg)
            $this->leanpush->setOption('prod','prod');
        else
            $this->leanpush->setOption('prod','dev');
        return  $this->leanpush->send();
    }
   }