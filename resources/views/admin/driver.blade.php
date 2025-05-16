@extends('admin.admin')

@section('title', 'Driver')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Driver List</h2>

        <!-- Status Filter -->
        <div class="pt-6">
            <label class="text-lg font-medium mb-3 block">Status</label>
            <div class="flex gap-4">
                <div class="mb-3">
                    <input type="radio" class="hidden" id="statusAll" name="status"
                           value="all" {{ request('status', 'all') === 'all' ? 'checked' : '' }}>
                    <label class="btn-check btn-outline-primary rounded-pill px-4 py-2 cursor-pointer {{ request('status', 'all') === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 border border-blue-600' }} rounded-full px-4 py-2" for="statusAll">
                        All
                    </label>
                </div>

                <div class="mb-3">
                    <input type="radio" class="hidden" id="statusPending" name="status"
                           value="pending" {{ request('status') === 'pending' ? 'checked' : '' }}>
                    <label class="btn-check btn-outline-primary rounded-pill px-4 py-2 cursor-pointer {{ request('status') === 'pending' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 border border-blue-600' }} rounded-full px-4 py-2" for="statusPending">
                        Pending
                    </label>
                </div>

                <div class="mb-3">
                    <input type="radio" class="hidden" id="statusApproved" name="status"
                           value="approved" {{ request('status') === 'approved' ? 'checked' : '' }}>
                    <label class="btn-check btn-outline-primary rounded-pill px-4 py-2 cursor-pointer {{ request('status') === 'approved' ? 'bg-blue-600 text-white' : 'bg-white text-blue-600 border border-blue-600' }} rounded-full px-4 py-2" for="statusApproved">
                        Approved
                    </label>
                </div>

            </div>
        </div>

        <table class="w-full table-auto border text-left mt-6">
            <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($drivers as $driver)
                <tr>
                    <td class="border px-4 py-2">{{ $driver->id }}</td>
                    <td class="border px-4 py-2">{{ $driver->user->name ?? '' }}</td>
                    <td class="border px-4 py-2">{{ $driver->user->email ?? '' }}</td>
                    <td class="border px-4 py-2">{{ $driver->user->phone ?? '' }}</td>
                    <td class="border px-4 py-2">{{ $driver->status }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        @if ($driver->status === 'approved')
                            <form method="GET" action="{{ route('admin.editDriver', $driver->id) }}" class="inline">
                                <button type="submit" class="bg-yellow-400 px-2 py-1 rounded text-white">Edit</button>
                            </form>
                            <form method="POST" action="{{ route('admin.deleteDriver', $driver->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 px-2 py-1 rounded text-white">Delete</button>
                            </form>
                            <a href="{{ route('admin.viewDriver', $driver->id) }}" class="bg-green-600 px-2 py-1 rounded text-white inline-block">View</a>
                        @elseif ($driver->status === 'pending')
                            <form method="POST" action="{{ route('admin.acceptDriver', $driver->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-500 px-2 py-1 rounded text-white">Accept</button>
                            </form>
                            <form method="POST" action="{{ route('admin.denyDriver', $driver->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-gray-500 px-2 py-1 rounded text-white">Deny</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- JavaScript to handle status filter changes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all radio buttons
            const statusRadios = document.querySelectorAll('input[name="status"]');

            // Add event listener to each radio button
            statusRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Redirect to the same page with the status parameter
                    window.location.href = '{{ route("admin.driver") }}?status=' + this.value;
                });
            });
        });
    </script>
@endsection
