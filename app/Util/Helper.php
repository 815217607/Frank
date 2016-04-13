<?php
/**
 * Created by PhpStorm.
 * User: liaoyong
 * Date: 15/10/13
 * Time: 22:55
 */

namespace App\Util;

use Illuminate\Support\Facades\URL;
use DB;

class Helper{
    
    const TABLE_PREFIX = 'cf_';

    public static function page($sql,$page_index=1,$page_size=20){
        $page_index = intval($page_index) < 1 ? 1 : intval($page_index);
        $page_size = intval($page_size) < 0 ? 20 : intval($page_size);
        $tmp_sql="select count(*) as num1 from ($sql) as tmp";
        $rows_all_lists = DB::select($tmp_sql);
        $rows_all = intval($rows_all_lists[0]->num1);
        if($rows_all<=0){
            return array(
                'page_index'=>1,
                'page_count'=>1,
                'page_datas'=>array(),
                'page_size'=>$page_size,
            );
        }
        $page_count = ceil($rows_all / $page_size);
        $page_index = $page_index > $page_count ? $page_count : $page_index;
        $limit = " limit ".($page_index-1)*$page_size.",$page_size";
        $lists = DB::select($sql.$limit);
        return array(
                'page_index'=>$page_index,
                'page_count'=>$page_count,
                'page_datas'=>$lists,
                'page_size'=>$page_size,
        );
    }

    public static function table($table_name){
        return self::TABLE_PREFIX.$table_name;
    }

    public static function build_page_str($datas,$url){
        $query = $_GET;
        if(isset($query['page'])){
            unset($query['page']);
        }
        if(count($query)>0){
            $query_str = $url."?".http_build_query($query).'&page=';
        }else{
            $query_str = "$url?page=";
        }
        $page_str = array("<div class='pagers'>");
        $page_index = intval($datas['page_index']);
        $page_count = intval($datas['page_count']);
        if($page_count<=10){
            for($i=1;$i<=$page_count;$i++){
                $href="{$query_str}{$i}";
                $btn_class = "page-btn";
                if($i==$page_index){
                    $href="javascript:;";
                    $btn_class="page-current";
                }
                $page_str[]="<a class='{$btn_class}' href='$href'>{$i}</a>";
            }
            $page_str[]="</div>";
            return implode("\r\n", $page_str);
        }else{
            if($page_index==1){
                $page_str[] = "<a class='page-btn' href='javascript:;'>上一页</a>";
            }else{
                $prev_href="{$query_str}".($page_index-1);
                $page_str[] = "<a class='page-btn' href='$prev_href'>上一页</a>";
            }
            $start = $page_index-5;
            $end = $page_index + 5;
            if($start<=1){
                $start = 1;$end = 10;
            }
            if($end>=$page_count){
                $start = $page_count - 10;
                $end = $page_count;
            }
            for($i=$start;$i<=$end;$i++){
                $href="{$query_str}{$i}";
                $btn_class = "page-btn";
                if($i==$page_index){
                    $href="javascript:;";
                    $btn_class="page-current";
                }
                $page_str[]="<a class='{$btn_class}' href='$href'>{$i}</a>";
            }
            if($page_index==$page_count){
                $page_str[] = "<a class='page-btn' href='javascript:;'>下一页</a>";
            }else{
                $prev_href="{$query_str}".($page_index+1);
                $page_str[] = "<a class='page-btn' href='$prev_href'>下一页</a>";
            }
            $page_str[]="</div>";
            return implode("\r\n", $page_str);
        }
    }

    public static function  Get($key){
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    public static function Post($key){
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
    
    public static function redirect($msg,$url=null){
        if(!$url){
            if(isset($_SERVER['HTTP_REFERER'])){
                $redirect = "window.location.href='".$_SERVER['HTTP_REFERER']."'";
            }else{
                $redirect="window.history.back()";
            }
        }else{
            $redirect="window.location.href='$url'";
        }
        exit("<meta charset='UTF-8'><script>alert('{$msg}');$redirect;</script>");
    }

    public static function getUploadExt($type='image'){
        static $__types = array(
            'image'=>array('jpg','jpeg','bmp','png','gif'),
        );
        return isset($__types[$type]) ? $__types[$type] : array();
    }

    //前台提示内容。。。。
    public static function error_msg($msg,$url){
        exit("<meta charset='UTF-8'><script>alert('{$msg}');window.location.href='{$url}';</script>");
    }
}