<?php

Route::group([
    'namespace'  => 'auth',
    'middleware' => ['web'],
], function () {
    // Authentication Routes
    Route::get('login', 'AuthController@showLoginForm')
        ->name('admin.login');
    Route::post('login', 'AuthController@login');


});
