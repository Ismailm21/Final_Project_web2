@extends('driver.fixedLayout')

@section('title', 'Delivery Area & Pricing')

@section('page_title', 'Delivery Area & Pricing')

@section('page-content')
    <div class="space-y-8">
        @if(session('success'))
            <div class="bg-green-50 text-green-600 p-4 rounded-lg border border-green-200">
                {{ session('success') }}
            </div>
        @endif
        
        <form id="driver-form" action="{{ route('driver.updateAreaAndPricing') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Current Settings Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-3">Current Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded border-l-3 border-blue-400">
                        <p class="text-sm font-medium text-gray-600">Delivery Area</p>
                        <p class="text-gray-800">{{ $driver->area->name ?? 'No delivery area set' }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded border-l-3 border-blue-400">
                        <p class="text-sm font-medium text-gray-600">Pricing</p>
                        <p class="text-gray-800">${{ $driver->pricing_model == 'fixed' ? $driver->fixed_rate : $driver->rate_per_km }} 
                           <span class="text-gray-500 text-xs">({{ $driver->pricing_model == 'fixed' ? 'Fixed Price' : 'Per Kilometer' }})</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="mb-3">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Update Delivery Area & Pricing</h3>
                    <input type="text" id="address-search" placeholder="Search location or state" class="w-full border border-gray-300 p-3 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 form-control"/>
                </div>

                <input type="hidden" id="state" name="state" value="{{-- old('state', $driver->area->name ?? 'Unknown Location') --}}" required>
                <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $driver->area->latitude ?? 33.8886) }}" required>
                <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $driver->area->longitude ?? 35.4955) }}" required>

                <div id="map-container"></div>
            </div>

            <!-- Pricing Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Pricing</h3>
                <div class="flex space-x-4">
                    <input type="number"
                           name="price"
                           class="flex-1 border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00"
                           min="0"
                           step="0.01"
                           value="{{ old('price', $driver->pricing_model == 'fixed' ? $driver->fixed_rate : $driver->rate_per_km) }}"/> 
                    <select name="pricing_model" 
                            class="border border-gray-300 rounded-md p-3 w-48 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="fixed" {{ old('pricing_model', $driver->pricing_model) == 'fixed' ? 'selected' : '' }}>Fixed Price</option>
                        <option value="perKilometer" {{ old('pricing_model', $driver->pricing_model) == 'perKilometer' ? 'selected' : '' }}>Per Kilometer</option>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white font-medium px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Settings
                </button>
            </div>
        </form>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-lg border border-red-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCg0hy8YfWY7LzfDyId8dd1e3FplF3msAY&libraries=places&callback=initMap" async defer></script>
<script>
    let map, marker, autocomplete;

    function initMap() {
        const defaultLocation = { 
            lat: {{ $driver->area->latitude ?? 45.5017 }}, 
            lng: {{ $driver->area->longitude ?? -73.5673 }} 
        };
        map = new google.maps.Map(document.getElementById("map-container"), {
            center: defaultLocation,
            zoom: 12,
        });

        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true
        });

        const input = document.getElementById("address-search");
        autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);
            fillHiddenFields(place.address_components, place.geometry.location);
        });

        map.addListener("click", function (event) {
            const clickedLocation = event.latLng;
            marker.setPosition(clickedLocation);
            reverseGeocode(clickedLocation);
        });
    }

    function reverseGeocode(latlng) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK" && results[0]) {
                document.getElementById("address-search").value = results[0].formatted_address;
                fillHiddenFields(results[0].address_components, latlng);
            } else {
                console.warn("Geocoder failed: ", status);
            }
        });
    }

    function getComponent(components, types) {
        for (let type of types) {
            const comp = components.find(c => c.types.includes(type));
            if (comp) return comp.long_name;
        }
        return '';
    }

    function fillHiddenFields(components, location) {
        document.getElementById("state").value = getComponent(components, ["administrative_area_level_1"]);
        document.getElementById("latitude").value = location.lat();
        document.getElementById("longitude").value = location.lng();
    }

    window.initMap = initMap;
</script>
@endsection