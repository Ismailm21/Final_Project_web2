<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Added Bootstrap Icons -->

    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #43cea2, #185a9d); /* greenish-blue gradient */
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            font-size: 2.5rem; /* Reduced title size */
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            padding: 5px 20px; /* Reduced padding */
            border-radius: 10px;
            animation: slideDown 1s ease-in-out;
            margin-bottom: 20px; /* Added margin for space */
        }

        .form-container {
            background-color: white;
            padding: 20px; /* Reduced padding */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeInUp 1s ease-in-out;
            color: #333;
        }

        .form-label {
            color: #333;
        }

        .form-control {
            color: #000;
        }

        .btn-custom {
            padding: 12px; /* Reduced padding */
            font-size: 1.1rem; /* Reduced font size */
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            width: 100%;
            margin-bottom: 8px; /* Reduced margin between buttons */
        }

        .btn-custom:hover {
            transform: scale(1.05);
        }

        .text-center a {
            color: #43cea2;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
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

<h1 class="title">Client Login</h1>
{{-- DEBUG: dump all errors --}}
@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif
<div class="form-container">

    <form method="POST" action="{{ route('client.login.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-custom">Login</button>

        <div class="text-center my-3">or</div>

        <!-- Google and Facebook buttons aligned vertically -->
        <a href="/auth/google" class="btn btn-outline-danger btn-custom">
            <i class="bi bi-google" style="margin-right: 10%;"></i> Sign in with Google
        </a>
        <a href="/auth/facebook" class="btn btn-outline-primary btn-custom">
            <i class="bi bi-facebook" style="margin-left: 6%; margin-right: 10%;"></i> Sign in with Facebook
        </a>

        <a href="/auth/github" class="btn btn-outline-dark btn-custom">
            <i class="bi bi-github" style="margin-right: 10%;"></i> Sign in with GitHub
        </a>

        <p class="mt-3 text-center">Don't have an account? <a href="{{ route('client.signup') }}">Sign Up</a></p>
    </form>
</div>

</body>
</html>
