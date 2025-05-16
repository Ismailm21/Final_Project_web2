@extends('admin.admin')

@section('title', 'Loyalty Program')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Manage Loyalty Program</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.loyalty.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="km_to_points">Points per 2km:</label>
            <input type="number" name="km_to_points" class="form-control" required>
        </div>

        <div class="form-group">
    <label for="points_range">Define Rewards:</label>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Min Points</th>
                <th>Max Points</th>
                <th>Reward</th>
            </tr>
        </thead>
        <tbody id="loyaltyRewardsTable">
            <tr>
                <td><input type="number" name="min_points[]" class="form-control" value="0"></td>
                <td><input type="number" name="max_points[]" class="form-control" value="50"></td>
                <td><input type="text" name="reward[]" class="form-control" value="Discount Code"></td>
            </tr>
            <tr>
                <td><input type="number" name="min_points[]" class="form-control" value="51"></td>
                <td><input type="number" name="max_points[]" class="form-control" value="100"></td>
                <td><input type="text" name="reward[]" class="form-control" value="Free Gift"></td>
            </tr>
        </tbody>
    </table>

    <button type="button" class="btn btn-success" onclick="addRow()">Add Reward Tier</button>
</div>

<script>
function addRow() {
    let table = document.getElementById("loyaltyRewardsTable");
    let newRow = table.insertRow();
    newRow.innerHTML = `
        <td><input type="number" name="min_points[]" class="form-control"></td>
        <td><input type="number" name="max_points[]" class="form-control"></td>
        <td><input type="text" name="reward[]" class="form-control"></td>
    `;
}
</script>

        <button type="submit" class="btn btn-primary">Save Loyalty Program</button>
    </form>

    <h3 class="mt-5">Current Loyalty Rules</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Client ID</th>
                <th>Points Earned</th>
                <th>Reward</th>
            </tr>
        </thead>
        <tbody>
        @foreach($loyaltySettings as $setting)
            <tr>
                <td>{{ $setting->client_id }}</td>
                <td>{{ $setting->points }}</td>
                <td>{{ $setting->reward }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection