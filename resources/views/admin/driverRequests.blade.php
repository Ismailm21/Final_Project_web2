@extends('admin.admin')

@section('title', 'Driver Requests')

@section('content')
    <div class="p-6 bg-white rounded shadow">
        <h2 class="text-xl font-semibold mb-4">Pending Driver Requests</h2>

        @if (session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="text-red-600">{{ session('error') }}</div>
        @endif

        <table class="w-full table-auto">
            <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pending_drivers as $driver)
                <tr class="border-b">
                    <td class="p-2">{{ $driver->name }}</td>
                    <td>{{ $driver->email }}</td>
                    <td>{{ $driver->phone }}</td>
                    <td>{{ $driver->license_number }}</td>
                    <td class="flex gap-2">
                        <form action="{{ route('admin.driver.request.handle', ['id' => $driver->id, 'action' => 'approve']) }}" method="POST">
                            @csrf
                            <button class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                        </form>
                        <form action="{{ route('admin.driver.request.handle', ['id' => $driver->id, 'action' => 'deny']) }}" method="POST">
                            @csrf
                            <button class="bg-red-500 text-white px-3 py-1 rounded">Deny</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
