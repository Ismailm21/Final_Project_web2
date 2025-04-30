<!-- resources/views/layouts/admin.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/logo.png') }}">

</head>
<body class="bg-gray-100 font-sans">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <main class="flex-1 p-6 space-y-8">
        <!-- Stat Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Total Revenue</h3>
                <p class="text-2xl font-bold text-green-600">$34,245</p>
                <p class="text-xs text-gray-400">Not bad</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Fixed Issues</h3>
                <p class="text-2xl font-bold text-red-600">75</p>
                <p class="text-xs text-gray-400">Tracked from GitHub</p>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-gray-600 text-sm">Available Drivers</h3>
                <p class="text-2xl font-bold text-blue-400">+245</p>
                <p class="text-xs text-gray-400">Just Updated</p>
            </div>
        </div>
    <main class="flex-1 p-6 space-y-8">
        @yield('content')
    </main>
    </main>
</div>
</body>
</html>
