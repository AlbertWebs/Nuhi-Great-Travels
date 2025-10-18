<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PesapalService
{
    protected $baseUrl;
    protected $consumerKey;
    protected $consumerSecret;
    protected $callbackUrl;

    public function __construct()
    {
        $this->baseUrl = config('pesapal.env') === 'live'
            ? 'https://pay.pesapal.com/v3'
            : 'https://cybqa.pesapal.com/pesapalv3';
        $this->consumerKey = config('pesapal.consumer_key');
        $this->consumerSecret = config('pesapal.consumer_secret');
        $this->callbackUrl = config('pesapal.callback_url');
    }

    /**
     * Get OAuth access token from Pesapal
     */
    public function getAccessToken()
    {
        $response = Http::post("{$this->baseUrl}/api/Auth/RequestToken", [
            'consumer_key' => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret,
        ]);

        if ($response->successful()) {
            return $response->json()['token'];
        }

        Log::error('Pesapal Token Error', ['response' => $response->json()]);
        return null;
    }

    /**
     * Create a payment order
     */
    public function makePayment(array $data)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", [
                'id' => $data['reference'],
                'currency' => 'KES',
                'amount' => $data['amount'],
                'description' => $data['description'],
                'callback_url' => $this->callbackUrl,
                'notification_id' => '', // optional: if you have IPN setup
                'billing_address' => [
                    'email_address' => $data['email'],
                    'phone_number' => $data['phone_number'],
                    'country_code' => 'KE',
                    'first_name' => $data['first_name'],
                    'line_1' => 'N/A',
                    'city' => 'Nairobi',
                ],
            ]);

        if ($response->successful()) {
            return $response->json()['redirect_url'] ?? null;
        }

        Log::error('Pesapal Order Error', ['response' => $response->json()]);
        return null;
    }

    /**
     * Check payment status
     */
    public function getPaymentStatus($reference)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/api/Transactions/GetTransactionStatus?orderTrackingId={$reference}");

        return $response->json();
    }
}
