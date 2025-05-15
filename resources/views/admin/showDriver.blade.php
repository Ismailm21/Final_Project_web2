@extends('admin.admin')

@section('title', 'Driver Profile')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-2">Driver Profile</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- User Information -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Personal Info</h3>
                <ul class="space-y-1 text-gray-600">
                    <li><strong>Name:</strong> {{ $driver->user->name ?? ''}}</li>
                    <li><strong>Email:</strong> {{ $driver->user->email ?? ''}}</li>
                    <li><strong>Phone:</strong> {{ $driver->user->phone ?? ''  }}</li>
                </ul>
            </div>

            <!-- Driver Details -->
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Vehicle Info</h3>
                <ul class="space-y-1 text-gray-600">
                    <li><strong>Vehicle Type:</strong> {{ $driver->vehicle_type }}</li>
                    <li><strong>Vehicle Number:</strong> {{ $driver->vehicle_number }}</li>
                    <li><strong>License:</strong> {{ $driver->license }}</li>
                    <li><strong>Pricing Model:</strong> {{ $driver->pricing_model }}</li>
                    @if($driver->pricing_model == 'fixed')
                        <li><strong>Fixed Rate:</strong> ${{ $driver->fixed_rate }}</li>
                    @else
                        <li><strong>Rate per KM:</strong> ${{ $driver->rate_per_km }}</li>
                    @endif
                    <li><strong>Status:</strong>
                        <span class="inline-block px-2 py-1 rounded text-white
                        {{ $driver->status == 'approved' ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ ucfirst($driver->status) }}
                    </span>
                    </li>
                    <li><strong>Rating:</strong> ⭐ {{ $driver->rating }}</li>
                </ul>
            </div>
        </div>

        <!-- Optional: Add a back button -->
        <div class="mt-6">
            <a href="{{ route('admin.driver') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                ← Back to Driver List
            </a>
        </div>
    </div>
@endsection
