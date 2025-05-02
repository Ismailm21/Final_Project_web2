<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientController;
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

//Route::get('admin/signup', [AdminAuthController::class, 'showSignUpForm'])->name('admin.signup');
//Route::post('admin/signup', [AdminAuthController::class, 'signUp'])->name('admin.signup.submit');

Route::get('admin/list_drivers', [AdminController::class, 'listDrivers'])->name('admin.driver');
Route::get('admin/add_drivers', [AdminController::class, 'viewForm'])->name('admin.addDriver');
Route::get('admin/driver{id}', [AdminController::class, 'showDrivers'])->name('drivers_profile');

Route::post('admin/store-driver', [AdminAuthController::class, 'storeDriver'])->name('admin.storeDriver')->middleware('auth');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

});

Route::middleware(['auth'])->group(function () {

    Route::get('driver/dashboard', [DriverAuthController::class, 'index'])->name('driver.dashboard');

});

Route::post('admin/store-driver', [AdminAuthController::class, 'storeDriver'])->name('admin.storeDriver')->middleware(['auth', 'is_admin']);

Route::get('client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
Route::post('client/login', [ClientAuthController::class, 'login'])->name('client.login.submit');

// Show the sign-up page for clients
Route::get('client/signup', [ClientAuthController::class, 'showSignUpForm'])->name('client.signup');
Route::post('client/signup', [ClientAuthController::class, 'signUp'])->name('client.signup.submit');


Route::middleware(['auth'])->group(function () {
    // Client dashboard route, only accessible when logged in
    Route::get('client/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});

Route::get('/verify-otp', [ClientAuthController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [ClientAuthController::class, 'verifyOtp'])->name('otp.verify');

