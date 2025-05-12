<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #43cea2, #185a9d); /* greenish-blue gradient */
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            animation: slideDown 1s ease-in-out;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: fadeInUp 1s ease-in-out;
        }

        .btn-custom {
            padding: 15px;
            font-size: 1.2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
            width: 100%;
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

        <a href="/auth/google" class="btn btn-outline-danger btn-custom mb-2">
            <i class="bi bi-google"></i> Sign in with Google
        </a>
        <a href="/auth/facebook" class="btn btn-outline-primary btn-custom">
            <i class="bi bi-facebook"></i> Sign in with Facebook
        </a>

        <p class="mt-3 text-center">Don't have an account? <a href="{{ route('client.signup') }}">Sign Up</a></p>
    </form>
</div>

</body>
</html>
