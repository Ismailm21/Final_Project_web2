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
        $userId = 1;//Auth::user()->id;
        $user = User::find($userId);
        $driver = Driver::where('user_id', $user->id)->first();
        $processingCount = Order::where('driver_id', $driver->id)->where('status', 'processing')->count();
        $deliveredCount = Order::where('driver_id', $driver->id)->where('status', 'completed')->count();
        $cancelledCount = Order::where('driver_id', $driver->id)->where('status', 'cancelled')->count();
        $recentOrders = Order::with(['pickupAddress', 'dropoffAddress'])->where('driver_id', $driver->id)->orderBy('created_at', 'desc')->take(5)->get();
        return view('driver.driverMenu', compact('user', 'driver', 'processingCount', 'deliveredCount', 'cancelledCount', 'recentOrders'));
    }

    public function myProfile(){
        $userId = 1;//Auth::user()->id;
        $user = User::find($userId);

        $driver = Driver::where('user_id', 1)->first();
        //return $driver;
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
        $userId = 1; // Auth::user()->id; // Update this when authentication is implemented
        $driver = Driver::where('user_id', $userId)->first();
        
        if (!$driver) {
            return []; // or handle the case when driver is not found
        }
        
        // Call the relationship as a property to get the related models
        $availabilities = $driver->getAvailability;
        
        return $availabilities;
    }

    public function areaAndPricing(){
        $userId = 1;//Auth::user()->id;
        $driver = Driver::with(['area'])->where('user_id', $userId)->first();
        return view('driver.AreaAndPricing', compact('driver'));
    }

    public function OrderDetails($orderId){
        $userId = 1;//Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $order = Order::with(['pickupAddress', 'dropoffAddress', 'client'])->where('id', $orderId)->where('driver_id', $driver->id)->first();
        if ($order) {
            $order->pickupAddress = $order->pickupAddress()->first();
            $order->dropoffAddress = $order->dropoffAddress()->first();
            $order->client = $order->client()->first();
            $clientUser = User::find($order->client->user_id);
            $payment = $order->payment()->first();
            return view('driver.OrderDetails', compact('order', 'clientUser', 'payment'));
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }
}
