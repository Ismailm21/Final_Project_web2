<!-- resources/views/layouts/sidebar.blade.php -->

<aside class="w-64 bg-white shadow-lg">
    <div class="p-6 text-2xl font-bold border-b border-gray-200">Delivery system Admin</div>
    <nav class="p-4 space-y-4 text-gray-700">
        <a href="{{route('admin.dashboard')}}" class="flex items-center space-x-2 hover:text-blue-600">
            <i class="fas fa-chart-line"></i><span>Dashboard</span>
        </a>
        <a href="{{route('admin.showRequests')}}" class="flex items-center space-x-2 hover:text-blue-600">
            <i class="fas fa-clock"></i><span>Pending Drivers</span>
        </a>
        <a href="{{route('admin.addDriver')}}" class="flex items-center space-x-2 hover:text-blue-600">
            <i class="fas fa-plus"></i><span>Add Drivers</span>
        </a>
        <a href="{{route('admin.driver')}}" class="flex items-center space-x-2 hover:text-blue-600">
            <i class="fas fa-motorcycle"></i><span> Drivers</span>
        </a>
        <a href="#clients" class="flex items-center space-x-2 hover:text-blue-600">
            <i class="fas fa-user"></i><span>Clients</span>
        </a>

    </nav>
</aside>
