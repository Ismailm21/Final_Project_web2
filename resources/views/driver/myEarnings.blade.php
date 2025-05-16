@extends('driver.fixedLayout')

@section('title', 'Your Earnings')

@section('page_title', 'Earnings')

@section('page-content')
    <div class="space-y-6">
        <!-- Earnings Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Profit Card -->
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                <p class="text-sm text-gray-500 font-medium">Total Profit</p>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-gray-800">${{ number_format($totalOrdersAmount, 2) }}</span>
                    <span class="ml-2 text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-800">100%</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Lifetime earnings across all orders</p>
            </div>

            <!-- Realized Profit Card -->
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                <p class="text-sm text-gray-500 font-medium">Realized Profit</p>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-gray-800">${{ number_format($totalPaidAmount, 2) }}</span>
                    <span class="ml-2 text-xs px-2 py-1 rounded-full bg-green-100 text-green-800">{{ round(($totalPaidAmount / max($totalOrdersAmount, 1)) * 100) }}%</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Money you've already earned</p>
            </div>

            <!-- Pending Profit Card -->
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                <p class="text-sm text-gray-500 font-medium">Pending Profit</p>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-gray-800">${{ number_format($totalPendingAmount, 2) }}</span>
                    <span class="ml-2 text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">{{ round(($totalPendingAmount / max($totalOrdersAmount, 1)) * 100) }}%</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Payments you need to accept</p>
            </div>

            <!-- Remaining Profit Card -->
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-purple-500">
                <p class="text-sm text-gray-500 font-medium">Remaining Profit</p>
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-gray-800">${{ number_format($totalRemainingAmount, 2) }}</span>
                    <span class="ml-2 text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-800">{{ round(($totalRemainingAmount / max($totalOrdersAmount, 1)) * 100) }}%</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Future payments not yet created</p>
            </div>
        </div>

        <!-- Profit Breakdown Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Profit Breakdown</h3>
            <div class="w-full h-8 rounded-full overflow-hidden bg-gray-200">
                @php
                    $paidWidth = ($totalOrdersAmount > 0) ? ($totalPaidAmount / $totalOrdersAmount) * 100 : 0;
                    $pendingWidth = ($totalOrdersAmount > 0) ? ($totalPendingAmount / $totalOrdersAmount) * 100 : 0;
                    $remainingWidth = ($totalOrdersAmount > 0) ? ($totalRemainingAmount / $totalOrdersAmount) * 100 : 0;
                @endphp
                <div class="flex h-full">
                    <div class="bg-green-500 h-full" style="width: {{ $paidWidth }}%"></div>
                    <div class="bg-yellow-500 h-full" style="width: {{ $pendingWidth }}%"></div>
                    <div class="bg-purple-500 h-full" style="width: {{ $remainingWidth }}%"></div>
                </div>
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <div class="flex items-center">
                    <span class="w-3 h-3 inline-block rounded-full bg-green-500 mr-1"></span>
                    <span class="text-gray-600">Realized: ${{ number_format($totalPaidAmount, 2) }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 inline-block rounded-full bg-yellow-500 mr-1"></span>
                    <span class="text-gray-600">Pending: ${{ number_format($totalPendingAmount, 2) }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 inline-block rounded-full bg-purple-500 mr-1"></span>
                    <span class="text-gray-600">Remaining: ${{ number_format($totalRemainingAmount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment History Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Payment History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Tracking Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pending</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remaining</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($mergedPayments as $payment)
                            @php
                                $status = 'Completed';
                                $statusColor = 'green';
                                
                                if ($payment['pending_amount'] > 0 && $payment['remaining_amount'] > 0) {
                                    $status = 'Partially Paid';
                                    $statusColor = 'yellow';
                                } elseif ($payment['pending_amount'] > 0) {
                                    $status = 'Processing';
                                    $statusColor = 'yellow';
                                } elseif ($payment['remaining_amount'] > 0) {
                                    $status = 'Partially Completed';
                                    $statusColor = 'blue';
                                }
                            @endphp
                            <tr onclick="window.location='{{ route('driver.viewOrderDetails', ['id' => $payment['order_id']]) }}'" class="cursor-pointer hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $payment['order_tracking_code'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment['client_name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment['currency'] }} {{ number_format($payment['total_amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                    {{ $payment['currency'] }} {{ number_format($payment['paid_amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">
                                    {{ $payment['currency'] }} {{ number_format($payment['pending_amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-purple-600">
                                    {{ $payment['currency'] }} {{ number_format($payment['remaining_amount'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection