@extends('admin.admin')
@section('title', 'Orders')

@section('content')
<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="text-2xl font-bold mb-4">Orders List</h2>

    <!-- Filter Buttons -->
    <div class="mb-4">
        <div class="text-lg font-medium mb-2">Filter by Status:</div>
        <div class="flex flex-wrap gap-2">
            @php
                $statuses = ['all' => 'All', 'pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
            @endphp
            @foreach ($statuses as $key => $label)
                <a href="{{ route('admin.showOrders', ['status' => $key]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium border transition
                          {{ request('status', 'all') === $key ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Orders Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto divide-y divide-gray-200">
            <thead class="bg-gray-50 text-xs font-semibold text-gray-600 uppercase text-left">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Client</th>
                    <th class="px-4 py-3">Driver</th>
                    <th class="px-4 py-3">Pickup</th>
                    <th class="px-4 py-3">Dropoff</th>
                    <th class="px-4 py-3">Weight (kg)</th>
                    <th class="px-4 py-3">Size (L×W×H)</th>
                    <th class="px-4 py-3">Delivery</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Tracking</th>
                    <th class="px-4 py-3">Created</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->client->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $order->driver->user->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $order->pickupAddress->city ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $order->dropoffAddress->city ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $order->package_weight ?? '—' }}</td>
                        <td class="px-4 py-3">
                            {{ $order->package_size_l ?? '—' }}×{{ $order->package_size_w ?? '—' }}×{{ $order->package_size_h ?? '—' }}
                        </td>
                        <td class="px-4 py-3">{{ $order->delivery_date ?? 'N/A' }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                {{ match($order->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-700'
                                } }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $order->tracking_code ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $order->created_at?->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 space-x-1">
                            <button onclick="window.location.href='{{ route('admin.showOrderDetails', ['id' => $order->id]) }}'"
                               class="inline-block bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-xs">
                                View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="px-4 py-6 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
