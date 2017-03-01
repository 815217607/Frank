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


Route::post('payment/alipay_callback',function(){
    $pay=\Eyuan\Wexin\Pay\WechatService::getInstance();
   return $pay->callback();
});


Route::get('payment/wechat_callback/{tag}','FrontendController@payCallback');

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
    require (__DIR__ . '/Routes/Backend/Auth.php');


});


