<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Area;

class DriverController extends Controller
{
    public function updateDriverProfile(Request $request)
    {
        $userId = 1; // Auth::user()->id;
        $user = User::find($userId);
        $driver = Driver::where('user_id', $user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'vehicle_type' => 'required|string|max:255',
            'vehicle_number' => 'required|string|max:20',
            'license' => 'required|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        $driver->vehicle_type = $request->vehicle_type;
        $driver->vehicle_number = $request->vehicle_number;
        $driver->license = $request->license;
        $driver->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updateDriverPassword(Request $request)
    {
        $userId = 1; // Auth::user()->id;
        $user = User::find($userId);

        
        $request->validate([
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_new_password' => 'required|string|same:new_password',
        ]);
        
        if (!password_verify($request->old_password, $user->password)) {
            return redirect()->back()
            ->withErrors(['old_password' => 'Old password is incorrect.'])
            ->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function updateOrderStatusByDriver(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'status' => 'required|string|in:processing,completed,cancelled',
        ]);
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $order->status = $request->status;
        $order->save();
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    function updateAreaAndPricing(Request $request)
    {
        $request->validate([
            'area' => 'required|string',
            'pricing_model' => 'required|in:fixed,perKilometer',
            'price' => 'required|numeric|min:1',
        ]);

        $areaId = Area::firstOrCreate(['name' => $request->area])->id;

        $userId = 1; // Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $driver->area_id = $areaId;
        $driver->pricing_model = $request->pricing_model;
        if ($request->pricing_model === 'fixed') {
            $driver->fixed_rate = $request->price;
            $driver->rate_per_km = null;
        } else {
            $driver->rate_per_km = $request->price;
            $driver->fixed_rate = null;
        }
        $driver->save();
        return redirect()->back()->with('success', 'Area and pricing updated successfully.');
    }

    function updateDriverAvailability(){

    }
}
