<?php
use App\Util\ResponseUtil;
use App\Core\Facades\FileUploadService;
Route::group(['middleware' => 'web'], function() {
    /**
     * Switch between the included languages
     */
    Route::group(['namespace' => 'Language'], function () {
        require (__DIR__ . '/Routes/Language/Language.php');
    });

    /**
     * Frontend Routes
     * Namespaces indicate folder structure
     */
    Route::group(['namespace' => 'Frontend'], function () {
        require (__DIR__ . '/Routes/Frontend/Frontend.php');
        require (__DIR__ . '/Routes/Frontend/Access.php');
    });
});


/*********************测试内容**************************/
Route::post('foo', function () {
    return response(['123',456,121], '302');
});

Route::get('showupload', function () {
    return view('uploadfile');
});

Route::post('upload', function (\Illuminate\Http\Request $request) {

    $file=$request->file('test');
    if($request->hasFile('test') && ($file=$request->file('test')) && $file->isValid()) {
        if($file->getSize() > 2 * 1024 * 1024) {
            return ResponseUtil::error(400, '', ResponseUtil::ERROR_CODE_20003);
        }
        //$fileUri = FileUploadService::upload($file->getRealPath(), $file->getClientOriginalExtension());
        $fileDir= str_replace(['\\','%5c','&#92','//'],'/',time());
        if(!file_exists($fileDir))
            mkdir($fileDir, 0777, true);

        $uuid = '11';
        $key = str_replace('-','',$uuid).('txtt' ? '.'.'txtt': '');


        $data=[
            'file_name' => $file->getClientOriginalName(),
            'file_ext' =>  $file->getClientOriginalExtension(),
            'file_size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
        ];
        return ResponseUtil::success($data,403);
    }else {
        return ResponseUtil::error(ResponseUtil::CODE_REQUEST_INVALID, '', 400);
    }
    dd($res);
});
/*********************测试内容**************************/


/**
 * Backend Routes
 * Namespaces indicate folder structure
 * Admin middleware groups web, auth, and routeNeedsPermission
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    /**
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    require (__DIR__ . '/Routes/Backend/Dashboard.php');
    require (__DIR__ . '/Routes/Backend/Access.php');
    require (__DIR__ . '/Routes/Backend/LogViewer.php');
});
