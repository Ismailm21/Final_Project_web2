<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            height: 100vh;
            margin: 0;
            background: linear-gradient(to right, #43cea2, #185a9d);
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
            font-family: 'Inter', sans-serif;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
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

        .alert {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-in-out;
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

<h1 class="title">Admin Login</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="form-container">
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger btn-custom">Login</button>
    </form>
</div>

</body>
</html>
