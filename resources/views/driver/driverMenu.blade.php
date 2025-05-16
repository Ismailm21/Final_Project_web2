@extends('driver.fixedLayout')

@section('title', 'Driver Home Menu')

@section('page_title', 'Driver Menu')

@section('page-content')
    <style>
        @keyframes pulseBorder {
            0%, 100% {
                border-color: transparent;
            }
            50% {
                border-color: lightblue;
            }
        }
        
        .animate-pulse-border {
            animation: pulseBorder 1.5s ease-in-out infinite;
        }
    </style>
    <div class="space-y-6">
        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- Pending Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" onclick="window.location='{{route('driver.pendingOrders')}}'" style="cursor: pointer;">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Pending Orders</h3>
                    <div class="w-12 h-12 rounded-full border-4 border-red-500 border-dashed flex items-center justify-center animate-pulse-border">
                        <span class="text-xl font-bold text-gray-700">
                            @if(isset($pendingCount))
                                {{ $pendingCount }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Processing Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" onclick="window.location='{{route('driver.inProcessOrders')}}'" style="cursor: pointer;">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Processing Orders</h3>
                    <div class="w-12 h-12 rounded-full border-4 border-yellow-400 flex items-center justify-center">
                        <span class="text-xl font-bold text-gray-700">
                            @if(isset($processingCount))
                                {{ $processingCount }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Delivered Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" onclick="window.location='{{route('driver.completedOrders')}}'" style="cursor: pointer;">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Delivered Orders</h3>
                    <div class="w-12 h-12 rounded-full border-4 border-green-500 flex items-center justify-center">
                        <span class="text-xl font-bold text-gray-700">
                            @if(isset($deliveredCount))
                                {{ $deliveredCount }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Cancelled Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200" onclick="window.location='{{route('driver.cancelledOrders')}}'" style="cursor: pointer;">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Cancelled Orders</h3>
                    <div class="w-12 h-12 rounded-full border-4 border-red-500 flex items-center justify-center">
                        <span class="text-xl font-bold text-gray-700">
                            @if(isset($cancelledCount))
                                {{ $cancelledCount }}
                            @else
                                0
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Section -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 min-h-[400px]">
            <h2 class="text-xl font-medium mb-4">Recent Activity</h2>
            @if(isset($recentOrders) && count($recentOrders) > 0)
            <div class="grid gap-6">
                @foreach($recentOrders as $order)
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">#{{ $order->tracking_code }}</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm
                                @if($order->status === 'pending')
                                   bg-blue-100 text-blue-900 animate-pulse border-4 border-blue-400 border-dotted
                                @elseif($order->status === 'processing')
                                    bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'completed')
                                    bg-green-100 text-green-800
                                @else
                                    bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l1-2a2 2 0 012-1h12a2 2 0 012 1l1 2m-1 4v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4m5 0v6m6-6v6"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Order Details</p>
                                    <p class="text-sm text-gray-500">Weight: {{ $order->package_weight }} kg<br>
                                        Size: {{ $order->package_size_l }}x{{ $order->package_size_w }}x{{ $order->package_size_h }} cm</p>
                                    
                                </div>
                            </div>
        
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Pickup Address</p>
                                    <p class="text-sm text-gray-500">{{$order->pickupAddress->city . ', ' . $order->pickupAddress->state . ', ' . $order->pickupAddress->street . ', ' . ($order->pickupAddress->country ?? 'N/A') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Dropoff Address</p>
                                    <p class="text-sm text-gray-500">{{$order->dropoffAddress->city . ', ' . $order->dropoffAddress->state . ', ' . $order->dropoffAddress->street . ', ' . ($order->dropoffAddress->country ?? 'N/A') }}</p>
                                </div>
                            </div>
                        </div>
        
                        <div class="mt-4 flex justify-end">
                            <button 
                                onclick="window.location.href='{{route('driver.viewOrderDetails', ['id' => $order->id])}}'"
                                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors text-sm"
                            >
                                View Details
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-[300px]">
                <p class="text-gray-400">No recent activity to display</p>
            </div>
        @endif
        </div>
    </div>
@endsection