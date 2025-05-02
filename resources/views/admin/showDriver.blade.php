@extends('admin.admin') {{-- Assuming you're using a layout file --}}

@section('title', 'Driver Profile')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow rounded-xl p-6">
            <h2 class="text-2xl font-semibold mb-4">Driver Profile</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-600"><strong>Name:</strong> {{ $driver->name }}</p>
                    <p class="text-gray-600"><strong>Email:</strong> {{ $driver->email }}</p>
                    <p class="text-gray-600"><strong>Phone:</strong> {{ $driver->phone }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>License Number:</strong> {{ $driver->license_number }}</p>
                    <p class="text-gray-600"><strong>Status:</strong>
                        <span
                            class="px-2 py-1 rounded-full text-white {{ $driver->status === 'available' ? 'bg-green-500' : 'bg-red-500' }}">
                        {{ ucfirst($driver->status) }}
                    </span>
                    </p>
                    <p class="text-gray-600"><strong>Joined At:</strong> {{ $driver->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('drivers.edit', $driver->id) }}"
                   class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Edit Profile
                </a>
                <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" class="inline-block ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                        Delete Driver
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
