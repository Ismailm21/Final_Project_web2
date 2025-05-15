<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reports(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->toDateString());

        $orders = Order::with('client', 'driver') // adapt to your relationships
        ->whereBetween('created_at', [$from, $to])
            ->get();

        $driverShareTotal = 0;
        $centerShareTotal = 0;
        $clients = $orders->pluck('client_id')->unique()->count();
        $ordersCount = $orders->count();

        $detailedReports = $orders->map(function ($order) use (&$driverShareTotal, &$centerShareTotal) {
            $total = $order->total_paid ?? 0;
            $remaining = $order->remaining ?? 0;
            $driverPercent = $order->driver_percentage ?? 20; // default to 20% if not set
            $driverAmount = $total * $driverPercent / 100;
            $centerAmount = $total - $driverAmount;

            $driverShareTotal += $driverAmount;
            $centerShareTotal += $centerAmount;

            return [
                'total_paid' => $total,
                'remaining' => $remaining,
                'driver_share' => $driverAmount,
                'driver_percent' => $driverPercent,
                'center_share' => $centerAmount,
                'center_percent' => 100 - $driverPercent,
            ];
        });

        return view('admin.delivery_reports', compact(
            'driverShareTotal',
            'centerShareTotal',
            'clients',
            'ordersCount',
            'detailedReports',
            'from',
            'to'
        ));
    }
}
