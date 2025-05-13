<!-- resources/views/admin.blade.php -->

@extends('admin.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    </div>

    <!-- Driver Form -->
    <section id="drivers" class="bg-white p-6 rounded-lg shadow">
        <!-- form content here... -->
    </section>

    <!-- Driver Table -->
    <div class="bg-white p-6 rounded-lg shadow">
        <head>
            <title>Orders by Day</title>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        </head>
        <body>
        <h2>Orders Per Day of the Week</h2>
        <canvas id="ordersChart" width="600" height="400"></canvas>

        <script>
            const ctx = document.getElementById('ordersChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($orders->pluck('day')) !!},
                    datasets: [{
                        label: 'Orders',
                        data: {!! json_encode($orders->pluck('total')) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        </script>
        </body>
    </div>

@endsection
