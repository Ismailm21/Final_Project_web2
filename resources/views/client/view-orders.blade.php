<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: #fff;
            margin: 0;
            padding: 40px 0;
            animation: fadeIn 1s ease-in-out;
        }

        .card {
            border-radius: 16px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.45em 0.65em;
            border-radius: 0.6rem;
        }

        .btn-sm {
            font-size: 0.75rem;
            padding: 0.35rem 0.75rem;
        }

        .table-hover tbody tr:hover {
            background-color: #f3f6f9;
        }

        .intro-section {
            background-color: #fff;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.03);
        }
    </style>
</head>
<body>
<div class="container py-5 animate__animated animate__fadeIn">

    <!-- Welcome & App Info Section -->
    <div class="intro-section text-center">
        <h1 class="fw-bold mb-3 text-primary">Welcome to your Delivery Dashboard</h1>
        <p class="lead text-muted">
            This platform helps you manage, track, and analyze your deliveries in real-time.
            View active and completed orders, check statuses, and monitor logistics performance —
            all from one centralized interface.
        </p>
    </div>

    <!-- Orders Table Card -->
    <div class="card shadow">
        <div class="card-header text-center bg-white">
            <h2 class="mb-0 fw-bold text-dark">Orders List</h2>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light text-muted text-uppercase small">
                <tr>
                    <th>Driver</th>
                    <th>Pickup</th>
                    <th>Dropoff</th>
                    <th>Weight (kg)</th>
                    <th>Size (L×W×H)</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Tracking</th>
                    <th>Created</th>
                    <th>Actions</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->driver->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->pickupAddress->city ?? 'N/A' }}</td>
                        <td>{{ $order->dropoffAddress->city ?? 'N/A' }}</td>
                        <td>{{ $order->package_weight ?? '-' }}</td>
                        <td>
                            {{ $order->package_size_l ?? '-' }}×{{ $order->package_size_w ?? '-' }}×{{ $order->package_size_h ?? '-' }}
                        </td>
                        <td>{{ $order->delivery_date ?? 'N/A' }}</td>
                        <td>
                                    <span class="badge
                                        @switch($order->status)
                                            @case('pending') bg-warning text-dark @break
                                            @case('processing') bg-primary @break
                                            @case('completed') bg-success @break
                                            @case('cancelled') bg-danger @break
                                            @default bg-secondary
                                        @endswitch">
                                        {{ ucfirst($order->status) }}
                                    </span>
                        </td>
                        <td>{{ $order->tracking_code ?? 'N/A' }}</td>
                        <td class="text-muted">{{ $order->created_at ? $order->created_at->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                        @if($order->status=="completed")
                       <a href="{{route('clientOrders.viewReviews',["id"=>$order->id])}}" class="btn btn-success ">Rate</a>
                        @elseif($order->status=="processing")
                                <a href="{{route('clientOrders.calendar',["id"=>$order->client_id])}}" class="btn btn-success ">View</a>


                            @endif
                        </td>

                        <td>
                            @if($order->status == 'processing' || $order->status == 'pending')
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST">

                                @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            @endif
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">No orders found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
