<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Area;
use App\Models\Availability;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverMenuController extends Controller
{
    public function index(){
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $driver = Driver::where('user_id', $user->id)->first();
        $pendingCount = Order::where('driver_id', $driver->id)->where('status', 'pending')->count();
        $processingCount = Order::where('driver_id', $driver->id)->where('status', 'processing')->count();
        $deliveredCount = Order::where('driver_id', $driver->id)->where('status', 'completed')->count();
        $cancelledCount = Order::where('driver_id', $driver->id)->where('status', 'cancelled')->count();
        // Get processing orders first
        $processingOrders = Order::with(['pickupAddress', 'dropoffAddress'])
            ->where('driver_id', $driver->id)
            ->where('status', 'processing')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get other orders
        $otherOrders = Order::with(['pickupAddress', 'dropoffAddress'])
            ->where('driver_id', $driver->id)
            ->where('status', '!=', 'processing')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Merge and take the first 5
        $recentOrders = $processingOrders->concat($otherOrders)->take(5);
        return view('driver.driverMenu', compact('user', 'driver', 'pendingCount', 'processingCount', 'deliveredCount', 'cancelledCount', 'recentOrders'));
    }

    public function myProfile(){
        $userId = Auth::user()->id;
        $user = User::find($userId);

        $driver = Driver::where('user_id', $userId)->first();
        //return $driver;
        return view('driver.myProfile', compact('user', 'driver'));
    }

    public function pendingOrders(){
        $userId = Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $orders = Order::with(['pickupAddress', 'dropoffAddress'])->where('driver_id', $driver->id)->where('status', 'pending')->get();
        foreach ($orders as $order) {
            $order->pickupAddress = $order->pickupAddress()->first();
            $order->dropoffAddress = $order->dropoffAddress()->first();
            $order->client = $order->client()->first();
        }
        return view('driver.pendingOrders', compact('orders'));
    }

    public function inProcessOrders(){
        $userId = Auth::user()->id;
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
        $userId = Auth::user()->id;
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
        $userId = Auth::user()->id;
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
        $userId = Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();

        $availabilityIds = \DB::table('driver_availabilities')
            ->where('driver_id', $driver->id)
            ->pluck('availability_id')
            ->toArray();

        $availabilities = Availability::whereIn('id', $availabilityIds)->get();

        return view('driver.manageAvailability', compact('availabilities', 'driver'));
    }

    public function areaAndPricing(){
        $userId = Auth::user()->id;
        $driver = Driver::with(['area'])->where('user_id', $userId)->first();
        return view('driver.AreaAndPricing', compact('driver'));
    }

    public function OrderDetails($orderId){
        $userId = Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $order = Order::with(['pickupAddress', 'dropoffAddress', 'client'])->where('id', $orderId)->where('driver_id', $driver->id)->first();
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

            $allPayments = Payment::where('order_id', $order->id)
                ->whereIn('status', ['pending', 'paid'])
                ->where(function($query) {
                    $query->whereNotNull('payment_amount')
                          ->where('payment_amount', '>', 0);
                })
                ->orderBy('remaining_amount', 'asc')
                ->get();
            $allPayments = $allPayments ? $allPayments : null;

            return view('driver.OrderDetails', compact('order', 'clientUser', 'payment', 'allPayments'));
        } else {
            return redirect()->back()->with('error', 'Order not found.');
        }
    }

    public function myCalendar(){
        $userId = Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $orders = Order::with(['pickupAddress', 'dropoffAddress'])
            ->where('driver_id', $driver->id)
            ->whereIn('status', ['completed', 'processing'])
            ->get();
        
        $availabilityIds = \DB::table('driver_availabilities')
            ->where('driver_id', $driver->id)
            ->pluck('availability_id')
            ->toArray();

        $availabilities = Availability::whereIn('id', $availabilityIds)->get();

        $unscheduledOrders = Order::with(['pickupAddress', 'dropoffAddress'])
            ->where('driver_id', $driver->id)
            ->whereIn('status', ['processing'])
            ->whereNull('delivery_date')
            ->get();

        //$unscheduledOrderscount = $unscheduledOrders->count();

        return view('driver.Calendar', compact('orders', 'availabilities', 'unscheduledOrders'));
    }

    public function myReviews(){
        $userId = Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        $orderIds = Order::where('driver_id', $driver->id)->pluck('id')->toArray();
        $reviews = Review::whereIn('order_id', $orderIds)->get();
        foreach ($reviews as $review) {
            $client = $review->client()->first();
            $review->client_name = $client ? $client->user->name : null;
            
            $review->order_tracking_code = $review->order()->first() ? $review->order()->first()->tracking_code : null;
        }

        $averageRating = $reviews->avg('rating');
        return view('driver.myReviews', compact('reviews', 'averageRating'));
    }

    public function myEarnings(){
        $userId = Auth::user()->id;
        $driver = Driver::where('user_id', $userId)->first();
        
        // Get all orders for this driver
        $orders = Order::where('driver_id', $driver->id)->get();
        
        // Initialize variables for totals
        $totalPaidAmount = 0;
        $totalPendingAmount = 0;
        $totalRemainingAmount = 0;
        $totalOrdersAmount = 0;
        
        $mergedPayments = [];
        
        // Process each order
        foreach ($orders as $order) {
            $orderPayments = Payment::where('order_id', $order->id)
                ->whereIn('status', ['paid', 'pending'])
                ->get();
            
            if ($orderPayments->count() > 0) {
                // Use the first payment as reference for common data
                $referencePayment = $orderPayments->sortBy('remaining_amount')->first();
                
                // Calculate paid, pending, and total amounts for this order
                $paidAmount = $orderPayments->where('status', 'paid')->sum('payment_amount');
                $pendingAmount = $orderPayments->where('status', 'pending')->sum('payment_amount');
                $totalAmount = $referencePayment->total_amount;
                $remainingAmount = $referencePayment->remaining_amount;
                
                // Create the merged payment record
                $mergedPayments[] = [
                    'order_id' => $order->id,
                    'client_id' => $referencePayment->client_id,
                    'remaining_amount' => $remainingAmount,
                    'paid_amount' => $paidAmount,
                    'pending_amount' => $pendingAmount,
                    'total_amount' => $totalAmount,
                    'currency' => $referencePayment->currency,
                    'client_name' => $referencePayment->client()->first() ? $referencePayment->client()->first()->user->name : null,
                    'order_tracking_code' => $order->tracking_code,
                ];
                
                // Add to totals
                $totalPaidAmount += $paidAmount;
                $totalPendingAmount += $pendingAmount;
                $totalRemainingAmount += $remainingAmount;
                $totalOrdersAmount += $totalAmount;
            }
        }

        //return compact('mergedPayments', 'totalPaidAmount', 'totalPendingAmount', 'totalRemainingAmount', 'totalOrdersAmount');

        return view('driver.myEarnings', compact(
            'mergedPayments',
            'totalPaidAmount',
            'totalPendingAmount',
            'totalRemainingAmount',
            'totalOrdersAmount'
        ));
    }

    public function storeFCMtoken(Request $request)
    {
        $request->validate([
            'device_token' => 'required|string',
        ]);

        $user = User::find(Auth::user()->id);
        $user->FCM_token = $request->device_token; // Use your existing column
        $user->save();

        return response()->json(['message' => 'FCM token saved successfully']);
    }
}
