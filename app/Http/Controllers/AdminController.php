<?php

namespace App\Http\Controllers;
use App\Models\driver_availability;
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
        return view('admin.dashboard');
    }

    public function listDrivers()
    {
        $drivers = User::where('role', 'driver')->get();
        return view('admin.driver', compact('drivers'));
    }

    public function editDriver($id){
        $driver = Driver::findOrFail($id);
        return view('admin.editDriver', compact('driver'));
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









    public function destroyDriver(string $id)
    {
        $obj = Driver::findOrFail($id);
        $obj->delete();
        return redirect()->route("driverR.index");

    }
    public function viewForm(){
        return view('admin.addDriver');
    }

    public function viewDriverRequests()
    {
        // Assuming pending drivers are stored with 'pending' status
        $pending_drivers = PendingDriver::all(); // Fetch all pending drivers
        return view('admin.driverRequests', compact('pending_drivers'));
    }

    public function handleDriverRequest($id, $action)
    {
        $driver = PendingDriver::findOrFail($id);


        if ($action === 'approve') {
            $driver->status = 'approved';
            $driver->save();
            return back()->with('success', 'Driver approved successfully.');
        } elseif ($action === 'deny') {
            $driver->delete(); // or $driver->status = 'rejected';
            return back()->with('success', 'Driver denied and removed.');
        }

        return back()->with('error', 'Unknown action.');
    }


    public function addDriver(Request $request)
    {
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

            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->phone = $validated['phone'];
            $user->role = 'driver';
            $user->save();


            $area = new Area();
            $area->name = $validated['area'];
            $area->save();

            $driver = new Driver();
            $driver->user_id = $user->id;
            $driver->area_id = $area->id;
            $driver->vehicle_type = $validated['vehicle_type'];
            $driver->vehicle_number = $validated['vehicle_number'];
            $driver->license = $validated['license'];
            $driver->pricing_model = $validated['pricing_model'];
            $driver->fixed_rate = ($validated['pricing_model'] === 'fixed') ? $validated['price'] : null;
            $driver->rate_per_km = ($validated['pricing_model'] === 'perKilometer') ? $validated['price'] : null;
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


    public function showDrivers($id)
    {
        $driver = User::where('role', 'driver')->get();
        return $driver;
    }


    public function setLoyaltyRules(Request $request){

    }
}

