
     <!--   <div class="container">
            <h2 class="mb-4">Assign Driver to Order #{{ $order->id }}</h2>


            <div class="card mb-4">
                <div class="card-header">Manual Assignment</div>
                <div class="card-body">
                    <form action="{{ route('orders.assignDriver', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="driver_id">Choose Driver:</label>
                            <select name="driver_id" id="driver_id" class="form-control" required>
                                <option value="">-- Select a driver --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">
                                        {{ $driver->user->name }} | {{ $driver->vehicle_type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Assign Driver</button>
                    </form>
                </div>
            </div>


            <div class="card">
                <div class="card-header">Auto Assignment</div>
                <div class="card-body">
                    <form action="{{ route('orders.autoAssignDriver', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Auto-Assign Nearest Driver</button>
                    </form>
                </div>
            </div>
        </div>

         <div class="container">
             <h2 class="mb-4">Assign Driver to Order #{{ $order->id }}</h2>


             @if($order->driver)
                 <div class="alert alert-info">
                     <strong>Currently Assigned Driver:</strong>
                     {{ $order->driver->user->name }} ({{ $order->driver->vehicle_type }})
                 </div>
             @else
                 <div class="alert alert-warning">
                     No driver assigned yet.
                 </div>
             @endif


             <div class="card mb-4">
                 <div class="card-header">Manual Assignment</div>
                 <div class="card-body">
                     <form action="{{ route('orders.assignDriver', $order->id) }}" method="POST">
                         @csrf
                         <div class="form-group">
                             <label for="driver_id">Choose Driver:</label>
                             <select name="driver_id" id="driver_id" class="form-control" required>
                                 <option value="">-- Select a driver --</option>
                                 @foreach($drivers as $driver)
                                     <option value="{{ $driver->id }}"
                                         {{ $order->driver_id == $driver->id ? 'selected' : '' }}>
                                         {{ $driver->user->name }} | {{ $driver->vehicle_type }}
                                     </option>
                                 @endforeach
                             </select>
                         </div>
                         <button type="submit" class="btn btn-primary mt-3">Update Driver</button>
                     </form>
                 </div>
             </div>

             <div class="card">
                 <div class="card-header">Auto Assignment</div>
                 <div class="card-body">
                     <form action="{{ route('orders.autoAssignDriver', $order->id) }}" method="POST">
                         @csrf
                         <button type="submit" class="btn btn-success">Auto-Assign Nearest Driver</button>
                     </form>
                 </div>
             </div>
         </div>-->


     <!DOCTYPE html>
     <html lang="en">
     <head>
         <meta charset="UTF-8">
         <title>Assign Driver</title>
         <meta name="viewport" content="width=device-width, initial-scale=1">

         <!-- Bootstrap 5 CDN -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

             @keyframes slideDown {
                 from { transform: translateY(-50px); opacity: 0; }
                 to   { transform: translateY(0); opacity: 1; }
             }

             @keyframes fadeInUp {
                 from { transform: translateY(30px); opacity: 0; }
                 to   { transform: translateY(0); opacity: 1; }
             }

             @keyframes fadeIn {
                 from { opacity: 0; }
                 to   { opacity: 1; }
             }
         </style>
     </head>
     <body>

     <h2 class="title">Assign Driver to Order #{{ $order->id }}</h2>
     @if (session('success'))
         <div class="alert alert-success text-center">
             {{ session('success') }}
         </div>
     @endif

     @if (session('error'))
         <div class="alert alert-danger text-center">
             {{ session('error') }}
         </div>
     @endif


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

     <!-- Manual Assignment Card -->
     <div class="assignment-card">
         <h5 class="mb-3">Manual Assignment</h5>
         <form action="{{ route('orders.assignDriver', $order->id) }}" method="POST">
             @csrf
             <div class="mb-3">
                 <label for="driver_id" class="form-label">Choose Driver:</label>
                 <select name="driver_id" id="driver_id" class="form-control" required>
                     <option value="">-- Select a driver --</option>
                     @foreach($drivers as $driver)
                         <option value="{{ $driver->id }}" {{ $order->driver_id == $driver->id ? 'selected' : '' }}>
                             {{ $driver->user->name }} | {{ $driver->vehicle_type }}
                         </option>
                     @endforeach
                 </select>
             </div>
             <button type="submit" class="btn btn-primary btn-custom mt-2">Update Driver</button>
         </form>
         <a href="{{route('clientOrders.viewProfile',['id'=>$order->id])}}" type="submit" class="btn btn-primary btn-custom mt-3">View Drivers Profile</a>
         <a href="{{route('payment.form',['orderId'=>$order->id])}}" type="submit" class="btn btn-primary btn-custom mt-3">Proceed for Payment</a>
     </div>

     <!-- Auto Assignment Card
     <div class="assignment-card">
         <h5 class="mb-3">Auto Assignment</h5>
         <form action="{{ route('orders.autoAssignDriver', $order->id) }}" method="POST">
             @csrf
             <button type="submit" class="btn btn-success btn-custom">Auto-Assign Nearest Driver</button>
         </form>
     </div>
-->

     </body>
     </html>

