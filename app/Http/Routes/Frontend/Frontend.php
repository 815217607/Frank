<?php

/**
 * Frontend Controllers
 */

Route::get('macros', 'FrontendController@macros')->name('frontend.macros');
Route::get('/', 'FrontendController@index')->name('frontend.index');
Route::get('/test', 'FrontendController@test')->name('frontend.test');
/**
 * These frontend controllers require the user to be logged in
 */
Route::group(['middleware' => 'member_auth'], function () {

    Route::group(['namespace' => 'User'], function() {
        Route::get('dashboard', 'DashboardController@index')->name('frontend.user.dashboard');
        Route::get('profile/edit', 'ProfileController@edit')->name('frontend.user.profile.edit');
        Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
    });
});