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
Route::group(['prefix' => 'admin','namespace' => 'Backend'], function () {

    /**
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
//    require (__DIR__ . '/Routes/Backend/Dashboard.php');


//    Route::any('/', 'AuthController@login')->name('manage.login');
//    Route::any('login', 'AuthController@login')->name('manage.login');
//    Route::any('logout', 'AuthController@logout')->name('manage.logout');
    /**
     * Menu Auth
     */
//    Route::group(['prefix' => 'auth','namespace' => 'Auth','middleware' => 'web'], function() {

//        Route::get('login', 'AuthController@login')->name('auth.login');
//        Route::get('/123', function(){
//            echo '13';
//        });
//        Route::any('logout', 'AuthController@logout');
//        Route::any('register', 'AuthController@register');
//    });

    Route::group([
        'middleware' =>['admin']
        ],
        function(){
        Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
        require (__DIR__ . '/Routes/Backend/Access.php');
        require (__DIR__ . '/Routes/Backend/LogViewer.php');

    });

    /**
     * These routes require the user NOT be logged in
     */
    Route::group([
        'namespace'  => 'auth',
        'middleware' => ['web'],
    ], function () {
        // Authentication Routes
        Route::get('login', 'AuthController@showLoginForm')
            ->name('admin.login');
        Route::post('login', 'AuthController@login');

        // Socialite Routes
        Route::get('login/{provider}', 'AuthController@loginThirdParty')
            ->name('login.provider');
        Route::get('logout', 'AuthController@logout');

        // Confirm Account Routes
        Route::get('account/confirm/{token}', 'AuthController@confirmAccount')
            ->name('admin.account.confirm');
        Route::get('account/confirm/resend/{token}', 'AuthController@resendConfirmationEmail')
            ->name('admin.account.confirm.resend');

        // Password Reset Routes
        Route::get('password/reset/{token?}', 'PasswordController@showResetForm')
            ->name('admin.password.reset');
        Route::post('password/email', 'PasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'PasswordController@reset');
    });

});


