<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ClientOrders extends Controller
{
    public function listClientOrders(Request $request)
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

        return view('client.view-orders', compact('orders', 'active_orders', 'pending_orders', 'completed_orders', 'D_count', 'active_orders_count', 'completed_orders_count', 'status'));
    }

    public function showReviews($id)
    {
        $order = Order::find($id);
        return view('client.view-reviews', compact('order'));
    }

    public function writeReview(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $review = new Review();
        $review->order_id = $order->id;
        $review->client_id = $order->client_id;
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();

    //    return redirect()->back()->with('success', 'Review submitted successfully!');
        return redirect()->route('client.view-reviews', $order->id);
    }


    public function myCalendarr($id)
    {
        $client = Client::findOrFail($id);
        $clientId = $client->id;

        // Get orders with assigned driver and addresses
        $orders = Order::with([
            'driver.user'  // to get driver name via driver->user->name
        ])
            ->where('client_id', $clientId)
            ->whereIn('status', ['processing', 'completed'])
            ->get();

        // Also get orders without delivery_date yet (unscheduled)
        $unscheduledOrders = Order::with(['driver'])
            ->where('client_id', $clientId)
            ->whereIn('status', ['processing'])
            ->whereNull('delivery_date')
            ->get();

        return view('client.view-calendar', compact('orders', 'unscheduledOrders'));
    }

}
