<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// Use the SDK classes — adjust if your installed package uses different namespaces.
// The package on Packagist is `smile-identity/smile-identity-core`
use SmileIdentity\Signature; // adjust if necessary

class SmileController extends Controller
{
    /**
     * Return a short-lived signature/auth token for the Smile Web SDK.
     *
     * Frontend will call this (AJAX) to get a signature — we never expose the API key.
     */
    public function init(Request $request)
    {
        try {
            $partnerId = config('services.smile.partner_id');
            $apiKey    = config('services.smile.api_key');
            $env       = config('services.smile.environment', 'sandbox');

            // Example usage of Signature::generate — adjust depending on the installed lib version:
            // Many implementations require partner_id, api_key and timestamp to generate signature.
            // If the package you installed has a different API, consult vendor docs.
            $timestamp = time();

            // If the package provides a generate method:
            if (class_exists(\SmileIdentity\Signature::class)) {
                $signature = Signature::generate($partnerId, $apiKey, [
                    'timestamp' => $timestamp,
                    // optionally include other parameters like job_type if SDK supports them here
                ]);
            } else {
                // Fallback: generate HMAC signature manually if required by Smile's server format.
                // Please replace the format below with SmileID's required signature format if needed.
                $payload = $partnerId . '|' . $timestamp;
                $signature = hash_hmac('sha256', $payload, $apiKey);
            }

            return response()->json([
                'partner_id' => $partnerId,
                'signature'  => $signature,
                'timestamp'  => $timestamp,
                'job_type'   => 5, // e.g. Enhanced KYC + liveliness; change as needed
            ]);
        } catch (\Throwable $th) {
            Log::error('Smile init error: ' . $th->getMessage());
            return response()->json(['error' => 'Could not create signature'], 500);
        }
    }

    public function store(Request $request)
        {
            $request->validate([
                'client_id' => 'required|integer',
                'name' => 'required|string',
                // ... other regular fields
                'smile_job_id' => 'nullable|string',
                'smile_result' => 'nullable|string',
            ]);

            $data = $request->only(['client_id', 'name', 'document_type', 'smile_job_id']);
            $data['smile_result'] = $request->input('smile_result');

            // Save to DB (example)
            \App\Models\KycSubmission::create($data);

            return redirect()->route('kyc.thankyou')->with('success', 'KYC submitted successfully.');
        }

}
