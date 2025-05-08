<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDriverController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\clientIndex;
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

Route::get('client/request_order',[ClientController::class,'client_request_order'])->name("client_request_order");
Route::post('store_order',[ClientController::class,'store_order'])->name('store_order');
Route::get('store_time',[ClientController::class,'find_time'])->name('find_time');
Route::get('client/calculate_distance/{id}',[ClientController::class,'calculateDistance'])->name('calculate_distance');
Route::get('client/error',[ClientController::class,'client_error'])->name('client_error');
