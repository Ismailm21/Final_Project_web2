@extends('admin.admin')

@section('title', 'Driver')

@section('content')
    <html>
    <body>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Driver List</h2>
        <table class="w-full table-auto border text-left">
            <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Phone</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($drivers as $driver)
                <tr>
                    <td class="border px-4 py-2">{{ $driver->id }}</td>
                    <td class="border px-4 py-2">{{ $driver->name }}</td>
                    <td class="border px-4 py-2">{{ $driver->phone }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <button class="bg-yellow-400 px-2 py-1 rounded text-white">Edit</button>
                        <button class="bg-red-600 px-2 py-1 rounded text-white">Delete</button>
                        <button class="bg-green-600 px-2 py-1 rounded text-white">View</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </body>
    </html>
@endsection
