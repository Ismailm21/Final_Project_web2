<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-4 shadow" style="width: 400px;">
    <h3 class="mb-4 text-center">Admin Login</h3>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Login</button>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="{{ route('admin.signup') }}">Sign up here</a></p>
        </div>
    </form>
</div>

</body>
</html>
<div>
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
</div>
