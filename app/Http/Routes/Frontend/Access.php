<?php

/**
 * Frontend Access Controllers
 */
Route::group(['prefix' => 'member','namespace' => 'Auth'], function () {


    /**
     * These routes require the user NOT be logged in
     */

//    Route::auth();
//    Route::any('/', 'AuthController@login')->name('manage.login');
      Route::get('login', 'AuthController@showLoginForm')->name('member.login');
      Route::post('login', 'AuthController@login');
      Route::any('logout', 'AuthController@logout')->name('member.logout');

    // Registration Routes...
    Route::get('register', 'AuthController@showRegistrationForm')->name('member.register');
    Route::post('register', 'AuthController@register');
});