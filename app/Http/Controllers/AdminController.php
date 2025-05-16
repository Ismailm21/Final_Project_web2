<?php

namespace App\Http\Controllers;
use App\Models\driver_availability;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PendingDriver;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Area;
use App\Models\Availability;
use App\Models\Client;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{


    public function index()
    {
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});
        $rawData = DB::table('orders')
            ->select(
                DB::raw('DAYOFWEEK(created_at) as weekday'),
                DB::raw('DAYNAME(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'), DB::raw('DAYNAME(created_at)'))
            ->orderBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

// Build fixed structure with all 7 days
        $weekdays = [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $ordersPerDay = [];

        foreach ($weekdays as $day) {
            $dayData = $rawData->firstWhere('day', $day);
            $ordersPerDay[] = [
                'day' => $day,
                'total' => $dayData ? $dayData->total : 0
            ];
        }

        $driverData = DB::table('drivers')
            ->select(
                DB::raw('DAYOFWEEK(created_at) as weekday'),
                DB::raw('DAYNAME(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'), DB::raw('DAYNAME(created_at)'))
            ->orderBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

        $driversPerDay = [];

        foreach ($weekdays as $day) {
            $dayData = $driverData->firstWhere('day', $day);
            $driversPerDay[] = [
                'day' => $day,
                'total' => $dayData ? $dayData->total : 0
            ];
        }



        return view('admin.dashboard', compact(
            'D_count',
            'active_orders_count',
            'completed_orders_count',
            'centerShareTotalAllOrders'
        ))->with([
            'orders' => collect($ordersPerDay),
            'drivers' => collect($driversPerDay)
        ]);
    }



    public function destroyDriver(string $id)
    {
        $obj = Driver::findOrFail($id);
        $obj->delete();
        return  view('admin.driver');

    }
    public function viewForm(){
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});

        return view('admin.addDriver',compact('D_count','active_orders_count','completed_orders_count','centerShareTotalAllOrders'));
    }


    public function showDriver($id)
    {
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});
        $driver = Driver::with('user')->findOrFail($id);

        return view('admin.showDriver',compact('driver','D_count','active_orders_count','completed_orders_count','centerShareTotalAllOrders'));
    }



    public function acceptDriver($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = 'approved';
        $driver->save();

        return redirect()->back()->with('success', 'Driver accepted successfully.');
    }

    public function denyDriver($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete(); // Or use soft deletes if enabled

        return redirect()->back()->with('success', 'Driver denied and removed.');
    }
    public function listDrivers(Request $request)
    {
        $approved_drivers = Driver::where('status', 'approved')->get();
        $pending_drivers = Driver::where('status', 'pending')->get();
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {return $payment->total_amount * 0.10; // Center gets 10% of each payment
});
        $status = $request->query('status', 'all');

        // Query drivers based on status filter
        $query = Driver::with('user');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $drivers = $query->orderBy('created_at', 'desc')->get();


        $Orders = Order::all();
        return view('admin.driver', compact('drivers','approved_drivers','pending_drivers','D_count','active_orders_count','completed_orders_count','status','centerShareTotalAllOrders'));
    }


    public function listOrders(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Order::with(['client.user', 'driver.user', 'pickupAddress', 'dropoffAddress']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $active_orders = Order::where('status', 'processing')->get();
        $pending_orders = Order::where('status', 'pending')->get();
        $completed_orders = Order::where('status', 'completed')->get();
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = $active_orders->count();
        $completed_orders_count = $completed_orders->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});

        return view('admin.listOrders', compact('orders', 'active_orders', 'pending_orders', 'completed_orders', 'D_count', 'active_orders_count', 'completed_orders_count', 'status','centerShareTotalAllOrders'));
    }

    public function editDriver($id){
        $driver = Driver::findOrFail($id);
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'pending')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();

        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});

        return view('admin.editDriver', compact('driver','D_count','active_orders_count','completed_orders_count','centerShareTotalAllOrders'));
    }
    
public function updateDriver($id, Request $request)
{
    $driver = Driver::findOrFail($id);

    $validated = $request->validate([
        // User fields
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'required|string|max:20',
        'password' => 'nullable|min:8|confirmed',

        // Driver fields
        'vehicle_type' => 'required|string',
        'vehicle_number' => 'required|string',
        'license' => 'required|string',
        'pricing_model' => 'required|in:fixed,perKilometer',
        'price' => 'required|numeric|min:0',

        // Area field
        'area' => 'required|string'
    ]);

    try {
        DB::beginTransaction();

        // Update User
        $user = User::findOrFail($driver->user_id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->role = 'driver';
        $user->save();

        // Update Area
        $area = Area::firstOrCreate(['name' => $validated['area']]);
        $driver->area_id = $area->id;

        // Update Driver
        $driver->vehicle_type = $validated['vehicle_type'];
        $driver->vehicle_number = $validated['vehicle_number'];
        $driver->license = $validated['license'];
        $driver->pricing_model = $validated['pricing_model'];
        $driver->fixed_rate = $validated['pricing_model'] === 'fixed' ? $validated['price'] : null;
        $driver->rate_per_km = $validated['pricing_model'] === 'perKilometer' ? $validated['price'] : null;
        $driver->status = 'approved';
        $driver->save();

        // Sync Availabilities
        DB::table('driver_availabilities')->where('driver_id', $driver->id)->delete();

        if ($request->has('availabilities')) {
            foreach ($request->input('availabilities', []) as $day => $data) {
                if (!empty($data['active']) && !empty($data['start_time']) && !empty($data['end_time'])) {
                    $availability = Availability::create([
                        'day' => ucfirst($day),
                        'start_time' => $data['start_time'],
                        'end_time' => $data['end_time'],
                        'status' => 'available',
                    ]);

                    DB::table('driver_availabilities')->insert([
                        'driver_id' => $driver->id,
                        'availability_id' => $availability->id,
                    ]);
                }
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Driver updated successfully',
            'data' => [
                'user' => $user,
                'driver' => $driver
            ]
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Failed to update driver',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function signUp(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'loyalty_points_id' => 'nullable|exists:loyalty_points,id',
            'Achievements' => 'required|in:Bronze,Silver,Gold,Platinum',
        ]);
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = 'client';
        $user->otp_expires_at = now()->addMinutes(5);

        // expires in 5 minutes
        $user->is_verified = false;
        $user->save();

        // Create the Client record
        $client = new Client();
        $client->user_id = $user->id;

        // Associate with the created user
        $client->loyalty_points_id = $validated['loyalty_points_id'] ?? null;
        $client->Achievements = $validated['Achievements'];
        $client->save();
    }




    public function setLoyaltyRules(Request $request){

    }

    public function addDriver(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                // User fields
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'phone' => 'required|string|max:20',

                // Driver fields
                'vehicle_type' => 'required|string',
                'vehicle_number' => 'required|string|unique:drivers,vehicle_number',
                'license' => 'required|string|unique:drivers,license',
                'pricing_model' => 'required|in:fixed,perKilometer',
                'price' => 'required|numeric|min:0',

                // Area fields
                'state' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string'
            ]);

            // 1. Create User
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->phone = $validated['phone'];
            $user->role = 'driver';
            $user->save();

            // 2. Create or find Area
            $area = Area::firstOrCreate([
                'name' => $validated['state'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // 3. Create Driver
            $driver = new Driver();
            $driver->user_id = $user->id;
            $driver->area_id = $area->id;
            $driver->vehicle_type = $validated['vehicle_type'];
            $driver->vehicle_number = $validated['vehicle_number'];
            $driver->license = $validated['license'];
            $driver->pricing_model = $validated['pricing_model'];
            $driver->fixed_rate = $validated['pricing_model'] === 'fixed' ? $validated['price'] : null;
            $driver->rate_per_km = $validated['pricing_model'] === 'perKilometer' ? $validated['price'] : null;
            $driver->status = 'approved';
            $driver->save();

            // 4. Handle Availabilities (optional)
            if ($request->has('availabilities')) {
                foreach ($request->input('availabilities', []) as $day => $data) {
                    if (!empty($data['active'])) {
                        $availability = Availability::create([
                            'day' => ucfirst($day),
                            'start_time' => $data['start_time'],
                            'end_time' => $data['end_time'],
                            'status' => 'available',
                        ]);

                        DB::table('driver_availabilities')->insert([
                            'driver_id' => $driver->id,
                            'availability_id' => $availability->id,
                        ]);
                    }
                }
            }

            // 5. Return success response
            return response()->json([
                'success' => true,
                'message' => 'Driver added successfully',
                'data' => [
                    'user' => $user,
                    'driver' => $driver
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Driver creation failed', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to add driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }


public function OrderDetails($id){
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});
        $order = Order::findOrFail($id);
        if ($order) {
            $order->pickupAddress = $order->pickupAddress()->first();
            $order->dropoffAddress = $order->dropoffAddress()->first();
            $order->client = $order->client()->first();
            $clientUser = User::find($order->client->user_id);
            $payment = Payment::where('order_id', $order->id)
                ->whereIn('status', ['pending', 'paid'])
                ->orderBy('remaining_amount', 'asc')
                ->first();
            $payment = $payment ? $payment : null;
            return view('admin.showOrderDetails', compact('order', 'centerShareTotalAllOrders','clientUser', 'payment','D_count','active_orders_count', 'completed_orders_count'));
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }


    public function loyaltyReport()
    {
        // Example: Assume 'distance_km' is in the 'orders' table
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});
        $clients = Client::with(['orders' => function($q) {
            $q->select('id', 'client_id', 'distance_km');
        }])->get();

        $clientLoyaltyData = $clients->map(function ($client) {
            $totalKm = $client->orders->sum('distance_km');
            $points = floor($totalKm / 10); // 1 point per 10 km

            // Reward logic
            if ($points >= 300) {
                $reward = 'Gold Badge';
            } elseif ($points >= 200) {
                $reward = 'Silver Badge';
            } elseif ($points >= 100) {
                $reward = 'Bronze Badge';
            } else {
                $reward = 'No Reward';
            }

            return [
                'client_name' => $client->name,
                'total_km' => $totalKm,
                'points' => $points,
                'reward' => $reward,
            ];
        });

        return view('admin.loyalty_report', compact('clientLoyaltyData','centerShareTotalAllOrders','D_count', 'active_orders_count', 'completed_orders_count'));
    }
}

