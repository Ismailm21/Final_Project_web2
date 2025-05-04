<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDriverController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/dashboard', [AdminController::class,'index'])->name('admin.dashboard');
Route::get('admin/list_drivers', [AdminController::class, 'listDrivers'])->name('admin.driver');
Route::get('admin/add_drivers', [AdminController::class, 'viewForm'])->name('admin.addDriver');
Route::post('admin/save_drivers', [AdminController::class, 'addDriver'])->name('admin.save');
Route::get('admin/driver{id}', [AdminController::class, 'showDrivers'])->name('drivers_profile');

Route::resource('driver', AdminDriverController::class);






/*DRIVER JULIEN*/
use App\Http\Controllers\DriverMenuController;
Route::get('driverMenu', [DriverMenuController::class, 'index'])->name('driverMenu');
Route::get('myProfile', [DriverMenuController::class, 'myProfile'])->name('myProfile');
Route::get('inProcessOrders', [DriverMenuController::class, 'inProcessOrders'])->name('inProcessOrders');
Route::get('completedOrders', [DriverMenuController::class, 'completedOrders'])->name('completedOrders');
Route::get('cancelledOrders', [DriverMenuController::class, 'cancelledOrders'])->name('cancelledOrders');
Route::get('manageAvailability', [DriverMenuController::class, 'manageAvailability'])->name('manageAvailability');
Route::get('AreaAndPricing', [DriverMenuController::class, 'AreaAndPricing'])->name('AreaAndPricing');
