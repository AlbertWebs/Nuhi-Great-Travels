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
    protected $ipnId;

    public function __construct()
    {
        // Choose correct endpoint based on environment
        $this->baseUrl = config('pesapal.env') === 'live'
            ? 'https://pay.pesapal.com/v3'
            : 'https://cybqa.pesapal.com/pesapalv3';

        $this->consumerKey = config('pesapal.consumer_key');
        $this->consumerSecret = config('pesapal.consumer_secret');
        $this->callbackUrl = config('pesapal.callback_url');
        $this->ipnId = config('pesapal.ipn_id');
    }

    /**
     * Get OAuth access token from Pesapal
     */
    public function getAccessToken()
    {
        try {
            $response = Http::withOptions([
                    'verify' => config('pesapal.env') === 'live', // verify SSL only in live
                ])
                ->post("{$this->baseUrl}/api/Auth/RequestToken", [
                    'consumer_key' => $this->consumerKey,
                    'consumer_secret' => $this->consumerSecret,
                ]);

            if (!$response->successful()) {
                Log::error('Pesapal Token Request Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $data = $response->json();

            if (!isset($data['token'])) {
                Log::error('Pesapal Token Missing', ['response' => $data]);
                return null;
            }

            return $data['token'];
        } catch (\Throwable $e) {
            Log::error('Pesapal Auth Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Create a payment order
     */
    public function makePayment(array $data)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            Log::error('Pesapal: Token missing, cannot create payment.');
            return null;
        }

        try {
            $payload = [
                'id' => $data['reference'], // unique reference number
                'currency' => 'KES',
                'amount' => $data['amount'],
                'description' => $data['description'],
                'callback_url' => $this->callbackUrl,
                'billing_address' => [
                    'email_address' => $data['email'],
                    'phone_number' => $data['phone_number'],
                    'country_code' => 'KE',
                    'first_name' => $data['first_name'],
                    'line_1' => $data['line_1'] ?? 'N/A',
                    'city' => $data['city'] ?? 'Nairobi',
                ],
            ];

            // Try with IPN ID first if provided
            if (!empty($this->ipnId)) {
                $payload['notification_id'] = $this->ipnId;
            }

            $response = Http::withToken($token)
                ->withOptions(['verify' => config('pesapal.env') === 'live'])
                ->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $payload);

            $json = $response->json();
            Log::info('Pesapal Order Response', ['response' => $json]);

            // Check if error is due to invalid IPN ID
            if (isset($json['error']) && isset($json['error']['code']) && $json['error']['code'] === 'InvalidIpnId') {
                Log::warning('Pesapal: Invalid IPN ID detected, retrying without IPN ID', [
                    'ipn_id' => $this->ipnId,
                ]);
                
                // Remove IPN ID and retry
                unset($payload['notification_id']);
                
                $response = Http::withToken($token)
                    ->withOptions(['verify' => config('pesapal.env') === 'live'])
                    ->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $payload);

                $json = $response->json();
                Log::info('Pesapal Order Response (retry without IPN)', ['response' => $json]);
            }

            if ($response->successful() && isset($json['redirect_url'])) {
                return $json['redirect_url'];
            }

            Log::error('Pesapal Order Creation Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error('Pesapal makePayment Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Check payment status
     */
    public function getPaymentStatus($orderTrackingId)
    {
        $token = $this->getAccessToken();
        if (!$token) return null;

        try {
            $response = Http::withToken($token)
                ->withOptions(['verify' => config('pesapal.env') === 'live'])
                ->get("{$this->baseUrl}/api/Transactions/GetTransactionStatus?orderTrackingId={$orderTrackingId}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Pesapal Status Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error('Pesapal getPaymentStatus Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
