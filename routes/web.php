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
Route::get('admin/save_drivers', [AdminController::class, 'addDriver'])->name('admin.save');
Route::get('admin/driver{id}', [AdminController::class, 'showDrivers'])->name('drivers_profile');

Route::resource('driver', AdminDriverController::class);
