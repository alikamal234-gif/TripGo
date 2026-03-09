<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PassengerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function (){
    Route::get('/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
});

Route::prefix('passenger')->group(function (){
    Route::get('/dashboard',[DriverController::class,'index'])->name('passenger.dashboard');
});

Route::prefix('driver')->group(function (){
    Route::get('/dashboard',[PassengerController::class,'index'])->name('driver.dashboard');
});

include "auth.php";