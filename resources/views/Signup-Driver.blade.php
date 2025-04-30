<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">

<div class="card w-50">
    <div class="card-header text-center">
        <h4>Driver Sign Up</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('driver.signup.submit') }}">
            @csrf

            <!-- Name field -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone field -->
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Vehicle Type field -->
            <div class="mb-3">
                <label for="vehicle_type" class="form-label">Vehicle Type</label>
                <input type="text" id="vehicle_type" name="vehicle_type" class="form-control" value="motorcycle" required>
            </div>

            <!-- Vehicle Number field -->
            <div class="mb-3">
                <label for="vehicle_number" class="form-label">Vehicle Number</label>
                <input type="text" id="vehicle_number" name="vehicle_number" class="form-control" required>
                @error('vehicle_number')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password field -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-success w-100">Sign Up</button>
        </form>

        <!-- Back to Login Link -->
        <div class="mt-3 text-center">
            <p>Already have an account? <a href="{{ route('driver.login') }}">Login</a></p>
        </div>
    </div>
</div>

</body>
</html>
