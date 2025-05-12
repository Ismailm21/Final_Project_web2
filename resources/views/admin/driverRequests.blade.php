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
                <th>Day</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($pending_drivers as $driver)
                <tr class="border-b">
                    <td class="p-2">{{ $driver->name }}</td>
                    <td class="p-2">{{ $driver->email }}</td>
                    <td class="p-2">{{ $driver->phone }}</td>
                    <td class="p-2">{{ $driver->license_number }}</td>
                    @foreach($pending_availabilities as $pending_availability )
                        @php$driver_availabilities = $pending_availabilities->where('pending_id', $driver->id); @endphp
                        <td class="p-2">{{ $availability->day }}</td>
                        <td class="p-2">{{ $availability->start_time }}</td>
                        <td class="p-2">{{ $availability->end_time }}</td>
                    @endforeach
                    <td class="flex gap-2">
                        <form action="{{ route('admin.driver.request.handle', ['id' => $driver->id, 'action' => 'approve']) }}" method="POST">
                            @csrf
                            <button id="approve" class="bg-green-500 text-white px-3 py-1 rounded">Approve</button>
                        </form>
                        <form action="{{ route('admin.driver.request.handle', ['id' => $driver->id, 'action' => 'deny']) }}" method="POST">
                            @csrf
                            <button id="deny" class="bg-red-500 text-white px-3 py-1 rounded">Deny</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
