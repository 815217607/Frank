<?php
/**
 * User: yang163_yang@hotmail.com
 * Date: 15/7/17
 * Time: 16:03
 */

namespace App\Http\Controllers;


use App\Core\Facades\FileUploadService;
use App\Core\Facades\LeanCloudService;
use App\Http\Controllers\Controller;
use App\Util\ResponseUtil;
use Exception;
use Faker\Provider\Image;
use Illuminate\Http\Request;

class CommonController extends Controller {

    public function __construct() {
        $this->middleware('app_user_auth', [
            'only' => ['uploadFile']
        ]);
    }

    public function uploadFile(Request $request) {
        /**
         * @var \Symfony\Component\HttpFoundation\File\UploadedFile $file
         */

        if($request->hasFile('file') && ($file=$request->file('file')) && $file->isValid()) {
            if($file->getSize() > 2 * 1024 * 1024) {
                return ResponseUtil::error(400, '', ResponseUtil::ERROR_CODE_20003);
            }

            $fileUri = FileUploadService::upload($file->getRealPath(), $file->getClientOriginalExtension());
            $data=[
                'file_name' => $file->getClientOriginalName(),
                'file_ext' =>  $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType(),
                'uri' => asset($fileUri)
            ];
            return ResponseUtil::success($data);
        }else {
            return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 400);
        }
    }

    public function uploadImage(Request $request) {
        if($request->user==null) {
            return ResponseUtil::error(ResponseUtil::CODE_AUTH_FAIL, '', 401);
        }
        /**
         * @var \Intervention\Image\Image $image
         */
        if($request->hasFile('file') && ($file=$request->file('file')) && $file->isValid()) {
            if($file->getSize() > 2 * 1024 * 1024) {
                return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 200001);
            }
            Image::configure(array('driver' => 'imagick'));
            try {
                $image = Image::make($file);
            }catch(Exception $e) {
                return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID,'', 200002);
            }
            $ext = $file->getClientOriginalExtension();
            $ret = [
                'origin' => FileUploadService::upload($file->getRealPath(), $ext)
            ];
            $originWidth = $image->getWidth();
            $originHeight = $image->getHeight();


            $widthArray = $request->get('width',[]);
            $heightArray = $request->get('height',[]);
            if(!is_array($widthArray) || !is_array($heightArray) || count($widthArray)!=count($heightArray)) {
                return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 400);
            }
            $image->backup();
            $resized = [];
            foreach($widthArray as $i=>$width) {
                $height = isset($heightArray[$i]) ? $heightArray[$i] : null;
                if(!is_numeric($width) || !is_numeric($height) || $width<1 || $height<1) {
                    return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 200003);
                }
                $width = $width < $originWidth ? $width : $originWidth;
                $height = $height < $originHeight ? $height : $originHeight;
                $tempPath = tempnam(sys_get_temp_dir(),'img');
                $image->resize($width, $height)->save($tempPath);
                $resized[] = FileUploadService::upload($tempPath, $ext);
            }
            $ret['resized'] = $resized;
            return ResponseUtil::success($ret);

        }else {
            return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 400);
        }
    }



    public function KindEditorUploadFile(Request $request) {
        /**
         * @var \Symfony\Component\HttpFoundation\File\UploadedFile $file
         */
        if($request->hasFile('imgFile') && ($file=$request->file('imgFile')) && $file->isValid()) {
            if($file->getSize() > 20 * 1024 * 1024) {
                return ResponseUtil::error(400, '', ResponseUtil::ERROR_CODE_20003);
            }

            $data=[
                'file_name' => $file->getClientOriginalName(),
                'title' => $file->getClientOriginalName(),
                'file_ext' =>  $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getClientMimeType()
            ];
            $fileUri = FileUploadService::KindEditorUpload($file->getRealPath(), $file->getClientOriginalExtension());
            $data['url']=asset($fileUri);
            $data['error']=0;

            return ResponseUtil::success($data);
        }else {
            return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 400);
        }
    }


    /**
     * 测试推送
     */
    public function TestPush(){
        return  LeanCloudService::leanPushTest(['user_id'=>37,'model'=>'schedule','title'=>"测试推送"]);
    }
}
