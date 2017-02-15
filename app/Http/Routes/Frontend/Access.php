<?php

/**
 * Frontend Access Controllers
 */
Route::group(['prefix' => 'member','namespace' => 'Auth'], function () {


    /**
     * These routes require the user NOT be logged in
     */


      Route::get('login', 'AuthController@showLoginForm')->name('member.login');
      Route::post('login', 'AuthController@login');
      Route::any('logout', 'AuthController@logout')->name('member.logout');

    // Registration Routes...
      Route::get('register', 'AuthController@showRegistrationForm')->name('member.register');
      Route::post('register', 'AuthController@register');

    // Password Reset Routes
    Route::get('password/reset/{token?}', 'PasswordController@showResetForm')
        ->name('member.password.reset');
    Route::post('password/email', 'PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'PasswordController@reset');

//    Route::get('auth/{driver}', 'AuthController@redirectToProvider')->name('manage.provider');
    Route::get('login/{provider}', 'AuthController@redirectToProvider')
        ->name('manage.provider');

    Route::get('login/{driver}/callback', 'AuthController@handleProviderCallback');
});