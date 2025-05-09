<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DriverAuthController;
use App\Http\Controllers\Drivercontroller;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\AdminDriverController;
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

/*----------------------------------------- Raed--------------------------------------------*/
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/list_drivers', [AdminController::class, 'listDrivers'])->name('admin.driver');
    Route::get('admin/add_drivers', [AdminController::class, 'viewForm'])->name('admin.addDriver');
    Route::get('admin/driver{id}', [AdminController::class, 'showDrivers'])->name('drivers_profile');
    Route::post('admin/store-driver', [AdminAuthController::class, 'storeDriver'])->name('admin.storeDriver');
});


Route::get('client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
Route::get('login', [ClientAuthController::class, 'showLoginForm'])->name('login'); // fallback

Route::post('client/login', [ClientAuthController::class, 'login'])->name('client.login.submit');

// Show the sign-up page for clients
Route::get('client/signup', [ClientAuthController::class, 'showSignUpForm'])->name('client.signup');
Route::post('client/signup', [ClientAuthController::class, 'signUp'])->name('client.signup.submit');

Route::middleware(['auth', 'TwoFactor'])->group(function () {
    Route::get('client/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});
Route::middleware(['auth','TwoFactor'])->group(function () {
    Route::get('driver/dashboard', [Drivercontroller::class, 'index'])->name('driver.dashboard');
});


Route::get('/client/verify', [ClientAuthController::class, 'showOtpForm'])->name('verify.otp');
Route::post('/client/verify', [ClientAuthController::class, 'verifyOtp'])->name('verify.otp.submit');

Route::get('/driver/verify', [DriverAuthController::class, 'showDriverOtpForm'])->name('driver.verify.otp');
Route::post('/driver/verify', [DriverAuthController::class, 'verifyDriverOtp'])->name('driver.verify.otp.submit');


Route::get('admin/list_drivers', [AdminController::class, 'listDrivers'])->name('admin.driver');
Route::get('admin/add_drivers', [AdminController::class, 'viewForm'])->name('admin.addDriver');
Route::post('admin/save_drivers', [AdminController::class, 'addDriver'])->name('admin.save');
Route::get('admin/driver{id}', [AdminController::class, 'showDrivers'])->name('drivers_profile');
Route::get('admin/driver_requests',[AdminController::class, 'driverRequests'])->name('admin.showRequests');
Route::get('admin/delete_driver/{id}',[AdminController::class, 'destroyDriver'])->name('admin.deleteDriver');
Route::get('admin/edit_driver',[AdminController::class, 'editDriver'])->name('admin.editDriver');
Route::post('admin/update_driver/{id}',[AdminController::class, 'updateDriver'])->name('admin.updateDriver');



/*-----------------------------------------DRIVER JULIEN--------------------------------------------*/
use App\Http\Controllers\DriverMenuController;
Route::get('driver/driverMenu', [DriverMenuController::class, 'index'])->name('driver.Menu');
Route::get('driver/myProfile', [DriverMenuController::class, 'myProfile'])->name('driver.myProfile');
Route::get('driver/inProcessOrders', [DriverMenuController::class, 'inProcessOrders'])->name('driver.inProcessOrders');
Route::get('driver/completedOrders', [DriverMenuController::class, 'completedOrders'])->name('driver.completedOrders');
Route::get('driver/cancelledOrders', [DriverMenuController::class, 'cancelledOrders'])->name('driver.cancelledOrders');
Route::get('driver/manageAvailability', [DriverMenuController::class, 'manageAvailability'])->name('driver.manageAvailability');
Route::get('driver/AreaAndPricing', [DriverMenuController::class, 'AreaAndPricing'])->name('driver.AreaAndPricing');
/*--------------------------------------------------------------------------------------------------*/

