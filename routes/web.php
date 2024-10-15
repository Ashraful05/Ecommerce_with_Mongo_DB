<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CmsController;

Route::get('/', function () {
    return view('welcome');
//    return view('admin.layout.home');
});

//all admin routes.....

Route::prefix('admin')->group(function (){
//   Route::get('login','logIn')->name('admin.login');
    Route::controller(AdminController::class)->group(function(){
        Route::match(['get','post'],'login','logIn')->name('admin.login');
        Route::middleware('admin')->group(function (){
            Route::get('dashboard','index')->name('admin.home');
            Route::get('logout','logout')->name('admin.logout');

            Route::match(['get','post'],'update_password','updatePassword')->name('update.password');
            Route::post('password/check/ajax','passwordCheckUsingAjax')->name('check_current_password_using_ajax');

            Route::match(['get','post'],'update_details','updateAdminDetails')->name('update.admin.details');
            Route::get('subadmins',[AdminController::class,'subAdmin'])->name('subadmins');
            Route::post('update_sub_admin_page_status',[AdminController::class,'updateSubAdminPageStatus']);
            Route::delete('subadmin/delete/{id}',[AdminController::class,'deleteSubAdmin'])->name('subadmin.delete');
//            Route::match(['get','post'],'add/edit/subadmin/{id?}',[AdminController::class,'addEditSubAdmin'])->name('add.edit.subadmin');
            Route::get('add/subadmin',[AdminController::class,'addSubAdmin'])->name('add.sub.admin');
            Route::post('save/subadmin',[AdminController::class,'saveSubAdmin'])->name('save.sub.admin');
            Route::get('edit/subadmin/{id}',[AdminController::class,'editSubAdmin'])->name('edit.sub.admin');
            Route::post('update/subadmin/{id}',[AdminController::class,'updateSubAdminData'])->name('update.sub.admin');
    });

        Route::middleware('admin')->group(function(){
            Route::resource('cmsPage',CmsController::class);
            Route::post('update_cms_page_status',[CmsController::class,'updateCmsPageStatus']);
        });

   });


});
