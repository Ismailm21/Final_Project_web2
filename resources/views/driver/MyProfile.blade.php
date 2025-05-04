@extends('driver.fixedLayout')

@section('title', 'My Profile')

@section('page_title', 'My Profile')

@section('page-content')
    <div class="space-y-6">
        <h2 class="text-xl font-semibold">Your Information</h2>
        
        <form id="driver-form" action="" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @csrf
            @method('PUT')
            
            <input type="text"
                   value="{{ $user->name }}"
                   name="name"
                   placeholder="Name"
                   class="col-span-2 border p-2 rounded @error('name') border-red-500 @enderror"/>
            
            <input type="text"
                   value="{{$user->phone}}"
                   name="phone"
                   placeholder="Phone Number"
                   class="col-span-2 border p-2 rounded @error('phone') border-red-500 @enderror"/>
            
            <input type="email"
                   value="{{$user->email}}"
                   name="email"
                   placeholder="Email"
                   class="col-span-2 border p-2 rounded @error('email') border-red-500 @enderror"/>

            <input type="text"
                   value="{{$driver->vehicle_type}}"
                   name="vehicle_type"
                   placeholder="Vehicle Type"
                   class="col-span-2 border p-2 rounded @error('vehicle_type') border-red-500 @enderror"/>
            
            <input type="text"
                   value="{{$driver->vehicle_number}}"
                   name="vehicle_number"
                   placeholder="Vehicle number"
                   class="col-span-2 border p-2 rounded @error('vehicle_number') border-red-500 @enderror"/>
            
            <div class="col-span-2">
                <h3 class="text-lg font-medium mb-2">Update Password</h3>
                <p class="text-sm text-gray-500 mb-4">Leave blank if you don't want to change the password</p>
            </div>

            <div class="col-span-2 relative">
                <input type="password"
                       name="password"
                       id="password"
                       placeholder="New Password"
                       class="border w-full p-2 rounded @error('password') border-red-500 @enderror">
                <i class="bi bi-eye-slash-fill absolute right-3 top-3 cursor-pointer text-gray-600"
                   onclick="togglePassword('password', this)"></i>
            </div>

            <div class="col-span-2 relative">
                <input type="password"
                       name="password_confirmation"
                       id="confirm_password"
                       placeholder="Confirm Password"
                       class="border w-full p-2 rounded @error('password_confirmation') border-red-500 @enderror">
            </div>

            <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Update Profile
            </button>
        </form>

        @if ($errors->any())
            <div class="col-span-2 bg-red-50 text-red-500 p-4 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash-fill');
                icon.classList.add('bi-eye-fill');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-fill');
                icon.classList.add('bi-eye-slash-fill');
            }
        }
    </script>
@endsection