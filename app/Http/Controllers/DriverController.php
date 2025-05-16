<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Area;
use App\Models\Availability;
use App\Models\Payment;

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
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $order->status = $request->status;

        if ($request->status === 'completed') {
            $order->delivery_date = now();
        } elseif ($request->status === 'cancelled' || $request->status === 'pending' || $request->status === 'processing') {
            $order->delivery_date = null;
        }
        $order->save();
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function updateOrderDeliveryDate(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'delivery_date' => 'required|date',
        ]);
        $order = Order::find($request->order_id);
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }
        $order->delivery_date = $request->delivery_date;
        $order->save();
        return redirect()->back()->with('success', 'Delivery date updated successfully.');
    }

    function updateAreaAndPricing(Request $request)
    {

        $request->validate([
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'pricing_model' => 'required|in:fixed,perKilometer',
            'price' => 'required|numeric|min:1',
        ]);


        $newarea = Area::firstOrCreate(
            ['name' => $request->state ?? 'Custom Area', 'latitude' => $request->latitude, 'longitude' => $request->longitude]
        );
        
        $userId = 1; // Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $driver->area_id = $newarea->id;
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

    function updateDriverAvailability(Request $request)
    {
        //Validating the request (day, start_time, end_time, active)
        $newAvailabilities = $request->input('availabilities', []);
        foreach ($newAvailabilities as $day => $data) {
            if (isset($data['active']) && $data['active']) {
                if (empty($data['start_time']) || empty($data['end_time'])) {
                    return redirect()->back()
                        ->withErrors(["availabilities.$day" => "Start and end time are required for " . ucfirst($day) . "."])
                        ->withInput();
                }
            }
        }

        //Validating if start time is less than end time, if not return error
        foreach ($newAvailabilities as $day => $data) {
            if (isset($data['active']) && $data['active']) {
                if ($data['start_time'] >= $data['end_time']) {
                    return redirect()->back()
                        ->withErrors(["availabilities.$day" => "Start time must be less than end time for " . ucfirst($day) . "."])
                        ->withInput();
                }
            }
        }

        $userId = 1; // Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();

        //Retrieving old availabilities Ids of the driver in the driver_availabilities table
        $availabilityIds = \DB::table('driver_availabilities')
            ->where('driver_id', $driver->id)
            ->pluck('availability_id')
            ->toArray();

        //Retrieving old availabilities from the availabilities table
        $availabilities = Availability::whereIn('id', $availabilityIds)->get();

        //Then deleting the old availabilities
        foreach ($availabilities as $availability) {
            \DB::table('availabilities')->where('id', $availability->id)->delete();
        }

        //Then inserting the new availabilities
        foreach ($request->input('availabilities', []) as $day => $data) {
            if (isset($data['active']) && $data['active']) {
                $availability = new Availability();
                $availability->day = $day;
                $availability->start_time = $data['start_time'];
                $availability->end_time = $data['end_time'];
                $availability->save();

                //Inserting the new availability Id in the driver_availabilities table (pivot table)
                \DB::table('driver_availabilities')->insert([
                    'driver_id' => $driver->id,
                    'availability_id' => $availability->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Availability updated successfully.');
    }

    public function acceptPayment(Request $request){
        
        $request->validate([
            'payment_id' => 'required'
        ]);

        $payment = Payment::findOrFail($request->payment_id);
        $payment->status = 'paid';
        $payment->save();

        return redirect()->back()->with('success', 'Payment accepted successfully.');
    }
}
