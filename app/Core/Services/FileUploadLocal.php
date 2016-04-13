<?php
/**
 * User: yang163_yang@hotmail.com
 * Date: 15/7/17
 * Time: 18:35
 */

namespace App\Core\Services;


use Carbon\Carbon;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webpatser\Uuid\Uuid;

class FileUploadLocal {

    public function upload($filePath, $ext) {
        $destDir = 'uploads'.DIRECTORY_SEPARATOR.Carbon::create()->format('ymd');
        $fileDir = App::publicPath().DIRECTORY_SEPARATOR.$destDir;
        if(!file_exists($fileDir))
            mkdir($fileDir, 0777, true);

        $uuid = Uuid::generate();
        $key = str_replace('-','',$uuid).($ext ? '.'.$ext: '');
        copy($filePath, $fileDir.DIRECTORY_SEPARATOR.$key);
//        return Request::getSchemeAndHttpHost().'/'.$destDir.'/'.$key;
        return '/'.$destDir.'/'.$key;
    }

    public function KindEditorUpload($filePath, $ext) {
        $destDir = 'uploads'.DIRECTORY_SEPARATOR.Carbon::create()->format('Ymd');
        $fileDir = App::publicPath().DIRECTORY_SEPARATOR.$destDir;
        if(!file_exists($fileDir))
            mkdir($fileDir, 0777, true);

        $uuid = Uuid::generate();
        $key = str_replace('-','',$uuid).($ext ? '.'.$ext: '');
        copy($filePath, $fileDir.DIRECTORY_SEPARATOR.$key);
//        return Request::getSchemeAndHttpHost().'/'.$destDir.'/'.$key;
        return '/'.$destDir.'/'.$key;
    }

}
