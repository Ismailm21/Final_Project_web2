<!-- resources/views/admin.blade.php -->

@extends('admin.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <section id="drivers">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Driver</h2>
            <form id="driver-form" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <input type="text" placeholder="Name" class="border p-2 rounded"/>
                <input type="text" placeholder="License Number" class="border p-2 rounded"/>
                <input type="text" placeholder="Phone Number" class="border p-2 rounded"/>
                <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Save
                    Driver
                </button>
            </form>
        </div>
    </section>
@endsection
