@extends('driver.fixedLayout')

@section('title', 'Manage Availability')

@section('page_title', 'Edit your availability')

@section('page-content')
    <div class="space-y-6">
        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        <form id="driver-form" action="{{route('driver.updateDriverAvailability')}}" method="POST" class="space-y-6">
            @csrf
            <!-- Weekly Availability Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium mb-4">Weekly Availability</h3>
                
                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                    @php
                        // Find the availability for this day if it exists
                        $dayAvailability = $availabilities->where('day', ucfirst($day))->first();
                        $isAvailable = $dayAvailability ? true : false;
                        $startTime = $dayAvailability ? $dayAvailability->start_time : '';
                        $endTime = $dayAvailability ? $dayAvailability->end_time : '';
                    @endphp

                    <div class="mb-2">
                        @if($dayAvailability)
                            <input type="hidden" 
                                   name="availabilities[{{ $day }}][id]" 
                                   value="{{ $dayAvailability->id }}">
                        @endif
                    </div>
                    
                    <div class="flex items-center mb-4 space-x-4">
                        <div class="flex items-center w-40">
                            <input type="checkbox"
                                   name="availabilities[{{ $day }}][active]"
                                   value="1"
                                   id="available_{{ $day }}"
                                   {{ old("availabilities.{$day}.active", $isAvailable) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 rounded">
                            <label for="available_{{ $day }}" class="ml-2 capitalize">{{ $day }}</label>
                        </div>

                        <div class="flex items-center space-x-2 flex-1">
                            <input type="time"
                                   name="availabilities[{{ $day }}][start_time]"
                                   value="{{ old("availabilities.{$day}.start_time", $startTime) }}"
                                   class="border rounded p-2 w-32"
                                   {{ old("availabilities.{$day}.active", $isAvailable) ? '' : 'disabled' }}>
                            <span class="text-gray-500">to</span>
                            <input type="time"
                                   name="availabilities[{{ $day }}][end_time]"
                                   value="{{ old("availabilities.{$day}.end_time", $endTime) }}"
                                   class="border rounded p-2 w-32"
                                   {{ old("availabilities.{$day}.active", $isAvailable) ? '' : 'disabled' }}>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition-colors">
                Update Settings
            </button>
        </form>

        @if ($errors->any())
            <div class="bg-red-50 text-red-500 p-4 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        // Enable/disable time inputs based on checkbox state
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const day = this.id.replace('available_', '');
                const timeInputs = document.querySelectorAll(`input[name^="availabilities[${day}]"][type="time"]`);
                timeInputs.forEach(input => {
                    input.disabled = !this.checked;
                });
            });
        });
    </script>
@endsection