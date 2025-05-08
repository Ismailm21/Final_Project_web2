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
            
            <!-- Delivery Area Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Delivery Area</h3>
                <input type="text"
                       value="{{ old('area', $driver->area->name ?? '') }}"
                       name="area"
                       placeholder="Enter your delivery area"
                       class="w-full border border-gray-300 p-3 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('area') border-red-500 @enderror"/>
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
@endsection