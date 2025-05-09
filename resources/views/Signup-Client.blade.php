<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
        }
        .signup-card {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="signup-card">
        <h2 class="text-center mb-4">Create Client Account</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('client.signup.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control"  required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control"  required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control"  required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control"  required>
            </div>




            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
        </form>
    </div>
</div>
</body>
</html>
