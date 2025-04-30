<!-- resources/views/admin.blade.php -->

@extends('admin.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <section id="drivers">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Driver</h2>
            <form id="driver-form" action="{{route('admin.save')}}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <input type="text" placeholder="Name" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Phone Number" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Email" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Password" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Area" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Vehicle Type" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Vehicle number" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <input type="text" placeholder="Pricing model" class="col-span-2  border  p-2 rounded invalid:border-red-500"/>
                <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Save
                    Driver
                </button>
            </form>
        </div>
    </section>
@endsection
