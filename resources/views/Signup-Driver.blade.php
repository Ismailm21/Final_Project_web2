<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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


        body {
            background-color: #f8f9fa;
        }
        .signup-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .signup-card {
            width: 100%;
            max-width: 500px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="signup-wrapper">
    <div class="card signup-card">
        <div class="card-header text-center bg-white">
            <h4>Driver Sign Up</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('driver.signup.submit') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                    @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Vehicle Type -->
                <div class="mb-3">
                    <label for="vehicle_type" class="form-label">Vehicle Type</label>
                    <input type="text" id="vehicle_type" name="vehicle_type" class="form-control" value="motorcycle" required>
                </div>

                <!-- Vehicle Number -->
                <div class="mb-3">
                    <label for="vehicle_number" class="form-label">Vehicle Number</label>
                    <input type="text" id="vehicle_number" name="vehicle_number" class="form-control" required>
                    @error('vehicle_number')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>



                <div class="mb-3">
                    <label for="address-search" class="form-label">Select Your State</label>
                    <input type="text" id="address-search" class="form-control" placeholder="Search location or state">
                </div>

                <input type="hidden" id="state" name="state" required>
                <input type="hidden" id="latitude" name="latitude" required>
                <input type="hidden" id="longitude" name="longitude" required>



                <div id="map-container"></div>



                <!-- License -->
                <div class="mb-3">
                    <label for="license" class="form-label">Driver License</label>
                    <input type="text" id="license" name="license" class="form-control" required>
                    @error('license')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Pricing Model -->
                <div class="mb-3">
                    <label for="pricing_model" class="form-label">Pricing Model</label>
                    <select id="pricing_model" name="pricing_model" class="form-select" required>
                        <option value="fixed">Fixed</option>
                        <option value="perKilometer">Per Kilometer</option>
                    </select>
                    @error('pricing_model')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success w-100">Sign Up</button>
            </form>

            <!-- Link to Login -->
            <div class="mt-3 text-center">
                <p>Already have an account? <a href="{{ route('driver.login') }}">Login</a></p>
            </div>
        </div>
    </div>
</div>

</body>
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
        document.getElementById("state").value = getComponent(components, ["administrative_area_level_1"]);
        document.getElementById("latitude").value = location.lat();
        document.getElementById("longitude").value = location.lng();
    }



    window.initMap = initMap;
</script>

</html>

