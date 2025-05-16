@extends('driver.fixedLayout')

@section('title', 'Your Reviews')

@section('page_title', 'Reviews')

@section('page-content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800">Your Reviews</h2>
        </div>
        <div class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow-sm">
            <h2 class="text-xl font-bold text-gray-700">Average Rating</h2>
            <p class="text-lg font-medium text-gray-600">{{ $averageRating }} / 5</p>
        </div>

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-4">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Number</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviews as $review)
                        <tr onclick="window.location='{{ route('driver.viewOrderDetails', ['id' => $review->order_id]) }}'" class="cursor-pointer hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">#{{ $review->order_tracking_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->client_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->rating }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->review }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection