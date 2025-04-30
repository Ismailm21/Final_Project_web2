<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-4 shadow" style="width: 400px;">
    <h3 class="mb-4 text-center">Admin Sign Up</h3>
    <form method="POST" action="{{ route('admin.signup.submit') }}">
        @csrf

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-danger w-100">Sign Up</button>

        <div class="text-center mt-3">
            <p>Already have an account? <a href="{{ route('admin.login') }}">Login here</a></p>
        </div>
    </form>
</div>

</body>
</html>
<div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
</div>
