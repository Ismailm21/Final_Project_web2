@extends('driver.fixedLayout')

@section('title', 'In Process Orders')

@section('page_title', 'In Process Orders')

@section('page-content')
    <div class="space-y-6">
        <h2 class="text-xl font-semibold">You are currently processing the following orders</h2>
        
        @if($orders->isEmpty())
            <p class="text-gray-500 text-center py-4">No orders in process at the moment.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">#{{ $order->tracking_code }}</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                Processing
                            </span>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l1-2a2 2 0 012-1h12a2 2 0 012 1l1 2m-1 4v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6m16 0H4m5 0v6m6-6v6"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Package Details</p>
                                    <p class="text-sm text-gray-500">
                                        Weight: {{ $order->package_weight }} kg<br>
                                        Size: {{ $order->package_size_l }}x{{ $order->package_size_w }}x{{ $order->package_size_h }} cm
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Pickup Address</p>
                                    <p class="text-sm text-gray-500">{{ $order->pickupAddress->type . ', ' . $order->pickupAddress->city . ', ' . $order->pickupAddress->state . ', ' . $order->pickupAddress->street . ', ' . ($order->pickupAddress->country ?? 'N/A') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center mt-2">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium">Dropoff Address</p>
                                    <p class="text-sm text-gray-500">{{ $order->dropoffAddress->type . ', ' . $order->dropoffAddress->city . ', ' . $order->dropoffAddress->state . ', ' . $order->dropoffAddress->street . ', ' . ($order->dropoffAddress->country ?? 'N/A') }}</p>
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
        @endif
    </div>
@endsection