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
   });
});
