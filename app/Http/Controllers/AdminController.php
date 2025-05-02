<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Area;
use App\Models\Availability;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\alert;

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
    public function addDriver(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'area' => 'required|string', // This is the area name to be created
            'address_type' => 'required|in:home,work,other',
            'vehicle_type' => 'required|string',
            'vehicle_number' => 'required|string',
            'price' => 'required|numeric|min:0',
            'pricing_model' => 'required|in:fixed,per_km'
        ]);

        try {
            $area = Area::firstOrCreate([
                'name' => $validated['area']
            ]);

            $address = Address::firstOrCreate([
                'street' => $request['street'],
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                'type' => $validated['address_type'],
                'PostalCode' => $request['postal_code'],
                'latitude' => $request['latitude'],
                'longitude' => $request['longitude'],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'driver',
                'address_id' => $address->id
            ]);


            $driver = $user->driver()->create([
                'phone' => $validated['phone'],
                'area_id' => $area->id,
                'vehicle_type' => $validated['vehicle_type'],
                'vehicle_number' => $validated['vehicle_number'],
                'price' => $validated['price'],
                'pricing_model' => $validated['pricing_model'],
                'availabilities' => 'sometimes|array',
                'availabilities.*.day' => 'required_with:availabilities|in:monday,tuesday,wednesday,thursday,friday',
                'availabilities.*.start_time' => 'required_with:availabilities|date_format:H:i',
                'availabilities.*.end_time' => 'required_with:availabilities|date_format:H:i|after:availabilities.*.start_time'
            ]);

            if ($request->has('availabilities')) {
                foreach ($request->availabilities as $availabilityData) {
                    $availability = Availability::create([
                        'day' => $availabilityData['day'],
                        'start_time' => $availabilityData['start_time'],
                        'end_time' => $availabilityData['end_time'],
                        'status' => 'available'
                    ]);

                    $driver->availabilities()->attach($availability->id);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Driver added successfully',
                'data' => [
                    'driver' => $driver,
                    'availabilities' => $driver->availabilities
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add driver',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function showDrivers($id)
    {
        $driver = User::where('role', 'driver')->get();
        return $driver;
    }
    public function setLoyaltyRules(Request $request){

    }
}

