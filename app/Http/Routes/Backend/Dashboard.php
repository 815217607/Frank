<?php
//Route::get('/',function(){
//    return redirect()->to(route('admin.dashboard'));
//});

Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');