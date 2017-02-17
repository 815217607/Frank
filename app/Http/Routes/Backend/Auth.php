<?php

Route::group([
    'namespace'  => 'Auth',
    'middleware' => ['web'],
], function () {
    // Authentication Routes
    Route::get('login', 'AuthController@showLoginForm')
        ->name('admin.login');
    Route::post('login', 'AuthController@login');

    Route::get('logout', 'AuthController@logout') ->name('admin.logout');

//    Route::get('auth/{driver}', 'AuthController@redirectToProvider')->name('manage.provider');
    Route::get('login/{provider}', 'AuthController@loginThirdParty')
        ->name('admin.provider');

    Route::get('login/{driver}/callback', 'AuthController@handleProviderCallback');
});
