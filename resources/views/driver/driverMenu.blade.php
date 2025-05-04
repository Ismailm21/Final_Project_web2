@extends('driver.fixedLayout')

@section('title', 'Driver Home Menu')

@section('page_title', 'Driver Menu')

@section('page-content')
    <div class="space-y-6">
        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-700">Pending Orders</h3>
                    <div class="w-12 h-12 rounded-full border-4 border-yellow-400 flex items-center justify-center">
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

            <!-- Delivered Orders Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
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
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
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
                <!-- Add your data display logic here -->
                <p class="text-gray-500">Recent orders will appear here</p>
            @else
                <div class="flex items-center justify-center h-[300px]">
                    <p class="text-gray-400">No recent activity to display</p>
                </div>
            @endif
        </div>
    </div>
@endsection