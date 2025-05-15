<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delivery Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Delivery Reports</h1>

    <div class="row mb-4">
        <div class="col-md-3"><strong>Center Share:</strong> ${{ number_format($centerShareTotal, 2) }}</div>
        <div class="col-md-3"><strong>Driver Share:</strong> ${{ number_format($driverShareTotal, 2) }}</div>
        <div class="col-md-3"><strong>Clients:</strong> {{ $clients }}</div>
        <div class="col-md-3"><strong>Orders:</strong> {{ $ordersCount }}</div>
    </div>

    <form method="GET" action="{{ route('admin.reports') }}" class="mb-4 form-inline">
        <div class="form-group mr-2">
            <label for="from" class="mr-2">From:</label>
            <input type="date" name="from" id="from" value="{{ $from }}" class="form-control">
        </div>
        <div class="form-group mr-2">
            <label for="to" class="mr-2">To:</label>
            <input type="date" name="to" id="to" value="{{ $to }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Apply Filter</button>
    </form>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Total Paid</th>
            <th>Remaining</th>
            <th>Driver Share ($ / %)</th>
            <th>Center Share ($ / %)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($detailedReports as $report)
            <tr>
                <td>${{ number_format($report['total_paid'], 2) }}</td>
                <td>${{ number_format($report['remaining'], 2) }}</td>
                <td>${{ number_format($report['driver_share'], 2) }} ({{ $report['driver_percent'] }}%)</td>
                <td>${{ number_format($report['center_share'], 2) }} ({{ $report['center_percent'] }}%)</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
