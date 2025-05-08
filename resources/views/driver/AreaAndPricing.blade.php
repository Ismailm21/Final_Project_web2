@extends('driver.fixedLayout')

@section('title', 'Delivery Area & Pricing')

@section('page_title', 'Delivery Area & Pricing')

@section('page-content')
    <div class="space-y-6">
        <form id="driver-form" action="{{--route('')--}}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Delivery Area Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium mb-4">Delivery Area</h3>
                <input type="text"
                       value="{{--old('area', $driver->area ?? '')--}}"
                       name="area"
                       placeholder="Enter your delivery area"
                       class="w-full border p-2 rounded @error('area') border-red-500 @enderror"/>
            </div>

            <!-- Pricing Section -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium mb-4">Pricing</h3>
                <div class="flex space-x-4">
                    <input type="number"
                           name="price"
                           class="flex-1 border rounded p-2"
                           placeholder="0.00"
                           min="0"
                           step="0.01"
                           value="{{-- old('price', $driver->price ?? '') --}}">
                    <select name="pricing_model" 
                            class="border rounded p-2 w-40">
                        <option value="fixed" {{-- old('pricing_model', $driver->pricing_model ?? '') == 'fixed' ? 'selected' : ''--}}>Fixed Price</option>
                        <option value="perKilometer" {{--old('pricing_model', $driver->pricing_model ?? '') == 'perKilometer' ? 'selected' : ''--}}>Per Kilometer</option>
                    </select>
                </div>
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
@endsection