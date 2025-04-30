<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        return view('admin.dashboard');
    }
    public function listDrivers()
    {
        $drivers = Driver::all();
        return view('admin.driver',compact('drivers'));
    }
    public function viewForm(){
        return view('admin.addDriver');
    }
    public function addDriver(Request $request){
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'password' => 'required|min:8|confirmed',
            'area' => 'required',
            'vehicle_type' => 'required',
            'vehicle_number' => 'required',
            'pricing_model' => 'required'
        ]);
        $driver = new Driver();
        $driver->name = $request->input('name');
        $driver->email = $request->input('email');
        $driver->password  = Hash::make($request->input('password'));
        $driver->area  = $request->input('area');
        $driver-> vehicle_type = $request->input('vehicle_type');
        $driver-> vehicle_number = $request->input('vehicle_number');
        $driver->pricing_model = $request->input('pricing_model');
        $driver->save;
    }
    public function showDrivers($id)
    {
        $driver = User::where('role', 'driver')->get();
        return $driver;
    }
    public function setLoyaltyRules(Request $request){

    }
}

