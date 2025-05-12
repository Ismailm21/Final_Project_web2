 @extends('layouts.template_client')

    @section('content')
        <section class="w3l-form-12 close-menu-toggle">
            <div class="w3l-form-12-content py-5">
                <div class="container py-md-5">
                    <div class="title-content text-center">
                        <h6 class="title-subhny">Delivery Request</h6>
                        <h3 class="title-w3l mb-5">Send a Package</h3>

                    </div>

                    <div class="row grid-column-2">
                        <div class="col-lg-8 column1 pr-lg-5">
                            <form action="{{route('store_order')}}" onsubmit="updateDistanceDisplay()"  method="POST">
                                @csrf

                                <label for="package_weight">Weight</label>
                                <input type="number" name="package_weight" class="form-input mb-3" placeholder="e.g. 40kg" >
                                @error('package_weight')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <label for="package_size_w">Width</label>
                                <input type="number" name="package_size_w" class="form-input mb-3" placeholder="e.g. 100cm" >
                                @error('package_size_w')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <label for="package_size_h">Height</label>
                                <input type="number" name="package_size_h" class="form-input mb-3" placeholder="e.g. 100cm">
                                @error('package_size_h')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <label for="package_size_l">Length</label>
                                <input type="number" name="package_size_l" class="form-input mb-3" placeholder="e.g. 100cm">
                                @error('package_size_l')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <label class="form-check-label">
                                    <input type="checkbox" name="urgency" id="urgency" checked>
                                    Urgent Delivery
                                </label>

                                @error('urgency')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <br>
                                <label for="driver_id">Choose Driver</label>
                                <select name="driver_id" class="form-select mb-4" >
                                    <option value="">-- Select Driver --</option>

                                </select>





                                <label for="pickup-address">Pickup Location</label>
                                <input type="text" id="pickup-address" class="form-control mb-2" placeholder="Search pickup location">
                                <div id="pickup-map" class="map-box"></div>



                                <fieldset class="col-span-2 border border-gray-300 rounded p-4">
                                <legend class="text-sm font-semibold text-gray-600 mb-2">Auto-Filled Address Info</legend>

                            <input type="text"
                                   id="pickup_street"
                                   name="pickup_street"
                                   value="{{old('street')}}"
                                   placeholder="Street"
                                   class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_street')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                            <input type="text"
                                   id="pickup_city"
                                   name="pickup_city"
                                   readonly
                                   placeholder="City"
                                   class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_city')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                            <input type="text"
                                   id="pickup_state"
                                   name="pickup_state"
                                   readonly
                                   placeholder="State"
                                   class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_state')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                            <input type="text"
                                   id="pickup_postal_code"
                                   name="pickup_postal_code"
                                   value="{{old("postal_code")}}"
                                   placeholder="Postal Code"
                                   class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_postal_code')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                            <input type="text"
                                   id="pickup_country"
                                   name="pickup_country"
                                   readonly
                                   placeholder="Country"
                                   class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_country')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                            <input type="text"
                                   id="pickup_latitude"
                                   name="pickup_latitude"
                                   readonly
                                   placeholder="Latitude"
                                   class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_latitude')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                            <input type="text"
                                   id="pickup_longitude"
                                   name="pickup_longitude"
                                   readonly
                                   placeholder="Longitude"
                                   class="w-full border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                    @error('pickup_longtitude')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                        </fieldset>

                                <label for="dropoff-address">Dropoff Location</label>
                                <input type="text" id="dropoff-address" class="form-control mb-2" placeholder="Search dropoff location">
                                <div id="dropoff-map" class="map-box"></div>

                                <legend class="text-sm font-semibold text-gray-600 mb-2">Auto-Filled Address Info</legend>

                                <input type="text"
                                       id="dropoff_street"
                                       name="dropoff_street"
                                       value="{{old('street')}}"
                                       placeholder="Street"
                                       class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_street')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text"
                                       id="dropoff_city"
                                       name="dropoff_city"
                                       readonly
                                       placeholder="City"
                                       class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_city')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text"
                                       id="dropoff_state"
                                       name="dropoff_state"
                                       readonly
                                       placeholder="State"
                                       class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_state')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text"
                                       id="dropoff_postal_code"
                                       name="dropoff_postal_code"
                                       value="{{old("postal_code")}}"
                                       placeholder="Postal Code"
                                       class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_postal_code')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text"
                                       id="dropoff_country"
                                       name="dropoff_country"
                                       readonly
                                       placeholder="Country"
                                       class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_country')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text"
                                       id="dropoff_latitude"
                                       name="dropoff_latitude"
                                       readonly
                                       placeholder="Latitude"
                                       class="mb-2 border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_latitude')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                <input type="text"
                                       id="dropoff_longitude"
                                       name="dropoff_longitude"
                                       readonly
                                       placeholder="Longitude"
                                       class="w-full border p-2 rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                                @error('dropoff_longtitude')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                </fieldset>
                                <!-- Add this DIV inside your Blade view, under the second map (dropoff) -->
                                <!-- 📌 This should go right after <div id="dropoff-map" class="map-box"></div> -->


                                <button type="submit" class="btn btn-primary btn-style mt-3">Send Request</button>
                            </form>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                        </div>

                        <div class="col-lg-4 column2 mt-lg-0 mt-5">
                            <div class="contact-box p-5">
                                <h3 class="title-w3l two mb-4">Need Help?</h3>
                                <p>We're here to make delivery easy and reliable.</p>
                                <a class="btn btn-style btn-white mt-sm-5 mt-4" href="contact.html">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection

