<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stripe Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        body {
            background: linear-gradient(to right, #43cea2, #185a9d);
            padding: 40px 0;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
        }

        .title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 30px;
        }

        .checkout-card {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            color: #333;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .stripe-box {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            background-color: #fff;
        }

        .btn-custom {
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 10px;
            width: 100%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .alert-custom {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 2px solid green;
            color: green;
            border-radius: 10px;
            background-color: #e9ffe9;
        }
    </style>
</head>
<body>

<h2 class="title">Stripe Checkout</h2>

@if (session('success'))
    <div class="alert-custom">Payment Successful!</div>
@endif

<div class="checkout-card">
    <form id="checkout-form" method="POST" action="{{ url('/stripe/create-charge') }}">
        @csrf
        <input type="hidden" name="stripeToken" id="stripe-token-id">

        <div id="card-element" class="stripe-box"></div>

        <button id="pay-btn" class="btn btn-success btn-custom mt-2" type="button" onclick="createToken()">
            PAY
        </button>
    </form>
</div>
<br>
<br>
<!-- New button with same size as the card -->
<a href="{{route('clientOrders')}}" class="btn btn-info btn-custom " style="background-color:#43cea2" type="button">
   Re-pay
</a>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();

    const style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
            '::placeholder': {
                color: '#aab7c4'
            },
            fontFamily: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif",
        },
        invalid: {
            color: '#fa755a',
        }
    };

    const card = elements.create('card', { style: style });
    card.mount('#card-element');

    function createToken() {
        document.getElementById("pay-btn").disabled = true;
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                alert(result.error.message);
                document.getElementById("pay-btn").disabled = false;
            } else {
                document.getElementById("stripe-token-id").value = result.token.id;
                document.getElementById("checkout-form").submit();
            }
        });
    }
</script>

</body>
</html>
