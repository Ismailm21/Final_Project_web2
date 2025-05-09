<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Delivery System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="text-center d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">

<h1 class="mb-4">Welcome! Choose Your Role</h1>

<div class="d-flex gap-3">

    <a href="{{ route('client.login') }}" class="btn btn-primary">Client</a>

    <!-- Driver Login -->
    <a href="{{ route('driver.login') }}" class="btn btn-success">Driver</a>

    <!-- Admin Login only (Signup is now hidden) -->
    <a href="{{ route('admin.login') }}" class="btn btn-danger">Admin</a>
</div>

</body>
</html>
