<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;

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
        ]);
        $driver = new Driver();
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

