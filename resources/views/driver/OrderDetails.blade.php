@extends('driver.fixedLayout')

@section('title', 'Order Details')

@section('page_title', 'Order #'.$order->tracking_code.' Details')

@section('page-content')
<div class="container">
    @if(session('success'))
    <div class="bg-green-50 text-green-600 p-4 rounded">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="card-body space-y-6 p-4">
                    @if(isset($order))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Customer Information -->
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-user-circle text-blue-500 text-xl mr-4"></i>
                                    <div>
                                        <p class="text-base font-semibold text-gray-800">Customer Information</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="font-medium">Name:</span> {{ $clientUser->name }}<br>
                                            <span class="font-medium">Email:</span> {{ $clientUser->email }}<br>
                                            <span class="font-medium">Phone:</span> {{ $clientUser->phone }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Pickup Location -->
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-green-500 text-xl mr-4"></i>
                                    <div>
                                        <p class="text-base font-semibold text-gray-800">Pickup Location</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $order->pickupAddress->type . ', ' . $order->pickupAddress->city . ', ' . $order->pickupAddress->state . ', ' . $order->pickupAddress->street . ', ' . ($order->pickupAddress->country ?? 'N/A') }}</p>
                                    </div>
                                </div>
                            </div>



                            <!-- Order Details -->
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-yellow-500 text-xl mr-4"></i>
                                    <div>
                                        <p class="text-base font-semibold text-gray-800">Order Details</p>
                                        <p class="text-sm text-gray-600 mt-1">Order #{{ $order->tracking_code }}</p>
                                        <p class="text-sm text-gray-600">Total Price: <span class="font-medium">${{$payment->amount}}</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Drop-off Location -->
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <i class="fas fa-flag-checkered text-red-500 text-xl mr-4"></i>
                                    <div>
                                        <p class="text-base font-semibold text-gray-800">Drop-off Location</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $order->dropoffAddress->type . ', ' . $order->dropoffAddress->city . ', ' . $order->dropoffAddress->state . ', ' . $order->dropoffAddress->street . ', ' . ($order->dropoffAddress->country ?? 'N/A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Status -->
                            <div class="bg-gray-50 rounded-lg p-4 shadow-sm md:col-span-2">
                                <div class="flex items-center">
                                    <i class="fas fa-clipboard-check text-blue-500 text-xl mr-4"></i>
                                    <div>
                                        <p class="text-base font-semibold text-gray-800">Order Status</p>
                                        <p class="text-sm mt-1">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $order->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 border-t pt-4">
                            <p class="text-base font-semibold text-gray-800 mb-3">Update Order Status:</p>
                            <form action="{{route('driver.updateOrderStatusByDriver')}}" method="POST" class="flex flex-wrap items-center gap-3">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <select name="status" class="border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option disabled selected>Select status</option>
                                    @if($order->status === 'processing')
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    @elseif($order->status === 'completed')
                                        <option value="processing">Processing</option>
                                        <option value="cancelled">Cancelled</option>
                                    @elseif($order->status === 'cancelled')
                                        <option value="completed">Completed</option>
                                        <option value="processing">Processing</option>     
                                    @endif
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm font-medium flex items-center">
                                    <i class="fas fa-sync-alt mr-2"></i> Update Status
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 flex justify-end gap-4">
                            
                                <button 
                                    onclick="window.location.href='{{route('driver.inProcessOrders', ['id' => $order->id])}}'"
                                    class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition-colors text-sm font-medium flex items-center"
                                >
                                    <i class="fas fa-list-ul mr-2"></i> View All Processing Orders
                                </button>
                            
                                <button 
                                    onclick="window.location.href='{{route('driver.completedOrders', ['id' => $order->id])}}'"
                                    class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors text-sm font-medium flex items-center"
                                >
                                    <i class="fas fa-check-circle mr-2"></i> View All Completed Orders
                                </button>
                            
                                <button 
                                    onclick="window.location.href='{{route('driver.cancelledOrders', ['id' => $order->id])}}'"
                                    class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition-colors text-sm font-medium flex items-center"
                                >
                                    <i class="fas fa-ban mr-2"></i> View All Cancelled Orders
                                </button>
                            
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-exclamation-circle text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500 font-medium">No order details available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .space-y-4 > * + * {
        margin-top: 1rem;
    }
    .flex {
        display: flex;
    }
    .items-center {
        align-items: center;
    }
    .justify-end {
        justify-content: flex-end;
    }
    .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .transition-colors {
        transition-property: background-color, border-color, color, fill, stroke;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
@endsection