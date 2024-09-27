<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    return view('welcome');
    return view('admin.layout.home');
});
