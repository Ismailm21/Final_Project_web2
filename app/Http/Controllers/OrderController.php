<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
class OrderController extends Controller
{

    public function autoAssignDriver($orderId)
    {
        $order = Order::with('pickupAddress')->findOrFail($orderId);

        $pickupLat = $order->pickupAddress->latitude;
        $pickupLng = $order->pickupAddress->longitude;

        // Find the nearest approved driver based on area coordinates
        $nearestDriver = DB::table('drivers')
            ->join('areas', 'drivers.area_id', '=', 'areas.id')
            ->select(
                'drivers.id',
                DB::raw("(
                6371 * acos(
                    cos(radians($pickupLat)) *
                    cos(radians(areas.latitude)) *
                    cos(radians(areas.longitude) - radians($pickupLng)) +
                    sin(radians($pickupLat)) *
                    sin(radians(areas.latitude))
                )
            ) AS distance")
            )
            ->where('drivers.status', 'approved')
            ->orderBy('distance')
            ->first();

        if (!$nearestDriver) {
            return response()->json(['message' => 'No available drivers found.'], 404);
        }

        // ✅ Update the order with selected driver

        $order->update([
            'driver_id' => $nearestDriver->id
        ]);
        $order->save();



        $user = User::find($nearestDriver->id); //get the user by driverId
        $fcm = $user->FCM_token;
        if (!$fcm) {

            return response()->json(['message' => 'User does not have a device token'], 400);

        }
        $title = "New Order Alert";
        $description = "You have a new order! Please check your pending orders.";
        $projectId = "quickdeliver-709e2";
        $credentialsFilePath = Storage::path('/file.json');
        if (!file_exists($credentialsFilePath)) {
            return response()->json(['message' => 'Credentials file not found'], 404);

        }
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $token = $client->fetchAccessTokenWithAssertion();
        $access_token = $token['access_token'];
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];
        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => $title,
                    "body" => $description,
                ],
                "webpush" => [
                    "fcm_options" => [
                        "link" => route('driver.pendingOrders') //The driver will be redirected to this link
                    ],
                    "notification" => [
                        "click_action" => route('driver.pendingOrders') // The driver will be redirected to this link
                    ]
                ],
                "data" => [
                    "route_name" => "driver.pendingOrders" // The driver will be redirected to this link

                ]
            ]
        ];
        $payload = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);



        /*return response()->json([
            'message' => 'Driver auto-assigned successfully.',
            'driver_id' => $nearestDriver->id,
            'order_id' => $order->id,
            'distance_km' => round($nearestDriver->distance, 2)
        ]);*/
        //return redirect()->back()->with('success', 'Driver auto-assigned successfully. ID: ' . $nearestDriver->id . ', Distance: ' . round($nearestDriver->distance, 2) . ' km');
        return redirect()->route('payment.form', $order->id)
            ->with('success', 'Driver assigned successfully.');
    }

    public function assignDriverManually(Request $request, $orderId)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);
        //$order = Order::findOrFail($orderId);
        $order = Order::findOrFail($orderId);
        $order->update([
            'driver_id' => $request->driver_id
        ]);
        $order->save();
       // return response()->json(['message' => 'Driver assigned manually.', 'order_id' => $order->id]);
        return redirect()->route('orders.showAssignDriverForm', $order->id)
            ->with('success', 'Driver assigned successfully.');
    }
    public function showAssignDriverForm($id)
    {
        $order = Order::with('pickupAddress')->findOrFail($id);

        // You may want to fetch only approved drivers
        $drivers = Driver::with('user')->where('status', 'approved')->get();

        return view('client.order', compact('order', 'drivers'));
    }

    public function showDriverProfile($order_id)
    {
        $order = Order::with('driver.user')->find($order_id);

        if (!$order || !$order->driver) {
            return response()->json(['message' => 'Driver not found for this order'], 404);
        }

        $driver = $order->driver;
        $user = $driver->user;

        // Get all completed orders assigned to this driver
        $completedOrderIds = Order::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->pluck('id');

        // Fetch all reviews for those orders
        $reviews = Review::whereIn('order_id', $completedOrderIds)
            ->get()
            ->map(function ($review) {
                return [
                    'review_id' => $review->id,
                    'order_id' => $review->order_id,
                    'rating' => $review->rating,
                    'review' => $review->review,
                    'created_at' => $review->created_at->toDateTimeString(),
                ];
            });

        return view('client.view-driver-profile',   [
        'driver' => $user,
        'driverModel' => $driver,
        'reviews' => $reviews, 'order' => $order
    ]);
    }
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }



}
