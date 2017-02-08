<?php

/**
 * Frontend Access Controllers
 */
Route::group(['namespace' => 'Auth'], function () {


    /**
     * These routes require the user NOT be logged in
     */
    Route::group(['middleware' => 'guest'], function () {
        // Authentication Routes
        Route::get('login', 'AuthController@showLoginForm')
            ->name('manage.login');
        Route::post('login', 'AuthController@login');

        // Socialite Routes
        Route::get('login/{provider}', 'AuthController@loginThirdParty')
            ->name('manage.provider');

        // Registration Routes
//        Route::get('register', 'AuthController@showRegistrationForm')
//            ->name('auth.register');
//        Route::post('register', 'AuthController@register');

        // Confirm Account Routes
//        Route::get('account/confirm/{token}', 'AuthController@confirmAccount')
//            ->name('account.confirm');
//        Route::get('account/confirm/resend/{token}', 'AuthController@resendConfirmationEmail')
//            ->name('account.confirm.resend');

        // Password Reset Routes
        Route::get('password/reset/{token?}', 'PasswordController@showResetForm')
            ->name('manage.password.reset');
        Route::post('password/email', 'PasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'PasswordController@reset');
    });

//    Route::auth();
//    Route::any('/', 'AuthController@login')->name('manage.login');
//    Route::get('login', 'AuthController@login')->name('manage.login');
    Route::any('logout', 'AuthController@logout')->name('manage.logout');
//    Route::get('/home', 'HomeController@index');
});