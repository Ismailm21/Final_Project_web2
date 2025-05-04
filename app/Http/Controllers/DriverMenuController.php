<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverMenuController extends Controller
{
    public function index(){
        return view('driver.driverMenu');
    }

    public function myProfile(){
        $userId = 1;//Auth::user()->id;
        $user = User::find($userId);
        $driver = Driver::where('user_id', $user->id)->first();
        return view('driver.myProfile', compact('user', 'driver'));
    }

    public function inProcessOrders(){
        $userId = 1;//Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $orders = Order::with(['pickupAddress', 'dropoffAddress'])->where('driver_id', $driver->id)->where('status', 'processing')->get();
        foreach ($orders as $order) {
            $order->pickupAddress = $order->pickupAddress()->first();
            $order->dropoffAddress = $order->dropoffAddress()->first();
            $order->client = $order->client()->first();
        }
        return view('driver.inProcessOrders', compact('orders'));
    }

    public function completedOrders(){
        $userId = 1;//Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $orders = Order::with(['pickupAddress', 'dropoffAddress'])->where('driver_id', $driver->id)->where('status', 'completed')->get();
        foreach ($orders as $order) {
            $order->pickupAddress = $order->pickupAddress()->first();
            $order->dropoffAddress = $order->dropoffAddress()->first();
            $order->client = $order->client()->first();
        }
        return view('driver.completedOrders', compact('orders'));
    }

    public function cancelledOrders(){
        $userId = 1;//Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $orders = Order::with(['pickupAddress', 'dropoffAddress'])->where('driver_id', $driver->id)->where('status', 'cancelled')->get();
        foreach ($orders as $order) {
            $order->pickupAddress = $order->pickupAddress()->first();
            $order->dropoffAddress = $order->dropoffAddress()->first();
            $order->client = $order->client()->first();
        }
        return view('driver.cancelledOrders', compact('orders'));
    }

    public function manageAvailability(){

        return view('driver.manageAvailability');
    }

    public function areaAndPricing(){

        return view('driver.AreaAndPricing');
    }
}
