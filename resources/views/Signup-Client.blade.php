<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d); /* greenish-blue gradient */
            color: #fff;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            animation: fadeIn 1s ease-in-out;
        }

        .title {
            font-size: 3rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            animation: slideDown 1s ease-in-out;
        }

        .signup-card {
            max-width: 500px;
            width: 100%;
            padding: 30px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
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

<h1 class="title">Create Client Account</h1>

<div class="signup-card">
    <form method="POST" action="{{ route('client.signup.submit') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary btn-custom">Sign Up</button>
    </form>
</div>

</body>
</html>
