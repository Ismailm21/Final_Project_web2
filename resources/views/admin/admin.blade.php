<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                <p class="text-2xl font-bold text-green-600">$34,245</p>
                <p class="text-xs text-gray-400">Not bad</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Fixed Issues</h3>
                <p class="text-2xl font-bold text-red-600">75</p>
                <p class="text-xs text-gray-400">Tracked from GitHub</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Available Drivers</h3>
                <p class="text-2xl font-bold text-blue-400">+245</p>
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
        const defaultLocation = { lat: 33.8886, lng: 35.4955 };
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
                // Fill the text input with the formatted address
                document.getElementById("address-search").value = results[0].formatted_address;

                // Fill hidden/read-only fields
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
        document.getElementById("city").value = getComponent(components, ["locality", "administrative_area_level_2"]);
        document.getElementById("state").value = getComponent(components, ["administrative_area_level_1"]);
        document.getElementById("country").value = getComponent(components, ["country"]);
        document.getElementById("latitude").value = location.lat();
        document.getElementById("longitude").value = location.lng();
    }

    window.initMap = initMap;
</script>

</body>
</html>
