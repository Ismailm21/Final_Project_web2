<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\DriverAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('WelcomePage');
})->name('welcome');


Route::get('driver/login', [DriverAuthController::class, 'showLoginForm'])->name('driver.login');
Route::post('driver/login', [DriverAuthController::class, 'login'])->name('driver.login.submit');

Route::get('driver/signup', [DriverAuthController::class, 'showSignUpForm'])->name('driver.signup');
Route::post('driver/signup', [DriverAuthController::class, 'signUp'])->name('driver.signup.submit');

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('admin/signup', [AdminAuthController::class, 'showSignUpForm'])->name('admin.signup');
Route::post('admin/signup', [AdminAuthController::class, 'signUp'])->name('admin.signup.submit');

Route::get('admin/dashboard', function () {
    return 'Welcome to the Admin Dashboard';
})->name('admin.dashboard')->middleware('auth');
