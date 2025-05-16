<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Assign Driver & Review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: #fff;
            margin: 0;
            padding: 40px 0;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            text-align: center;
            font-size: 2.8rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            margin-bottom: 30px;
            animation: slideDown 1s ease-in-out;
        }

        .assignment-card {
            max-width: 600px;
            margin: 0 auto 30px auto;
            background: #fff;
            color: #333;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            animation: fadeInUp 1s ease-in-out;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control {
            color: #000;
        }

        .btn-custom {
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 10px;
            width: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease-in-out;
        }

        .btn-custom:hover {
            transform: scale(1.03);
        }

        .alert {
            max-width: 600px;
            margin: 0 auto 20px auto;
            animation: fadeInUp 0.8s ease-in-out;
        }

        /* Star rating styles */
        .rating {
            direction: rtl;
            font-size: 1.8rem;
            unicode-bidi: bidi-override;
            text-align: center;
            margin-bottom: 15px;
        }

        .rating input[type="radio"] {
            display: none;
        }

        .rating label {
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .rating label:hover,
        .rating label:hover ~ label,
        .rating input[type="radio"]:checked ~ label {
            color: #f39c12;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<h2 class="title">Assign Driver to Order #{{ $order->id }}</h2>

<!-- Assigned Driver Info -->
@if($order->driver)
    <div class="alert alert-info text-center">
        <strong>Assigned Driver:</strong> {{ $order->driver->user->name }} ({{ $order->driver->vehicle_type }})
    </div>
@else
    <div class="alert alert-warning text-center">
        No driver assigned yet.
    </div>
@endif

<!-- Review & Rating Card -->
<div class="assignment-card">
    <h5 class="mb-3">Leave a Review & Rating</h5>
    <form action="{{route('clientOrders.writeReview',["id"=>$order->id])}}" method="POST">
        @csrf
        <!-- Star Rating -->
        <div class="rating">
            <input type="radio" id="star5" name="rating" value="5" required />
            <label for="star5" title="5 stars">&#9733;</label>

            <input type="radio" id="star4" name="rating" value="4" />
            <label for="star4" title="4 stars">&#9733;</label>

            <input type="radio" id="star3" name="rating" value="3" />
            <label for="star3" title="3 stars">&#9733;</label>

            <input type="radio" id="star2" name="rating" value="2" />
            <label for="star2" title="2 stars">&#9733;</label>

            <input type="radio" id="star1" name="rating" value="1" />
            <label for="star1" title="1 star">&#9733;</label>
        </div>

        <!-- Review Textarea -->
        <div class="mb-3">
            <label for="review" class="form-label">Your Review:</label>
            <textarea name="review" id="review" rows="4" class="form-control" placeholder="Write your review here..." required></textarea>
        </div>

       <div class="d-flex gap-2 mt-3">
           <div class="d-flex gap-2 mt-3">
               <button type="submit" class="btn btn-primary btn-custom flex-grow-1">Submit Review</button>
           </div>


</div>


    </form>
</div>

</body>
</html>
