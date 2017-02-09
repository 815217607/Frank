<?php

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
    Route::get('logout', 'AuthController@logout') ->name('admin.logout');

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
