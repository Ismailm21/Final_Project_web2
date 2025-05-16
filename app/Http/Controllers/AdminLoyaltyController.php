<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltyPoint;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Order; 
use App\Models\Payment; 

class AdminLoyaltyController extends Controller
{
    public function index()
    {
        $D_count = Driver::where('status', 'approved')->count();
        $active_orders_count = Order::where('status', 'processing')->count();
        $completed_orders_count = Order::where('status', 'completed')->count();
        $centerShareTotalAllOrders = Payment::all()->sum(function ($payment) {
    return $payment->total_amount * 0.10; // Center gets 10% of each payment
});
        $loyaltySettings = LoyaltyPoint::all();
        return view('admin.LoyaltyProgram', compact('loyaltySettings','D_count','active_orders_count','completed_orders_count','centerShareTotalAllOrders'));
    }

    public function store(Request $request)
{
    $request->validate([
        'min_points' => 'required|array',
        'max_points' => 'required|array',
        'reward' => 'required|array',
    ]);

    foreach ($request->min_points as $index => $min) {
        LoyaltyPoint::create([
            'client_id' => null, // Set if necessary
            'points' => $min, // Consider storing a range differently if needed
            'reward' => $request->reward[$index],
        ]);
    }

    return redirect()->route('admin.loyalty')->with('success', 'Loyalty program updated!');
}
}