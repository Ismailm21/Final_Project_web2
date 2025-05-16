<?php

namespace App\Http\Controllers;
use App\Models\driver_availability;
use App\Models\Order;
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

class AdminController extends Controller
{


    public function index()
    {
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders = Order::where('status', 'pending')->count();
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


        return view('admin.dashboard',compact('D_count','active_orders'),['orders' => collect($ordersPerDay)]);
    }



/*

    public function index()
    {
        // Existing code
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders = Order::where('status', 'pending')->count();
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
        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $ordersPerDay = [];

        foreach ($weekdays as $day) {
            $dayData = $rawData->firstWhere('day', $day);
            $ordersPerDay[] = [
                'day' => $day,
                'total' => $dayData ? $dayData->total : 0
            ];
        }

        // New reports functionality
        // Get all drivers for the dropdown
        $drivers = Driver::where('status', 'approved')->get();

        // Get default date range (last 30 days)
        $from_date = now()->subDays(30)->format('Y-m-d');
        $to_date = now()->format('Y-m-d');
        $filters = ['from_date' => $from_date, 'to_date' => $to_date];

        // Get dashboard metrics
        $totalEarnings = Order::whereBetween('created_at', [$from_date, $to_date])->sum('total');
        $driverShare = Order::whereBetween('created_at', [$from_date, $to_date])->sum('driver_amount');
        $totalClients = User::where('role', 'client')->count();
        $totalServices = Order::whereBetween('created_at', [$from_date, $to_date])->count();

        // Get detailed driver reports
        $driverReports = DB::table('orders')
            ->join('drivers', 'orders.driver_id', '=', 'drivers.id')
            ->select(
                'drivers.name as driver_name',
                DB::raw('SUM(orders.total) as total_paid'),
                DB::raw('SUM(CASE WHEN orders.status != "completed" THEN orders.total ELSE 0 END) as remaining'),
                DB::raw('SUM(orders.driver_amount) as driver_share_amount'),
                'drivers.commission as driver_share_percentage',
                DB::raw('SUM(orders.total - orders.driver_amount) as company_share_amount'),
                DB::raw('(100 - drivers.commission) as company_share_percentage')
            )
            ->whereBetween('orders.created_at', [$from_date, $to_date])
            ->groupBy('drivers.id', 'drivers.name', 'drivers.commission')
            ->get();

        // Calculate totals
        $totals = (object)[
            'total_paid' => $driverReports->sum('total_paid'),
            'remaining' => $driverReports->sum('remaining'),
            'driver_share_amount' => $driverReports->sum('driver_share_amount'),
            'company_share_amount' => $driverReports->sum('company_share_amount')
        ];

        return view('admin.dashboard', compact(
            'D_count', 'active_orders', 'drivers', 'totalEarnings',
            'driverShare', 'totalClients', 'totalServices', 'driverReports',
            'totals', 'filters'
        ), ['orders' => collect($ordersPerDay)]);
    }


    public function filterReports(Request $request)
    {
        // Get filter parameters
        $filters = $request->only(['from_date', 'to_date', 'driver_id']);

        // Validate filter data
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'driver_id' => 'nullable'
        ]);

        // Get counts
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders = Order::where('status', 'pending')->count();

        // Get daily order data (for chart)
        $rawData = DB::table('orders')
            ->select(
                DB::raw('DAYOFWEEK(created_at) as weekday'),
                DB::raw('DAYNAME(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('DAYOFWEEK(created_at)'), DB::raw('DAYNAME(created_at)'))
            ->orderBy(DB::raw('DAYOFWEEK(created_at)'))
            ->get();

        $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $ordersPerDay = [];

        foreach ($weekdays as $day) {
            $dayData = $rawData->firstWhere('day', $day);
            $ordersPerDay[] = [
                'day' => $day,
                'total' => $dayData ? $dayData->total : 0
            ];
        }

        // Get all drivers for the dropdown
        $drivers = Driver::where('status', 'approved')->get();

        // Build query for reports
        $query = DB::table('orders')
            ->join('drivers', 'orders.driver_id', '=', 'drivers.id')
            ->select(
                'drivers.name as driver_name',
                DB::raw('SUM(orders.total) as total_paid'),
                DB::raw('SUM(CASE WHEN orders.status != "completed" THEN orders.total ELSE 0 END) as remaining'),
                DB::raw('SUM(orders.driver_amount) as driver_share_amount'),
                'drivers.commission as driver_share_percentage',
                DB::raw('SUM(orders.total - orders.driver_amount) as company_share_amount'),
                DB::raw('(100 - drivers.commission) as company_share_percentage')
            )
            ->whereBetween('orders.created_at', [$filters['from_date'], $filters['to_date']])
            ->groupBy('drivers.id', 'drivers.name', 'drivers.commission');

        // Apply driver filter if selected
        if (!empty($filters['driver_id']) && $filters['driver_id'] !== 'all') {
            $query->where('drivers.id', $filters['driver_id']);
        }

        $driverReports = $query->get();

        // Get dashboard metrics (filtered)
        $earningsQuery = DB::table('orders')
            ->whereBetween('created_at', [$filters['from_date'], $filters['to_date']]);

        if (!empty($filters['driver_id']) && $filters['driver_id'] !== 'all') {
            $earningsQuery->where('driver_id', $filters['driver_id']);
        }

        $totalEarnings = $earningsQuery->sum('total');
        $driverShare = $earningsQuery->sum('driver_amount');
        $totalClients = DB::table('orders')
            ->whereBetween('created_at', [$filters['from_date'], $filters['to_date']])
            ->distinct('user_id')
            ->count('user_id');
        $totalServices = $earningsQuery->count();

        // Calculate totals
        $totals = (object)[
            'total_paid' => $driverReports->sum('total_paid'),
            'remaining' => $driverReports->sum('remaining'),
            'driver_share_amount' => $driverReports->sum('driver_share_amount'),
            'company_share_amount' => $driverReports->sum('company_share_amount')
        ];

        return view('admin.dashboard', compact(
            'D_count', 'active_orders', 'drivers', 'totalEarnings',
            'driverShare', 'totalClients', 'totalServices', 'driverReports',
            'totals', 'filters'
        ), ['orders' => collect($ordersPerDay)]);
    }


*/



    public function destroyDriver(string $id)
    {
        $obj = Driver::findOrFail($id);
        $obj->delete();
        return  view('admin.driver');

    }
    public function viewForm(){
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders = Order::where('status', 'pending')->count();

        return view('admin.addDriver',compact('D_count','active_orders'));
    }


    public function showDriver($id)
    {
        $active_orders = Order::where('status', 'pending')->count();
        $D_count = Driver::where('status', 'approved')->count();
        $driver = Driver::with('user')->findOrFail($id);

        return view('admin.showDriver',compact('driver','active_orders','D_count'));
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
        $drivers = Driver::all();
        $approved_drivers = Driver::where('status', 'approved')->get();
        $pending_drivers = Driver::where('status', 'pending')->get();
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders = Order::where('status', 'pending')->count();

        $status = $request->query('status', 'all');

        // Query drivers based on status filter
        $query = Driver::with('user');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $drivers = $query->orderBy('created_at', 'desc')->get();


        $Orders = Order::all();
        return view('admin.driver', compact('drivers','approved_drivers','pending_drivers','D_count','active_orders','status'));
    }

    public function editDriver($id){
        $driver = Driver::findOrFail($id);
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders = Order::where('status', 'pending')->count();

        return view('admin.editDriver', compact('driver','D_count','active_orders'));
    }
    public function updateDriver($id, Request $request)
    {
        $driver = Driver::findOrFail($id);
        if (!$driver) {
            return redirect()->back()->with('error', 'Driver not found.');
        }
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

            // Area field
            'area' => 'required|string'
        ]);
        try {
            // 1. Create User

            $user = findOrFail($driver->user_id);
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = Hash::make($validated['password']);
            $user->role = 'driver';
            $user->save();


            $area =Area::firstOrCreate(['name' => $validated['area']])->id;

            $driver->user_id = $user->id;
            $driver->area_id = $area->id;
            $driver->vehicle_type = $validated['vehicle_type'];
            $driver->vehicle_number = $validated['vehicle_number'];
            $driver->license = $validated['license'];
            $driver->pricing_model = $validated['pricing_model'];
            $driver->fixed_rate = ($validated['pricing_model'] === 'fixed') ? $validated['price'] : null;
            $driver->rate_per_km = ($validated['pricing_model'] === 'perKilometer') ? $validated['price'] : null;
            $driver->status = 'approved';
            $driver->save();


            if ($request->has('availabilities')) {
                foreach ($request->input('availabilities', []) as $day => $data) {
                    // Must be checked *and* have both times (validation ensures this)
                    if (!empty($data['active'])) {
                        // Create the availability row
                        $availability = Availability::create([
                            'day' => ucfirst($day),
                            'start_time' => $data['start_time'],
                            'end_time' => $data['end_time'],
                            'status' => 'available',
                        ]);

                        // Link it to the driver via the pivot
                        DB::table('driver_availabilities')->insert([
                            'driver_id' => $driver->id,
                            'availability_id' => $availability->id,

                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Driver added successfully',
                'data' => [
                    'user' => $user,
                    'driver' => $driver
                ]
            ]);

        } catch (\Exception $e) {
            //DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add driver',
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


}

