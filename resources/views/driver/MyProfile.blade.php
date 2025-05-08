@extends('driver.fixedLayout')

@section('title', 'My Profile')

@section('page_title', 'My Profile')

@section('page-content')
    <div class="space-y-6">
        @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 rounded">
            {{ session('success') }}
        </div>
        @endif
        <h2 class="text-xl font-semibold">Your Information</h2>
        
        <form id="profile-form" action="{{route("driver.updateDriverProfile")}}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            @method('PUT')
            
            <div class="col-span-2 flex items-center">
                <label for="name" class="mr-4 w-32 text-gray-700">Name</label>
                <input type="text"
                       id="name"
                       value="{{ $user->name }}"
                       name="name"
                       placeholder="Name"
                       class="flex-1 border p-2 rounded @error('name') border-red-500 @enderror"/>
            </div>
            
            <div class="col-span-2 flex items-center">
                <label for="phone" class="mr-4 w-32 text-gray-700">Phone Number</label>
                <input type="text"
                       id="phone"
                       value="{{$user->phone}}"
                       name="phone"
                       placeholder="Phone Number"
                       class="flex-1 border p-2 rounded @error('phone') border-red-500 @enderror"/>
            </div>
            
            <div class="col-span-2 flex items-center">
                <label for="email" class="mr-4 w-32 text-gray-700">Email</label>
                <input type="email"
                       id="email"
                       value="{{$user->email}}"
                       name="email"
                       placeholder="Email"
                       class="flex-1 border p-2 rounded @error('email') border-red-500 @enderror"/>
            </div>

            <div class="col-span-2 flex items-center">
                <label for="vehicle_type" class="mr-4 w-32 text-gray-700">Vehicle Type</label>
                <input type="text"
                       id="vehicle_type"
                       value="{{$driver->vehicle_type}}"
                       name="vehicle_type"
                       placeholder="Vehicle Type"
                       class="flex-1 border p-2 rounded @error('vehicle_type') border-red-500 @enderror"/>
            </div>
            
            <div class="col-span-2 flex items-center">
                <label for="vehicle_number" class="mr-4 w-32 text-gray-700">Vehicle Number</label>
                <input type="text"
                       id="vehicle_number"
                       value="{{$driver->vehicle_number}}"
                       name="vehicle_number"
                       placeholder="Vehicle number"
                       class="flex-1 border p-2 rounded @error('vehicle_number') border-red-500 @enderror"/>
            </div>

            <div class="col-span-2 flex items-center">
                <label for="license_number" class="mr-4 w-32 text-gray-700">License Number</label>
                <input type="text"
                       id="license_number"
                       value="{{$driver->license}}"
                       name="license"
                       placeholder="License Number"
                       class="flex-1 border p-2 rounded @error('license') border-red-500 @enderror"/>
            </div>
            
            <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                    Update Profile
            </button>
        </form>
        @if ($errors->hasAny(['name', 'phone', 'email', 'vehicle_type', 'vehicle_number', 'license']))
            <div class="col-span-2 bg-red-50 text-red-500 p-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach (['name', 'phone', 'email', 'vehicle_type', 'vehicle_number', 'license'] as $field)
                        @if($errors->has($field))
                            <li>{{ $errors->first($field) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
        

        <form id="password-form" action="{{route("driver.updateDriverPassword")}}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            @method('PUT')
            <div class="col-span-2">
                <h3 class="text-lg font-medium mb-2">Change Password</h3>
                <p class="text-sm text-gray-500 mb-4">Leave blank if you don't want to change the password</p>
            </div>

            <div class="col-span-2 flex items-center">
                <label for="old_password" class="mr-4 w-32 text-gray-700">Old Password</label>
                <div class="relative flex-1">
                    <input type="password"
                           name="old_password"
                           id="old_password"
                           placeholder="Old Password"
                           class="border w-full p-2 rounded @error('old_password') border-red-500 @enderror">
                </div>
            </div>

            <div class="col-span-2 flex items-center">
                <label for="password" class="mr-4 w-32 text-gray-700">New Password</label>
                <div class="relative flex-1">
                    <input type="password"
                           name="new_password"
                           id="new_password"
                           placeholder="New Password"
                           class="border w-full p-2 rounded @error('new_password') border-red-500 @enderror">
                </div>
            </div>

            <div class="col-span-2 flex items-center">
                <label for="confirm_password" class="mr-4 w-32 text-gray-700">Confirm New Password</label>
                <div class="relative flex-1">
                    <input type="password"
                           name="confirm_new_password"
                           id="confirm_new_password"
                           placeholder="Confirm New Password"
                           class="border w-full p-2 rounded @error('confirm_new_password') border-red-500 @enderror">
                </div>
            </div>

            <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Update Password
            </button>
        </form>

        @if ($errors->hasAny(['old_password', 'new_password', 'confirm_new_password']))
        <div class="col-span-2 bg-red-50 text-red-500 p-4 rounded">
            <ul class="list-disc list-inside">
                @foreach (['old_password', 'new_password', 'confirm_new_password'] as $field)
                    @if($errors->has($field))
                        <li>{{ $errors->first($field) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
        @endif
    </div>
@endsection