<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
//    return view('admin.layout.home');
});

//all admin routes.....

Route::controller(AdminController::class)->prefix('admin')->group(function (){
//   Route::get('login','logIn')->name('admin.login');
   Route::match(['get','post'],'login','logIn')->name('admin.login');
   Route::middleware('admin')->group(function (){
       Route::get('dashboard','index')->name('admin.home');
       Route::get('logout','logout')->name('admin.logout');

       Route::match(['get','post'],'update_password','updatePassword')->name('update.password');
       Route::post('password/check/ajax','passwordCheckUsingAjax')->name('check_current_password_using_ajax');

       Route::match(['get','post'],'update_details','updateAdminDetails')->name('update.admin.details');
   });

});
