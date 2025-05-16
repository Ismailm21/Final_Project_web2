<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Stripe;
use App\Models\Order;
use App\Models\Driver;
use App\Models\Address;
use App\Models\Payment;
use App\Services\CurrencyConverter;


class PaymentController extends Controller
{
    public function currencyForm(Request $request, $orderId, CurrencyConverter $converter)
    {
      /*  $order = Order::with(['client', 'driver'])->findOrFail($orderId);
        $driver = $order->driver;

        $pickup = Address::findOrFail($order->pickup_address_id);
        $dropoff = Address::findOrFail($order->dropoff_address_id);

        $distance = $this->haversineDistance(
            $pickup->latitude, $pickup->longitude,
            $dropoff->latitude, $dropoff->longitude
        );

        $baseCost = $driver->pricing_model === 'fixed'
            ? $driver->fixed_rate
            : $driver->rate_per_km * $distance;

        $commission = $baseCost * 0.10;
        $totalUSD = round($baseCost + $commission, 2);
        $payment_amount = $request->payment_amount;
        $selectedCurrency = $request->currency ?? 'USD';
        $payment_amount = $request->payment_amount ?? 0;
    /*    if ($selectedCurrency !== 'USD') {
            $payment_amount_usd = round($converter->convert($totalUSD, 'USD',$selectedCurrency, ), 2);
        } else {
            $payment_amount_usd = $payment_amount;
        }

        $payment_amount_usd = $selectedCurrency === 'USD'
            ? $totalUSD
            : round($converter->convert($totalUSD, 'USD', $selectedCurrency), 2);

        $existingPayments = Payment::where('order_id', $orderId)->get();
        $remainingUSD = $totalUSD - $existingPayments->sum('payment_amount');

        if ($request->isMethod('post')) {
            $request->validate([
                'currency' => 'required|in:USD,EUR,LBP,SAR',
                'payment_method' => 'required|in:credit_card,CryptoCurrency,COD,paypal',
                'payment_amount' => 'nullable|numeric|min:0',
            ]);*/
        $order = Order::with(['client', 'driver'])->findOrFail($orderId);
        $driver = $order->driver;

        $pickup = Address::findOrFail($order->pickup_address_id);
        $dropoff = Address::findOrFail($order->dropoff_address_id);

        $distance = $this->haversineDistance(
            $pickup->latitude, $pickup->longitude,
            $dropoff->latitude, $dropoff->longitude
        );

        $baseCost = $driver->pricing_model === 'fixed'
            ? $driver->fixed_rate
            : $driver->rate_per_km * $distance;

        $commission = $baseCost * 0.10;
        $totalUSD = round($baseCost + $commission, 2);

        $existingPayments = Payment::where('order_id', $orderId)->get();
        $remainingUSD = $totalUSD - $existingPayments->sum('payment_amount');

        // Default selected currency before POST or fallback to old input
        $selectedCurrency = $request->input('currency', 'USD');

        if ($request->isMethod('post')) {
            $request->validate([
                'currency' => 'required|in:USD,EUR,LBP,SAR',
                'payment_method' => 'required|in:credit_card,CryptoCurrency,COD,paypal',
                'payment_amount' => 'nullable|numeric|min:0',
            ]);

            $selectedCurrency = $request->currency;
            $payment_amount = $request->payment_amount ?? 0;

            if ($payment_amount > $remainingUSD) {
                return back()
                    ->withErrors(['payment_amount' => 'The entered amount exceeds the remaining balance.'])
                    ->withInput();
            }
            $payment_amount=$request->payment_amount;
            $selectedCurrency = $request->currency;

            if ($payment_amount > $remainingUSD) {
                return back()
                    ->withErrors(['payment_amount' => 'The entered amount exceeds the remaining balance.'])
                    ->withInput();
            }
            $payment = new Payment();
            $payment->client_id = $order->client_id;
            $payment->order_id = $order->id;
            $payment->total_amount = $totalUSD;
            $payment->payment_amount = $request->payment_amount;
            $payment->remaining_amount = $remainingUSD -$payment_amount;
            $payment->currency = $selectedCurrency;
            $payment->payment_method = $request->payment_method;
            $order->tracking_code = strtoupper(Str::random(10));
            $remainingAfterPayment = $remainingUSD - $payment_amount;

            if ($request->payment_method === 'credit_card') {
                $payment->status = ($remainingAfterPayment <= 0) ? 'paid' : 'pending';
            } else {
                $payment->status = 'pending';
            }


          //  $payment->status = $request->payment_method === 'credit_card' ? 'paid' : 'pending';
            $payment->save();

         /*   return back()->with([
                'success' => 'Payment added successfully.',
            ])->withInput(['currency' => $selectedCurrency]);*/
            return redirect()->route('payment.form', [
                'orderId' => $orderId,
                'currency' => $selectedCurrency
            ])->with('success', 'Payment added successfully.');
        }
        $convertedAmount = $selectedCurrency === 'USD'
            ? $totalUSD
            : round($converter->convert($totalUSD, 'USD', $selectedCurrency), 2);
       // return view('client.currency-form');

     return view('client.currency-form', [
            'orderId' => $orderId,
            'pickup' => $pickup,
            'dropoff' => $dropoff,
            'distance' => $distance,
            'baseAmount' => $totalUSD,
            'convertedAmount' =>$convertedAmount,// $payment_amount_usd
            'currency' => $selectedCurrency,
            'remainingUSD' => $remainingUSD,
            'payments' => $existingPayments,
        ]);
       // return Response()->json([$selectedCurrency, $payment_amount_usd, $payment_amount, $remainingUSD]);


    }







    /* public function calculateAndStorePayment(Request $request, $orderId, CurrencyConverter $converter)
     {
         $request->validate([
             'currency' => 'required|in:USD,EUR,LBP,SAR',
         ]);

         $order = Order::with(['client', 'driver', 'pickupAddress', 'dropoffAddress'])->findOrFail($orderId);
         $driver = $order->driver;

         $pickup = Address::findOrFail($order->pickup_address_id);
         $dropoff = Address::findOrFail($order->dropoff_address_id);

         $distance = $this->haversineDistance(
             $pickup->latitude, $pickup->longitude,
             $dropoff->latitude, $dropoff->longitude
         );

         if ($driver->pricing_model === 'fixed') {
             $totalCost = $driver->fixed_rate;
         } elseif ($driver->pricing_model === 'perKilometer') {
             $totalCost = $driver->rate_per_km * $distance;
         } else {
             $totalCost = 0;
         }

         $commission = $totalCost * 0.10;
         $totalCostWithCommission = $totalCost + $commission;

         $selectedCurrency = $request->currency;

         $convertedAmount = $selectedCurrency === 'USD'
             ? $totalCostWithCommission
             : $converter->convert($totalCostWithCommission, 'USD', $selectedCurrency);

         // Store payment in USD as base
         $payment = Payment::create([
             'client_id' => $order->client_id,
             'order_id' => $order->id,
             'total_amount' => $totalCostWithCommission,
             'remaining_amount' => $totalCostWithCommission,
             'currency' => 'USD',
             'payment_method' => 'COD',
             'status' => 'pending',
         ]);

         // Return view or JSON
         return view('client.payment-summary', [
             'pickup' => $pickup,
             'dropoff' => $dropoff,
             'distance' => $distance,
             'baseAmount' => $totalCostWithCommission,
             'convertedAmount' => $convertedAmount,
             'currency' => $selectedCurrency,
         ]);
     }*/

    /*  public function calculateAndStorePayment($orderId)
      {
          $order = Order::with(['client', 'driver', 'pickupAddress', 'dropoffAddress'])->findOrFail($orderId);
          $driver = $order->driver;

          $pickup = Address::findOrFail($order->pickup_address_id);
          $dropoff = Address::findOrFail($order->dropoff_address_id);

          $distance = $this->haversineDistance(
              $pickup->latitude, $pickup->longitude,
              $dropoff->latitude, $dropoff->longitude
          );

          $totalCost = 0;
          if ($driver->pricing_model === 'fixed') {
              $totalCost = $driver->fixed_rate;
          } elseif ($driver->pricing_model === 'perKilometer') {
              $totalCost = $driver->rate_per_km * $distance;
          }
          $commission = $totalCost * 0.10;
          $totalCostWithCommission = $totalCost + $commission;
          // Store payment
          $payment = Payment::create([
              'client_id' => $order->client_id,
              'order_id' => $order->id,
              'total_amount' => $totalCost,
              'remaining_amount' => $totalCost,
              'currency' => 'USD',
              'payment_method' => 'COD',
              'status' => 'pending',
          ]);

          return response()->json([  $pickup->latitude, $pickup->longitude,
              $dropoff->latitude, $dropoff->longitude,  $distance,$totalCost,$driver->fixed_rate,$driver->rate_per_km,
              $totalCostWithCommission]);
      }
  */
    private function haversineDistance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371)
    {
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($lat1) * cos($lat2) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }
    public function index()
    {
        return view('client.checkout');
    }


    public function createCharge(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
            "amount" => 5 * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" => "Binaryboxtuts Payment Test"
        ]);

        return redirect('stripe')->with('success', 'Payment Successful!');
    }




    /*  public function convertCurrency(Request $request, CurrencyConverter $converter)

      {

          // Validate the user input
          $request->validate([
              'currency' => 'required|in:USD,EUR,LBP,SAR', // Available currencies
          ]);

          $usdPrice = 50; // Original price in USD
          $selectedCurrency = $request->currency;

          // Perform conversion
          $convertedPrice = $selectedCurrency === 'USD'
              ? $usdPrice
              : $converter->convert($usdPrice, 'USD', $selectedCurrency);

          // Return view with converted price
          return view('client.currency-form', [
              'selectedCurrency' => $selectedCurrency,
              'convertedPrice' => $convertedPrice,
              'usdPrice' => $usdPrice
          ]);

      }
  */

}
