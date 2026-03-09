<?php
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::get('/register',[RegisterController::class,'index'])->name('register');
Route::post('/register/post',[RegisterController::class,'registerUser'])->name('register.post');