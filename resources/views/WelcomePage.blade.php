<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to QuickDeliver</title>
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

        .company-icon {
            width: 130px;
            margin-bottom: 25px;
            animation: bounce 1.5s infinite alternate ease-in-out;
        }

        .btn-group-custom {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeInUp 1s ease-in-out;
        }

        .btn-custom {
            padding: 15px 30px;
            font-size: 1.2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s;
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

        @keyframes bounce {
            from { transform: translateY(0); }
            to   { transform: translateY(-10px); }
        }
    </style>
</head>
<body>

<img src="{{ asset('storage/Logo2.png') }}" alt="Delivery Motorcycle Icon" class="company-icon">

<h1 class="title">Welcome to QuickDeliver</h1>
<p class="mb-4 fs-5">Choose your role to get started</p>

<div class="btn-group-custom">
    <a href="{{ route('client.login') }}" class="btn btn-light text-primary btn-custom">Client</a>
    <a href="{{ route('driver.login') }}" class="btn btn-light text-success btn-custom">Driver</a>
    <a href="{{ route('admin.login') }}" class="btn btn-light text-danger btn-custom">Admin</a>
</div>

</body>
</html>
