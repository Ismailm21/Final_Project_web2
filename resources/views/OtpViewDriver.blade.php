<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .otp-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-card {
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .otp-card h4 {
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
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

        .form-control {
            height: 48px;
            font-size: 16px;
        }

        .alert-danger {
            font-size: 14px;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="otp-wrapper">
    <div class="otp-card">
        <h4>Verify Your OTP</h4>

        <form method="POST" action="{{ route('driver.verify.otp.submit') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $userId }}">

            <div class="mb-3">
                <input type="text" name="otp_code" class="form-control" placeholder="Enter OTP Code" required>
            </div>

            <button type="submit" class="btn btn-verify w-100">Verify</button>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
</div>

</body>
</html>
