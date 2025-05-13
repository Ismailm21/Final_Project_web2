<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .otp-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-card {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .otp-card h4 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        .otp-card .form-control {
            height: 50px;
            font-size: 16px;
        }

        .btn-verify {
            height: 50px;
            font-size: 16px;
            background-color: #28a745;
            border: none;
        }

        .btn-verify:hover {
            background-color: #218838;
        }

        .error-list {
            color: #dc3545;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="otp-wrapper">
    <div class="otp-card">
        <h4 class="text-center">Verify Your OTP</h4>

        @if ($errors->any())
            <div class="error-list">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('verify.otp.submit') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="otp_code" class="form-control" placeholder="Enter 6-digit OTP" required>
            </div>

            <button type="submit" class="btn btn-verify w-100">Verify</button>
        </form>
    </div>
</div>

</body>
</html>
