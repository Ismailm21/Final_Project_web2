
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <style>
        #map-container {
            height: 300px;
            width: 100%;
            border-radius: 0.5rem;
            margin-top: 1rem;
            border: 1px solid #e2e8f0;
        }
        .pac-container {
            z-index: 1050 !important;
        }
        .dropdown-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .dropdown-menu.active {
            max-height: 200px;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex min-h-screen">

    <aside class="w-64 bg-white shadow-lg">
        <div class="p-6 text-2xl font-bold border-b border-gray-200">Hello {{Auth::user()->name}}</div>
        <nav class="p-4 space-y-4 text-gray-700">

            <a href="{{route("driver.Menu")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-home"></i><span>Home</span>
            </a>

            <a href="{{route("driver.myEarnings")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-dollar-sign"></i><span>Earnings</span>
            </a>

            <a href="{{route("driver.myProfile")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-user"></i><span>My Profile</span>
            </a>
            <a href="{{route("driver.myCalendar")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-calendar-alt"></i><span>Calendar</span>
            </a>
            <div>
                <button onclick="toggleDropdown()" class="w-full flex items-center space-x-2 hover:text-blue-600">
                    <i class="fas fa-truck"></i>
                    <span>Orders</span>
                    <i class="fas fa-chevron-down ml-2 transition-transform duration-200" id="orderIcon"></i>
                </button>
                <div id="ordersDropdown" class="dropdown-menu pl-6 mt-2">
                    <a href="{{route("driver.pendingOrders")}}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                        <i class="fas fa-exclamation-circle mr-2"></i>Pending
                    </a>
                    <a href="{{route("driver.inProcessOrders")}}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                        <i class="fas fa-spinner mr-2"></i>Processing
                    </a>
                    <a href="{{route("driver.completedOrders")}}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                        <i class="fas fa-check mr-2"></i>Completed
                    </a>
                    <a href="{{route("driver.cancelledOrders")}}" class="block py-2 text-sm text-gray-700 hover:text-blue-600">
                        <i class="fas fa-times mr-2"></i>Cancelled
                    </a>
                </div>
            </div>
            <a href="{{route("driver.manageAvailability")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-clock"></i><span>Manage Availability</span>
            </a>
            <a href="{{route("driver.AreaAndPricing")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-map-marker-alt"></i><span>Edit Delivery Area</span>
            </a>
            <a href="{{route("driver.myReviews")}}" class="flex items-center space-x-2 hover:text-blue-600">
                <i class="fas fa-star"></i><span>My Reviews</span>
            </a>

        </nav>
    </aside>

    <main class="flex-1 p-6 space-y-8">
        <header class="flex items-center justify-between bg-white shadow-lg rounded-lg p-4">
            <h1 class="text-3xl font-bold text-gray-800">@yield('page_title')</h1>
            <div class="flex items-center space-x-4">
                <a href="{{route("driver.logout")}}" class="text-red-600 hover:text-red-800">Logout</a>
            </div>
        </header>

        <div class="bg-white shadow-lg rounded-lg p-6">
            @yield('page-content')
        </div>
    </main>
</div>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('ordersDropdown');
        const icon = document.getElementById('orderIcon');
        dropdown.classList.toggle('active');
        icon.style.transform = dropdown.classList.contains('active') ? 'rotate(180deg)' : 'rotate(0)';
    }
</script>

<script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.0.0/firebase-messaging-compat.js"></script>

<script>
  // Firebase config
    const firebaseConfig = {
    apiKey: "AIzaSyC6aFmhBk0uDDgwlxy-Sg9LaTNkGdDvZdA",
    authDomain: "quickdeliver-709e2.firebaseapp.com",
    projectId: "quickdeliver-709e2",
    storageBucket: "quickdeliver-709e2.appspot.com",
    messagingSenderId: "433277533156",
    appId: "1:433277533156:web:e9497d040ba9ef0af025f1"
    };


  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

    function startFCM() {
    Notification.requestPermission().then(function(permission) {
        if (permission === "granted") {
        messaging.getToken({
            vapidKey: "BErMcQcZmYlw8IUIahhGcJxxRYgMQe8E51PrdYliZRwI0VdsnWl3L2_cUbcn8AOCuBCuZiAM3FWR-7hYF7-v1Es" // Replace with your VAPID key
        }).then(function(token) {
            console.log("FCM Token:", token);

            fetch('{{ route("storeFCMtoken") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Authorization': 'Bearer {{ auth()->user()->api_token ?? '' }}'
            },
            body: JSON.stringify({ device_token: token })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Token stored successfully:', data);
            })
            .catch(error => {
                console.error('Error storing token:', error);
            });

        }).catch(function(err) {
            console.error('Failed to get token:', err);
        });
        } else {
        console.error('Permission not granted for Notification');
        }
    });
    }


  // Run it on page load
  startFCM();
</script>
</body>
</html>
