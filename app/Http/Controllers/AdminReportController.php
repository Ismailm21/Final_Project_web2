<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{public function reports(Request $request)
{
    $D_count = Driver::where('status', 'approved')->count();
    $active_orders_count = Order::where('status', 'processing')->count();
    $completed_orders_count = Order::where('status', 'completed')->count();
    $from = $request->input('from');
    $to = $request->input('to');

    // Calculate total center share from all payments
    $centerShareTotalAllOrders = Payment::sum('total_amount') * 0.10; // Center gets 10% of all payments

    // Fetch payments with the least remaining amount per order
    $payments = Payment::when($from, function ($query) use ($from) {
            return $query->whereDate('created_at', '>=', $from);
        })
        ->when($to, function ($query) use ($to) {
            return $query->whereDate('created_at', '<=', $to);
        })
        ->orderBy('remaining_amount', 'asc') // Prioritize least remaining amount
        ->get()
        ->unique('order_id'); // Ensure only one payment per order

    // Map payments to reports
    $detailedReports = $payments->map(function ($payment) {
        $totalPaid = $payment->total_amount ?? 0;
        $remaining = $payment->remaining_amount ?? 0;
        $driverShare = $totalPaid * 0.90;
        $centerShare = $totalPaid * 0.10;

        return [
            'order_id' => $payment->order_id,
            'total_paid' => $totalPaid,
            'remaining' => $remaining,
            'driver_share' => $driverShare,
            'driver_percent' => 90,
            'center_share' => $centerShare,
            'center_percent' => 10,
        ];
    });

    return view('admin.delivery_reports', [
        'detailedReports' => $detailedReports,
        'centerShareTotal' => $detailedReports->sum('center_share'),
        'driverShareTotal' => $detailedReports->sum('driver_share'),
        'clients' => $payments->pluck('client_id')->unique()->count(),
        'ordersCount' => $payments->pluck('order_id')->unique()->count(),
        'from' => $from,
        'to' => $to,
        'centerShareTotalAllOrders' => $centerShareTotalAllOrders,
    ], compact(
        'D_count',
        'active_orders_count',
        'completed_orders_count',
        'centerShareTotalAllOrders'
    ));
}
}