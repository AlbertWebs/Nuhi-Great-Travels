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
        // Only set IPN ID if it's a non-empty string
        $ipnId = config('pesapal.ipn_id');
        $this->ipnId = (!empty($ipnId) && is_string($ipnId) && trim($ipnId) !== '') ? trim($ipnId) : null;
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

            // Only add notification_id if we have a valid IPN ID
            // Completely omit the field if IPN ID is not set (don't send null or empty)
            if ($this->ipnId !== null) {
                $payload['notification_id'] = $this->ipnId;
            }

            $response = Http::withToken($token)
                ->withOptions(['verify' => config('pesapal.env') === 'live'])
                ->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $payload);

            $json = $response->json();
            Log::info('Pesapal Order Response', [
                'response' => $json,
                'ipn_id_used' => $this->ipnId,
                'payload_keys' => array_keys($payload),
            ]);

            // Check if error is due to invalid IPN ID
            if (isset($json['error']) && isset($json['error']['code']) && $json['error']['code'] === 'InvalidIpnId') {
                Log::warning('Pesapal: Invalid IPN ID detected', [
                    'ipn_id' => $this->ipnId,
                    'config_ipn_id' => config('pesapal.ipn_id'),
                ]);
                
                // If we used an IPN ID, retry without it
                if (isset($payload['notification_id'])) {
                    unset($payload['notification_id']);
                    
                    Log::info('Retrying payment request without IPN ID');
                    
                    $response = Http::withToken($token)
                        ->withOptions(['verify' => config('pesapal.env') === 'live'])
                        ->post("{$this->baseUrl}/api/Transactions/SubmitOrderRequest", $payload);

                    $json = $response->json();
                    Log::info('Pesapal Order Response (retry without IPN)', ['response' => $json]);
                }
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
     * Register an IPN (Instant Payment Notification) URL
     * This should be called once to register your IPN URL and get an IPN ID
     * 
     * @param string $ipnNotificationUrl The URL where Pesapal will send payment notifications
     * @return string|null The IPN ID if successful, null otherwise
     */
    public function registerIpn($ipnNotificationUrl)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            Log::error('Pesapal: Token missing, cannot register IPN.');
            return null;
        }

        try {
            $payload = [
                'url' => $ipnNotificationUrl,
                'ipn_notification_type' => 'GET', // or 'POST' depending on your preference
            ];

            $response = Http::withToken($token)
                ->withOptions(['verify' => config('pesapal.env') === 'live'])
                ->post("{$this->baseUrl}/api/URLSetup/RegisterIPN", $payload);

            $json = $response->json();
            Log::info('Pesapal IPN Registration Response', ['response' => $json]);

            if ($response->successful() && isset($json['ipn_id'])) {
                Log::info('IPN registered successfully', [
                    'ipn_id' => $json['ipn_id'],
                    'ipn_url' => $ipnNotificationUrl,
                ]);
                return $json['ipn_id'];
            }

            Log::error('Pesapal IPN Registration Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Throwable $e) {
            Log::error('Pesapal registerIpn Exception', ['message' => $e->getMessage()]);
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
