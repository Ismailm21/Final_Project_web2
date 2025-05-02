<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .otp-container {
            max-width: 400px;
            margin: 80px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        .otp-container h2 {
            text-align: center;
            margin-bottom: 24px;
            color: #333;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }
        .btn {
            background-color: #2b70f8;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #1754db;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 12px;
            font-size: 14px;
            text-align: center;
        }
        .success {
            color: #2ecc71;
            margin-bottom: 12px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="otp-container">
    <h2>Verify OTP</h2>

    @if (session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{ $userId }}">

        <div class="form-group">
            <label for="otp_code">Enter OTP</label>
            <input type="text" name="otp_code" maxlength="6" required placeholder="e.g. 123456">
        </div>

        <button type="submit" class="btn">Verify</button>
    </form>
</div>
</body>
</html>
