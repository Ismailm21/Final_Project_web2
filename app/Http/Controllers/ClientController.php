<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Availability;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Order;
use Dotenv\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.dashboard');  // Ensure you have a 'client/dashboard.blade.php' view
    }

    public function client_request_order()
    {
        $drivers = Driver::all();
        return view('client.delivery_request', compact('drivers'));
    }

    /*public function store_order(Request $request){

        $validated = validator($request->all(),[
            "package_weight" => "required",
            "package_size_l" => "required",
            'package_size_w' => "required",
            "package_size_h" => "required",
            "pickup_street" => "required",
            "dropoff_street" => "required",
            "pickup_postal_code" => "required",
            "dropoff_postal_code" => "required",
        ]);
        if($validated->fails()){
            $errors = $validated->errors();
            return $errors;
        }
        $dropoff_address=new Address();
        $dropoff_address->street= $request->pickup_street;
        $dropoff_address-> city= $request->pickup_city;
        $dropoff_address->state=$request->pickup_state;
        $dropoff_address->country=$request->pickup_country;
        $dropoff_address->PostalCode=$request->pickup_postal_code;
        $dropoff_address->latitude=$request->pickup_latitude;
        $dropoff_address->longitude=$request->pickup_longitude;
        $dropoff_address->save();

        $pickup_address=new Address();
        $pickup_address->street= $request->pickup_street;
        $pickup_address-> city= $request->pickup_city;
        $pickup_address->state=$request->pickup_state;
        $pickup_address->country=$request->pickup_country;
        $pickup_address->PostalCode=$request->pickup_postal_code;
        $pickup_address->latitude=$request->pickup_latitude;
        $pickup_address->longitude=$request->pickup_longitude;
        $pickup_address->save();
        $order = new Order();

        $order->package_weight=$request->package_weight;
        $order->package_size_l=$request->package_size_l;
        $order->package_size_w=$request->package_size_w;
        $order->package_size_h=$request->package_size_h;
        $order->pickup_address_id=$pickup_address->id;
        $order->dropOff_address_id=$dropoff_address->id;
        $order->save();
        return response()->json(["pickup"=>$pickup_address,"drop off"=>$dropoff_address]);
    }*/
    public function store_order(Request $request)
    {
        // Validate input
        $request->validate([
            "package_weight" => "required|numeric",
            "package_size_l" => "required|numeric",
            "package_size_w" => "required|numeric",
            "package_size_h" => "required|numeric",

            "pickup_street" => "required|string",
            "pickup_city" => "required|string",
            "pickup_state" => "required|string",
            "pickup_country" => "required|string",
            "pickup_postal_code" => "required|string",


            "dropoff_street" => "required|string",
            "dropoff_city" => "required|string",
            "dropoff_state" => "required|string",
            "dropoff_country" => "required|string",
            "dropoff_postal_code" => "required|string",

        ]);


        // Save Pickup Address
        $pickup_address = new Address();
        $pickup_address->street = $request->pickup_street;
        $pickup_address->city = $request->pickup_city;
        $pickup_address->state = $request->pickup_state;
        $pickup_address->country = $request->pickup_country;
        $pickup_address->postal_code = $request->pickup_postal_code;
        $pickup_address->latitude = $request->pickup_latitude;
        $pickup_address->longitude = $request->pickup_longitude;
        $pickup_address->save();

        // Save Dropoff Address
        $dropoff_address = new Address();
        $dropoff_address->street = $request->dropoff_street;
        $dropoff_address->city = $request->dropoff_city;
        $dropoff_address->state = $request->dropoff_state;
        $dropoff_address->country = $request->dropoff_country;
        $dropoff_address->postal_code = $request->dropoff_postal_code;
        $dropoff_address->latitude = $request->dropoff_latitude;
        $dropoff_address->longitude = $request->dropoff_longitude;
        $dropoff_address->save();

        // Create Order
        $order = new Order();
        $order->package_weight = $request->package_weight;
        $order->package_size_l = $request->package_size_l;
        $order->package_size_w = $request->package_size_w;
        $order->package_size_h = $request->package_size_h;
        $order->pickup_address_id = $pickup_address->id;
        $order->dropoff_address_id = $dropoff_address->id;
        $user = Auth::user();

        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $client = Client::where('user_id', $user->id)->first();

        if (!$client) {
            return response()->json(['error' => 'Client profile not found.'], 404);
        }


// Then assign client_id to the order
        $order->client_id = $client->id;

        // $order->urgency=$request->urgency;
        // $order->urgency=true;

        /*     $pickupLat = $pickup_address->latitude;
        $pickupLng = $pickup_address->longitude;
        $dropoffLat = $dropoff_address->latitude;
        $dropoffLng = $dropoff_address->longitude;

        // Get All Approved Drivers
   $drivers = Driver::where('status', 'approved')->get();
        $matching_drivers = []; // Array to store matching driver names

        // Loop through each driver and calculate distances
        foreach ($drivers as $driver) {
            $driverLat = $driver->area->latitude;
            $driverLng = $driver->area->longitude;

            // Calculate distance from driver’s area to dropoff address
            $distance_driver = $this->getDistanceInKm($driverLat, $driverLng, $dropoffLat, $dropoffLng);

            // Calculate distance from pickup address to dropoff address (client's distance)
            $distance_client = $this->getDistanceInKm($pickupLat, $pickupLng, $dropoffLat, $dropoffLng);

            // Check if driver's area distance is less than or equal to the client's distance
            if ($distance_driver <= $distance_client) {
                $matching_drivers[] = $driver->user->name;
            }
        }*/

        $order->driver_id=null;
        $order->save();




        return redirect()->route('orders.showAssignDriverForm',['id'=>$order->id]);
        /*  return response()->json([
              "message" => "Order created successfully",
              "order" => $order,
              "pickup" => $pickup_address,
              "dropoff" => $dropoff_address,

              //"matching_drivers" => $matching_drivers, // Include matching driver names
          ]);*/
        // return redirect()->route('client.request_order');
    }

    public function calculateDistance($orderId)
    {
        // Find the order by its ID
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // Get the pickup and dropoff addresses
        $pickupAddress = Address::find($order->pickup_address_id);
        $dropoffAddress = Address::find($order->dropOff_address_id);

        if (!$pickupAddress || !$dropoffAddress) {
            return response()->json(['error' => 'Pickup or dropoff address not found'], 404);
        }

        // Extract latitude and longitude
        $pickupLat = $pickupAddress->latitude;
        $pickupLng = $pickupAddress->longitude;
        $dropoffLat = $dropoffAddress->latitude;
        $dropoffLng = $dropoffAddress->longitude;

        // Calculate the distance (in kilometers)
        $distance = $this->getDistanceInKm($pickupLat, $pickupLng, $dropoffLat, $dropoffLng);

        // Update the order's distance_km
        $order->distance_km = $distance;
        $order->save();

        // Return the distance
        return response()->json(['distance_km' => $distance]);
    }

    private function getDistanceInKm($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Radius of the earth in kilometers

        $dLat = deg2rad($lat2 - $lat1);  // Difference in latitude
        $dLng = deg2rad($lng2 - $lng1);  // Difference in longitude

        // Haversine formula
        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) * sin($dLng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Distance in kilometers
        return $earthRadius * $c;
    }

    public function client_error(){
        return view('client.error');
    }


    public function find_time()
    {
        $now = Carbon::now('Asia/Beirut');
        $time = $now->toTimeString();

        $availabilities = Availability::where('status', 'available')->get();

        foreach ($availabilities as $available) {
            if (
                $available->start_time <= $time &&
                $available->end_time >= $time
            ) {
                return response()->json($available->id);
            }
        }

        return "not available";
    }





}
