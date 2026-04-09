<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function (){
    Route::get('/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
});

Route::prefix('driver')->middleware('auth')->group(function (){
    Route::get('/dashboard',[DriverController::class,'index'])->name('driver.dashboard');
    Route::post('/dashboard/trip/{id}/accept',[TripController::class,'accept'])->name('trip.accept');
    Route::post('/dashboard/trip/{id}/start',[TripController::class,'start'])->name('trip.start');
    Route::post('/dashboard/trip/{id}/terminer',[TripController::class,'terminer'])->name('trip.terminer');

});

Route::prefix('passenger')->middleware('auth')->group(function (){
    Route::get('/dashboard',[PassengerController::class,'index'])->name('passenger.dashboard');
    Route::post('/lance-trip',[TripController::class,'store'])->name('passenger.trip');
    Route::patch('/trip/ratie/{id}',[TripController::class,'rate'])->name('trips.rate');
});

Route::middleware('auth')->group(function (){
    Route::get('/profile',[ProfileController::class,'index'])->name('profile');
});


include "auth.php";
