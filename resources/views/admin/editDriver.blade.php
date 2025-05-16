@extends('admin.admin')

@section('title', 'Edit Driver')

@section('content')
    <section id="drivers">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Edit Driver</h2>
            <form method="POST" action="{{ route('admin.updateDriver',['id'=>$driver->id]) }}" class="grid grid-cols-1 gap-4 md:grid-cols-2">
    @csrf
    @method('PUT')


                <input type="text"
                       value="{{ old('name', $driver->name ?? '') }}"
                       name="name"
                       placeholder="Name"
                       class="col-span-2 border p-2 rounded @error('name') border-red-500 @enderror"/>
                @error('name') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('phone', $driver->phone ?? '') }}"
                       name="phone"
                       placeholder="Phone Number"
                       class="col-span-2 border p-2 rounded @error('phone') border-red-500 @enderror"/>
                @error('phone') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('email', $driver->email ?? '') }}"
                       name="email"
                       placeholder="Email"
                       class="col-span-2 border p-2 rounded @error('email') border-red-500 @enderror"/>
                @error('email') <div class="text-red-600">{{ $message }}</div> @enderror

                <!-- Optional Password Fields -->
                <div class="col-span-2 relative">
                    <input type="password"
                           name="password"
                           id="password"
                           placeholder="New Password (optional)"
                           class="border w-full p-2 rounded @error('password') border-red-500 @enderror">
                    <i class="bi bi-eye-slash-fill absolute right-3 top-3 cursor-pointer text-gray-600"
                       onclick="togglePassword('password', this)"></i>
                    @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-span-2 relative">
                    <input type="password"
                           name="password_confirmation"
                           id="confirm_password"
                           placeholder="Confirm Password"
                           class="border w-full p-2 rounded">
                    <i class="bi bi-eye-slash-fill absolute right-3 top-3 cursor-pointer text-gray-600"
                       onclick="togglePassword('confirm_password', this)"></i>
                </div>

                <!-- Map and Address Info -->
                <div class="col-span-2">
                    <div class="mb-4">
                        <label for="address-search" class="block text-gray-700 mb-2">Service Area</label>
                        <input type="text"
                               id="address-search"
                               placeholder="Search location"
                               class="w-full border p-2 rounded">
                    </div>

                    <div class="mb-4 relative">
                        <div id="map-container" class="w-full h-96 rounded border overflow-hidden"></div>
                        <div class="absolute top-4 left-4 bg-white rounded shadow-md z-10">
                            <button type="button" id="map-btn" class="px-6 py-2 text-gray-700 bg-white border-r font-medium">Map</button>
                            <button type="button" id="satellite-btn" class="px-6 py-2 text-gray-500 bg-gray-100">Satellite</button>
                        </div>
                    </div>
                </div>

                <fieldset class="col-span-2 border border-gray-300 rounded p-4">
                    <legend class="text-sm font-semibold text-gray-600 px-2">Auto-Filled Address Info</legend>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text"
                               id="state"
                               name="state"
                               readonly
                               value="{{ old('state', $driver->state) }}"
                               placeholder="State"
                               class="border p-2 rounded bg-gray-50 text-gray-600">

                        <input type="text"
                               id="latitude"
                               name="latitude"
                               readonly
                               value="{{ old('latitude', $driver->latitude ?? '')  }}"
                               placeholder="Latitude"
                               class="border p-2 rounded bg-gray-50 text-gray-600">

                        <input type="text"
                               id="longitude"
                               name="longitude"
                               readonly
                               value="{{old('longitude', $driver->longitude ?? '') }}"
                               placeholder="Longitude"
                               class="border p-2 rounded bg-gray-50 text-gray-600 md:col-span-2">
                    </div>
                </fieldset>

                <!-- Availability Section -->
                <div class="col-span-2 mb-6">
                    <label class="block text-gray-700 mb-2">Weekly Availability</label>
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        @php
                            $key = strtolower($day);
                            $availability = $driver->availabilities[$key] ?? null;
                        @endphp
                        <div class="flex items-center mb-3">
                            <input type="checkbox"
                                   name="availabilities[{{ $key }}][active]"
                                   value="1"
                                   id="available_{{ $key }}"
                                   {{ old("availabilities.$key.active", $availability['active'] ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 rounded">

                            <label for="available_{{ $key }}" class="ml-2 w-24">{{ $day }}</label>

                            <input type="time"
                                   name="availabilities[{{ $key }}][start_time]"
                                   value="{{ old("availabilities.$key.start_time", $availability['start_time'] ?? '') }}"
                                   class="ml-2 border rounded p-1">

                            <input type="time"
                                   name="availabilities[{{ $key }}][end_time]"
                                   value="{{ old("availabilities.$key.end_time", $availability['end_time'] ?? '') }}"
                                   class="ml-2 border rounded p-1">
                        </div>
                    @endforeach
                </div>

                <!-- Vehicle Info -->
                <input type="text"
                       value="{{ old('license', $driver->license) }}"
                       name="license"
                       placeholder="License Plate"
                       class="col-span-2 border p-2 rounded @error('license') border-red-500 @enderror"/>
                @error('license') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('vehicle_type', $driver->vehicle_type) }}"
                       name="vehicle_type"
                       placeholder="Vehicle Type"
                       class="col-span-2 border p-2 rounded @error('vehicle_type') border-red-500 @enderror"/>
                @error('vehicle_type') <div class="text-red-600">{{ $message }}</div> @enderror

                <input type="text"
                       value="{{ old('vehicle_number', $driver->vehicle_number) }}"
                       name="vehicle_number"
                       placeholder="Vehicle Number"
                       class="col-span-2 border p-2 rounded @error('vehicle_number') border-red-500 @enderror"/>
                @error('vehicle_number') <div class="text-red-600">{{ $message }}</div> @enderror

                <!-- Pricing -->
                <div class="col-span-2 mb-3">
                <label class="block text-gray-700 mb-2">Pricing</label>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="number"
                        name="price"
                        placeholder="0.00"
                        min="0"
                        step="0.01"
                        value="{{ old('price', $driver->price ?? '') }}"
                        class="border p-2 rounded w-full @error('price') border-red-500 @enderror" />

                    <select name="pricing_model"
                            class="border p-2 rounded w-full @error('pricing_model') border-red-500 @enderror">
                        <option value="">Select Pricing Model</option>
                        <option value="fixed" {{ old('pricing_model', $driver->pricing_model ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        <option value="perKilometer" {{ old('pricing_model', $driver->pricing_model ?? '') == 'perKilometer' ? 'selected' : '' }}>Per km</option>
                    </select>
                </div>

    @error('price') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
    @error('pricing_model') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
</div>


                <button type="submit" class="col-span-2 bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Update Driver</button>
            </form>
        </div>
    </section>

    <script>
          document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('driver-form');

            form.addEventListener('submit', function(e) {
                let hasError = false;

                // Check required fields
                const requiredFields = [
                    'name', 'email', 'phone', 'password', 'password_confirmation',
                    'license', 'vehicle_type', 'vehicle_number', 'price'
                ];

                requiredFields.forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (!input.value.trim()) {
                        markFieldAsInvalid(input, 'This field is required');
                        hasError = true;
                    } else {
                        clearFieldError(input);
                    }
                });

                // Check email format
                const emailInput = form.querySelector('[name="email"]');
                if (emailInput.value && !isValidEmail(emailInput.value)) {
                    markFieldAsInvalid(emailInput, 'Please enter a valid email address');
                    hasError = true;
                }

                // Check password match
                const passwordInput = form.querySelector('[name="password"]');
                const confirmInput = form.querySelector('[name="password_confirmation"]');
                if (passwordInput.value && confirmInput.value && passwordInput.value !== confirmInput.value) {
                    markFieldAsInvalid(confirmInput, 'Passwords do not match');
                    hasError = true;
                }

                // Check map coordinates
                const latInput = form.querySelector('[name="latitude"]');
                const lngInput = form.querySelector('[name="longitude"]');
                if (!latInput.value || !lngInput.value) {
                    alert('Please select a location on the map');
                    hasError = true;
                }

                // Check availability times when day is checked
                const availabilityCheckboxes = form.querySelectorAll('input[type="checkbox"][name^="availabilities"]');
                availabilityCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const day = checkbox.id.replace('available_', '');
                        const startTime = form.querySelector(`[name="availabilities[${day}][start_time]"]`);
                        const endTime = form.querySelector(`[name="availabilities[${day}][end_time]"]`);

                        if (!startTime.value || !endTime.value) {
                            alert(`Please set both start and end time for ${day.charAt(0).toUpperCase() + day.slice(1)}`);
                            hasError = true;
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                }
            });

            function markFieldAsInvalid(field, message) {
                field.classList.add('border-red-500');

                // Check if error message already exists
                let errorDiv = field.nextElementSibling;
                if (!errorDiv || !errorDiv.classList.contains('text-red-600')) {
                    errorDiv = document.createElement('div');
                    errorDiv.className = 'text-red-600 text-sm mt-1';
                    field.parentNode.insertBefore(errorDiv, field.nextSibling);
                }
                errorDiv.textContent = message;
            }

            function clearFieldError(field) {
                field.classList.remove('border-red-500');
                const errorDiv = field.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('text-red-600')) {
                    errorDiv.remove();
                }
            }

            function isValidEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Toggle password visibility function
            window.togglePassword = function(inputId, icon) {
                const input = document.getElementById(inputId);
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("bi-eye-slash-fill");
                    icon.classList.add("bi-eye-fill");
                } else {
                    input.type = "password";
                    icon.classList.remove("bi-eye-fill");
                    icon.classList.add("bi-eye-slash-fill");
                }
            };
        });
    </script>
@endsection
