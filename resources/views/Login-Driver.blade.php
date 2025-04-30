<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center" style="height: 100vh;">

<div class="card w-50">
    <div class="card-header text-center">
        <h4>Driver Login</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('driver.login.submit') }}">
            @csrf

            <!-- Email field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
                @error('email')
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

            <!-- Remember me checkbox -->
            <div class="mb-3 form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Remember Me</label>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-success w-100">Login</button>
        </form>

        <!-- Sign Up Link -->
        <div class="mt-3 text-center">
            <p>Don't have an account? <a href="{{ route('driver.signup') }}">Sign Up</a></p>
        </div>
    </div>
</div>

</body>
</html>
