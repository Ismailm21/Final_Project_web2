<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Order #{{ $orderId }} - Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: #fff;
            padding: 40px 0;
        }
        .title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .card-container {
            max-width: 700px;
            margin: 0 auto;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            width: 100%;
            font-size: 1.1rem;
            padding: 10px;
            border-radius: 10px;
        }
        .table td, .table th {
            color: #000;
        }
    </style>
</head>
<body>

<h2 class="title">Payment for Order #{{ $orderId }}</h2>

<div class="card-container">
    <div class="card p-4">
        <form action="{{ route('payment.form', ['orderId' => $orderId]) }}" method="POST">
            @csrf

            <!-- Currency Selection -->
          <!--  <div class="mb-3">
                <label for="currency" class="form-label">Currency</label>
                <select name="currency" id="currency" class="form-control" required>
                    @foreach (['USD', 'EUR', 'LBP', 'SAR'] as $cur)
                        <option value="{{ $cur }}" {{ old('currency', $currency) === $cur ? 'selected' : '' }}>
                            {{ $cur }}
                        </option>
                    @endforeach
                </select>
            </div>-->
            <div>
                <select name="currency" id="currency" class="form-control" >
                    @foreach (['USD', 'EUR', 'LBP', 'SAR'] as $cur)
                        <option value="{{ $cur }}" {{ old('currency', $currency) === $cur ? 'selected' : '' }}>
                            {{ $cur }}
                        </option>
                    @endforeach
                </select>

            </div>

            <!-- Payment Method Selection -->
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    @foreach ([
                        'COD' => 'Cash on Delivery (COD)',
                        'credit_card' => 'Credit Card',
                        'CryptoCurrency' => 'CryptoCurrency',
                        'paypal' => 'PayPal'
                    ] as $key => $label)
                        <option value="{{ $key }}" {{ old('payment_method') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Payment Amount (credit card only) -->
            <div class="mb-3" id="amountField" style="display: none;">
                <label for="payment_amount" class="form-label">Amount to Pay (USD)</label>
                <input type="number"
                       name="payment_amount"
                       id="payment_amount"
                       class="form-control"
                       step="0.01"
                       min="0"
                       max="{{ $remainingUSD }}"
                       value="{{ old('payment_amount', $remainingUSD) }}">
                <div class="form-text">Maximum allowed: ${{ number_format($remainingUSD, 2) }}</div>
            </div>

            <button type="submit" class="btn btn-primary btn-custom">Submit Payment</button>
        </form>
    </div>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Payment Summary -->
    <div class="card mt-5 p-4">
        <h5 class="mb-3">Payment Summary</h5>
        <p><strong>Distance:</strong> {{ number_format($distance, 2) }} km</p>
        <p><strong>Total (USD):</strong> ${{ number_format($baseAmount, 2) }}</p>
        <p><strong>Total ({{ $currency }}):</strong> {{ number_format($convertedAmount, 2) }} {{ $currency }}</p>
        <p><strong>Remaining (USD):</strong> ${{ number_format($remainingUSD, 2) }}</p>
    </div>
    <!-- Checkout Button -->
    <div class="mt-4">
        <a href="{{ route('stripe.index') }}" class="btn btn-success btn-custom">
            Proceed to Checkout
        </a>
    </div>
    <button id="togglePaymentsBtn" class="btn btn-info btn-custom mt-3">Show Previous Payments</button>
    <!-- Previous Payments -->
    @if ($payments->count())
       <!-- <div class="card mt-4 p-4">-->
        <div id="previousPayments" class="card mt-4 p-4" style="display:none;">
            <h5 class="mb-3">Previous Payments</h5>
            <table class="table table-striped bg-white">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount (USD)</th>
                    <th>Currency</th>
                    <th>Method</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($payments as $pay)
                    <tr>
                        <td>{{ $pay->created_at->format('Y-m-d') }}</td>
                        <td>${{ number_format($pay->payment_amount, 2) }}</td>
                        <td>{{ $pay->currency }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $pay->payment_method)) }}</td>
                        <td>{{ ucfirst($pay->status) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
</div>
    @endif

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success text-center mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
   document.addEventListener('DOMContentLoaded', function () {
        const paymentMethod = document.getElementById('payment_method');
        const amountField = document.getElementById('amountField');

        function toggleAmountField() {
            amountField.style.display = (paymentMethod.value === 'credit_card') ? 'block' : 'none';
        }

        paymentMethod.addEventListener('change', toggleAmountField);
        toggleAmountField();
    });
  document.addEventListener('DOMContentLoaded', function () {
      const toggleBtn = document.getElementById('togglePaymentsBtn');
      const paymentsCard = document.getElementById('previousPayments');

      toggleBtn.addEventListener('click', function () {
          if (paymentsCard.style.display === 'none') {
              paymentsCard.style.display = 'block';
              toggleBtn.textContent = 'Hide Previous Payments';
          } else {
              paymentsCard.style.display = 'none';
              toggleBtn.textContent = 'Show Previous Payments';
          }
      });
  });
</script>

</body>
</html>
