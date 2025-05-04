<!-- resources/views/admin.blade.php -->

@extends('admin.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- resources/views/admin.blade.php -->

    <section id="drivers">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Driver</h2>
            <form id="driver-form" action="{{ route('admin.save') }}" method="POST" class="grid grid-cols-1 gap-4 md:grid-cols-2">
                @csrf

                <input type="text"
                       value="{{ old('name') }}"
                       name="name"
                       placeholder="Name"
                       class="col-span-2 border p-2 rounded @error('name') border-red-500 @enderror"/>
                @error('name') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('phone') }}"
                       name="phone"
                       placeholder="Phone Number"
                       class="col-span-2 border p-2 rounded @error('phone') border-red-500 @enderror"/>
                @error('phone') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('email') }}"
                       name="email"
                       placeholder="Email"
                       class="col-span-2 border p-2 rounded @error('email') border-red-500 @enderror"/>
                @error('email') <div class="text-red-600">{{ $message }}</div> @enderror


                <div class="col-span-2 relative">
                    <input type="password"
                           value="{{ old('password') }}"
                           name="password"
                           id="password"
                           placeholder="Password"
                           class="border w-full p-2 rounded invalid:border-red-500 @error('password') is-invalid @enderror">
                    <i class="bi bi-eye-slash-fill absolute right-3 top-3 cursor-pointer text-gray-600"
                       onclick="togglePassword('password', this)"></i>
                    @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-span-2 relative">
                    <input type="password"
                           name="password_confirmation"
                           id="confirm_password"
                           placeholder="Confirm Password"
                           class="border w-full p-2 rounded invalid:border-red-500">
                    @error('password_confirmation')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <i class="bi bi-eye-slash-fill absolute right-3 top-3 cursor-pointer text-gray-600"
                       onclick="togglePassword('confirm_password', this)"></i>
                </div>

                <input type="text"
                       value="{{ old('area') }}"
                       name="area"
                       placeholder="Area"
                       class="col-span-2 border p-2 rounded @error('area') border-red-500 @enderror"/>
                @error('area') <div class="text-red-600">{{ $message }}</div> @enderror

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Weekly Availability</label>

                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        <div class="flex items-center mb-3">
                            <!-- Checkbox -->
                            <input type="checkbox"
                                   name="availabilities[{{ strtolower($day) }}][active]"
                                   value="1"
                                   id="available_{{ strtolower($day) }}"
                                   class="h-4 w-4 text-blue-600 rounded">

                            <!-- Day Label -->
                            <label for="available_{{ strtolower($day) }}" class="ml-2 w-24">{{ $day }}</label>

                            <!-- Start Time -->
                            <input type="time"
                                   name="availabilities[{{ strtolower($day) }}][start_time]"
                                   class="ml-2 border rounded p-1">

                            <!-- End Time -->
                            <input type="time"
                                   name="availabilities[{{ strtolower($day) }}][end_time]"
                                   class="ml-2 border rounded p-1">
                        </div>
                    @endforeach
                </div>

                <input type="text"
                       value="{{ old('vehicle_type') }}"
                       name="vehicle_type"
                       placeholder="Vehicle Type"
                       class="col-span-2 border p-2 rounded @error('vehicle_type') border-red-500 @enderror"/>
                @error('vehicle_type') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('vehicle_number') }}"
                       name="vehicle_number"
                       placeholder="Vehicle number"
                       class="col-span-2 border p-2 rounded @error('vehicle_number') border-red-500 @enderror"/>
                @error('vehicle_number') <div class="text-red-600">{{ $message }}</div> @enderror

                <div class="row mb-3 col-span-2">
                    <label class="form-label fw-bold">Pricing</label>
                    <div class="input-group">
                        <input type="number"
                               name="price"
                               class="form-control"
                               placeholder="0.00"
                               min="0"
                               step="0.01"
                               value="{{ old('price') }}">
                        <select name="pricing_model" class="form-select" style="max-width: 120px;">
                            <option value="fixed" {{ old('pricing_model') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                            <option value="perKilometer" {{ old('pricing_model') == 'per_km' ? 'selected' : '' }}>Per km</option>
                        </select>
                    </div>
                    @error('price') <div class="text-red-600">{{ $message }}</div> @enderror
                    @error('pricing_model') <div class="text-red-600">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Save Driver</button>
            </form>

        </div>
    </section>
    <script>
        function togglePassword(inputId, iconElement) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';

            input.type = isPassword ? 'text' : 'password';
            iconElement.classList.toggle('bi-eye-slash-fill');
            iconElement.classList.toggle('bi-eye-fill');
        }
    </script>

@endsection
