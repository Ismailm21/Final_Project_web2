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
Route::get('driver/viewOrderDetails/{id}', [DriverMenuController::class, 'OrderDetails'])->name('driver.viewOrderDetails');

use App\Http\Controllers\DriverController;
Route::put('driver/updateDriverProfile', [DriverController::class, 'updateDriverProfile'])->name('driver.updateDriverProfile');
Route::put('driver/updateDriverPassword', [DriverController::class, 'updateDriverPassword'])->name('driver.updateDriverPassword');
Route::put('driver/updateAreaAndPricing', [DriverController::class, 'updateAreaAndPricing'])->name('driver.updateAreaAndPricing');
Route::put('driver/updateOrderStatusByDriver', [DriverController::class, 'updateOrderStatusByDriver'])->name('driver.updateOrderStatusByDriver');
/*--------------------------------------------------------------------------------------------------*/

