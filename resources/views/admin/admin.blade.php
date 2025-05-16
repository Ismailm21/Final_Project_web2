<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <style>
        #map-container {
            height: 300px;
            width: 100%;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 1px solid #e2e8f0;
        }
        .pac-container {
            z-index: 1050 !important;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <main class="flex-1 p-6 space-y-8">
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Total Revenue</h3>
                <p class="text-2xl font-bold text-green-600">${{$centerShareTotalAllOrders}}</p>
                <p class="text-xs text-gray-400">Not bad</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Active Orders</h3>
                <p class="text-2xl font-bold text-red-600">{{$active_orders_count}}</p>
                <p class="text-xs text-gray-400">Just Updated</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Completed Orders</h3>
                <p class="text-2xl font-bold text-grey-600">{{$completed_orders_count}}</p>
                <p class="text-xs text-gray-400">Just Updated</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Available Drivers</h3>
                <p class="text-2xl font-bold text-blue-400">{{$D_count}}</p>
                <p class="text-xs text-gray-400">Just Updated</p>
            </div>
        </div>

        <main class="flex-1 p-6 space-y-8">
            @yield('content')
        </main>
    </main>
</div>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCg0hy8YfWY7LzfDyId8dd1e3FplF3msAY&libraries=places&callback=initMap" async defer></script>
<script>
    let map, marker, autocomplete;

    function initMap() {
        // Default location (Beirut, Lebanon based on the coordinates in original code)
        const defaultLocation = { lat: 33.8886, lng: 35.4955 };

        // Initialize the map with default options
        map = new google.maps.Map(document.getElementById("map-container"), {
            center: defaultLocation,
            zoom: 12,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Create a draggable marker
        marker = new google.maps.Marker({
            position: defaultLocation,
            map: map,
            draggable: true,
            animation: google.maps.Animation.DROP
        });

        // Set up address search autocomplete
        const input = document.getElementById("address-search");
        autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (!place.geometry) return;

            // Center map and set marker to the selected place
            map.setCenter(place.geometry.location);
            marker.setPosition(place.geometry.location);

            // Fill the form fields with the selected location data
            fillHiddenFields(place.address_components, place.geometry.location);
        });

        // Allow clicking on the map to set the marker
        map.addListener("click", function (event) {
            const clickedLocation = event.latLng;
            marker.setPosition(clickedLocation);
            reverseGeocode(clickedLocation);
        });

        // Update form fields when marker is dragged
        marker.addListener("dragend", function() {
            reverseGeocode(marker.getPosition());
        });

        // Set up map type toggle buttons
        document.getElementById("map-btn").addEventListener("click", function() {
            map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
            this.classList.remove("bg-gray-100", "text-gray-500");
            this.classList.add("bg-white", "text-gray-700");
            document.getElementById("satellite-btn").classList.remove("bg-white", "text-gray-700");
            document.getElementById("satellite-btn").classList.add("bg-gray-100", "text-gray-500");
        });

        document.getElementById("satellite-btn").addEventListener("click", function() {
            map.setMapTypeId(google.maps.MapTypeId.HYBRID);
            this.classList.remove("bg-gray-100", "text-gray-500");
            this.classList.add("bg-white", "text-gray-700");
            document.getElementById("map-btn").classList.remove("bg-white", "text-gray-700");
            document.getElementById("map-btn").classList.add("bg-gray-100", "text-gray-500");
        });
    }

    // Convert coordinates to address using reverse geocoding
    function reverseGeocode(latlng) {
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK" && results[0]) {
                // Fill the text input with the formatted address
                document.getElementById("address-search").value = results[0].formatted_address;

                // Fill hidden/read-only fields
                fillHiddenFields(results[0].address_components, latlng);
            } else {
                console.warn("Geocoder failed: ", status);
            }
        });
    }

    // Extract specific address components and fill form fields
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

    // Make initMap available globally for the Google Maps callback
    window.initMap = initMap;

</script>

</body>
</html>
