<!-- resources/views/admin.blade.php -->

@extends('admin.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    </div>
    <!-- Charts Section: Orders and Drivers -->
    <div class="flex flex-col md:flex-row gap-6 mt-6">

        <!-- Orders Per Day Card -->
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex flex-col space-y-2">
                <h4 class="text-lg font-semibold">Orders Per Day</h4>
                <p class="text-sm text-white/80">Last 7 days</p>
                <div class="relative h-40">
                    <canvas id="ordersChart" class="absolute inset-0 w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Drivers Signed Up Per Day Card -->
        <div class="bg-blue-500 text-white p-4 rounded-lg shadow-md w-full md:w-1/2">
            <div class="flex flex-col space-y-2">
                <h4 class="text-lg font-semibold">Drivers Signed Up</h4>
                <p class="text-sm text-white/80">Last 7 days</p>
                <div class="relative h-40">
                    <canvas id="driversChart" class="absolute inset-0 w-full h-full"></canvas>
                </div>
            </div>
        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($orders->pluck('day')) !!},
                datasets: [{
                    label: 'Orders',
                    data: {!! json_encode($orders->pluck('total')) !!},
                    backgroundColor: 'rgba(255,255,255,0.2)',
                    borderColor: 'white',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'white',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { color: 'white' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: 'white', precision: 0 },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
    <script>
        const driversCtx = document.getElementById('driversChart').getContext('2d');
        new Chart(driversCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($drivers->pluck('day')) !!},
                datasets: [{
                    label: 'Drivers',
                    data: {!! json_encode($drivers->pluck('total')) !!},
                    backgroundColor: 'rgba(255,255,255,0.2)',
                    borderColor: 'white',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'white',
                    pointBorderColor: 'white',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        ticks: { color: 'white' },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { color: 'white', precision: 0 },
                        grid: { color: 'rgba(255,255,255,0.1)' }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>


    </body>
    </div>

@endsection
