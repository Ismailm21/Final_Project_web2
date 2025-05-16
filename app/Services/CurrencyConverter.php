<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('EXCHANGE_RATE_API_KEY');
    }

// Convert currency
public function convert($amount, $fromCurrency, $toCurrency)
{
// Build API URL
$url = "https://v6.exchangerate-api.com/v6/{$this->apiKey}/pair/{$fromCurrency}/{$toCurrency}";

// Make the API request
$response = Http::get($url);

if ($response->successful()) {
// Get the conversion rate
$rate = $response->json()['conversion_rate'];
// Convert the amount
return $amount * $rate;
}

// In case the API fails, return the original amount
return $amount;
}
  /*  public function convert($amount, $fromCurrency, $toCurrency)
    {
        // Build API URL with the base currency
        $url = "https://open.er-api.com/v6/latest/{$fromCurrency}";

        // Call the API
        $response = Http::get($url);

        // Check if the request was successful
        if ($response->successful()) {
            // Extract rates from the response JSON
            // Sometimes the API may use 'rates' or 'conversion_rates' as keys
            $rates = $response->json()['rates'] ?? $response->json()['conversion_rates'] ?? null;

            // If rates exist and target currency is found, convert the amount
            if ($rates && isset($rates[$toCurrency])) {
                return $amount * $rates[$toCurrency];
            }
        }

        // If API call fails or rates missing, log the issue for debugging
        logger('Currency API failed: ' . $response->body());

        // Return original amount as fallback to avoid breaking the app
        return $amount;
    }

*/


}
