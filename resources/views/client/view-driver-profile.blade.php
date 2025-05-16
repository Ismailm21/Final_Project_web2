
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: #fff;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            animation: slideDown 1s ease-in-out;
        }

        .profile-card {
            max-width: 900px;
            margin: 0 auto 30px auto;
            background: #fff;
            color: #333;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-in-out;
        }

        .profile-label {
            font-weight: 600;
            color: #444;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 999px;
            font-weight: 600;
            color: #fff;
            display: inline-block;
        }

        .status-available {
            background-color: #22c55e;
        }

        .status-unavailable {
            background-color: #ef4444;
        }

        .review-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .review-box .stars {
            color: #f39c12;
        }

        .btn-back {
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: bold;
            background-color: #185a9d;
            color: white;
            border: none;
            border-radius: 8px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-back:hover {
            background-color: #14467c;
        }

        @keyframes slideDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container px-4 py-10">
        <h2 class="title">Driver Profile</h2>

        <!-- Full Driver Card with Reviews Inside -->
        <div class="profile-card">
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <p><span class="profile-label">Name:</span> {{ $driver->name }}</p>
                    <p><span class="profile-label">Email:</span> {{ $driver->email }}</p>
                    <p><span class="profile-label">Phone:</span> {{ $driver->phone }}</p>
                </div>
                <div class="col-md-6">
                    <p><span class="profile-label">Vehicle:</span> {{ $driverModel->vehicle_type }} ({{ $driverModel->vehicle_number }})</p>
                    <p><span class="profile-label">License Number:</span> {{ $driverModel->license }}</p>
                    <p>
                        <span class="profile-label">Status:</span>
                        <span class="status-badge {{ $driverModel->status === 'approved' ? 'status-available' : 'status-unavailable' }}">
                            {{ ucfirst($driverModel->status) }}
                        </span>
                    </p>
                    <p><span class="profile-label">Rating:</span> {{ $driverModel->rating }}/5</p>
                    <p><span class="profile-label">Joined At:</span> {{ $driverModel->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <hr class="mb-4">

            <!-- Reviews Section -->
            <h5 class="mb-3">Driver Reviews</h5>

            @if($reviews->isEmpty())
                <p class="text-center">No reviews available for this driver yet.</p>
            @else
                @foreach($reviews as $review)
                    <div class="review-box">
                        <p>
                            <strong>Rating:</strong>
                            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                                    <span style="color: {{ $i <= $review['rating'] ? '#f39c12' : '#ccc' }}">&#9733;</span>
                                @endfor
            </span>
                        </p>
                        <p><strong>Review:</strong> {{ $review['review'] }}</p>
                        <p class="text-muted"><small>Submitted on {{ $review['created_at'] }}</small></p>
                    </div>
                @endforeach

            @endif
            <a href="{{route('orders.showAssignDriverForm', ['id' => $order->id])}}" class="btn btn-primary btn-custom mt-3" >Go Back</a>

        </div>

    </div>

