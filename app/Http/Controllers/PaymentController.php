<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Setting;
use Illuminate\Http\Request;
use Pesapal\Pesapal; // if using Pesapal SDK or API wrapper
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\PesapalService;
use App\Models\PesapalTransaction;


class PaymentController extends Controller
{
    // Show payment page
    public function showPaymentPage(Invoice $invoice)
    {
        $Settings = Setting::first();
        return view('frontend.payment', compact('invoice', 'Settings'));
    }

    // Optional: Handle payment submission
    public function processPayment(Request $request, Invoice $invoice)
    {
        $pesapal = new PesapalService();

        $reference = 'INV-' . Str::upper(Str::random(8));

        $paymentData = [
            'amount' => $invoice->total_price,
            'description' => 'Payment for ' . ($invoice->description ?? 'Car Hire Service'),
            'reference' => $reference,
            'first_name' => $invoice->full_name,
            'email' => $invoice->email,
            'phone_number' => $invoice->mpesa_number ?? '',
        ];

        $invoice->update([
            'status' => 'pending',
            'payment_reference' => $reference,
        ]);

        $paymentUrl = $pesapal->makePayment($paymentData);

        if ($paymentUrl) {
            return redirect()->away($paymentUrl);
        }

        return back()->with('error', 'Unable to initiate payment. Please try again.');
    }

    public function paymentCallback(Request $request)
    {
        try {
            $trackingId = $request->pesapal_transaction_tracking_id ?? $request->tracking_id;
            $reference = $request->orderTrackingId ?? $request->reference;

            $pesapal = new PesapalService();
            $statusResponse = $pesapal->getPaymentStatus($trackingId);

            if (!$statusResponse) {
                throw new \Exception('Empty response from Pesapal API');
            }

            // Save or update transaction
            $transaction = PesapalTransaction::updateOrCreate(
                ['tracking_id' => $trackingId],
                [
                    'merchant_reference' => $statusResponse['merchant_reference'] ?? $reference,
                    'payment_method' => $statusResponse['payment_method'] ?? null,
                    'payment_status' => $statusResponse['status'] ?? null,
                    'payment_status_description' => $statusResponse['payment_status_description'] ?? null,
                    'amount' => $statusResponse['amount'] ?? null,
                    'currency' => $statusResponse['currency'] ?? 'KES',
                    'sender_phone' => $statusResponse['sender_phone'] ?? null,
                    'sender_name' => $statusResponse['sender_name'] ?? null,
                    'raw_response' => $statusResponse,
                ]
            );

            // If payment successful, update invoice
            if (
                isset($statusResponse['payment_status_description']) &&
                strtolower($statusResponse['payment_status_description']) === 'completed'
            ) {
                $invoice = Invoice::where('invoice_number', $statusResponse['merchant_reference'])->first();

                if ($invoice) {
                    $invoice->update([
                        'status' => 'paid',
                        'payment_reference' => $trackingId,
                        'payment_date' => now(),
                    ]);
                }

                return redirect()->route('frontend.payment.thankyou')
                    ->with('success', 'Payment successful! Thank you.');
            }

            return redirect()->route('frontend.payment.show', $reference)
                ->with('error', 'Payment failed, cancelled, or still processing.');
        } catch (\Throwable $e) {
            Log::error('Pesapal callback error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('frontend.payment.show', $request->reference ?? 'unknown')
                ->with('error', 'Something went wrong while verifying your payment.');
        }
    }

    public function testPesapalToken()
    {
        try {
            $pesapal = new PesapalService();
            dd($pesapal);
            $token = $pesapal->getAccessToken();

            if ($token) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesapal token generated successfully!',
                    'token' => $token,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate Pesapal token. Check logs for details.',
                ], 500);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating Pesapal token: ' . $e->getMessage(),
            ], 500);
        }
    }

}
