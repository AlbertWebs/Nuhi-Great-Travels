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
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;


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

                    // Update related booking status
                    $booking = \App\Models\Booking::where('invoice_id', $invoice->id)->first();
                    if ($booking) {
                        $booking->update(['status' => 'confirmed']);
                    }

                    // Send payment confirmation emails
                    try {
                        $invoice->load('user', 'fleets.car');
                        
                        // Email to client
                        Mail::to($invoice->email)->send(new PaymentConfirmation($invoice, $booking, false));
                        
                        // Email to admin
                        Mail::to('bookings@nuhigreattravels.com')
                            ->cc('albertmuhatia@gmail.com')
                            ->send(new PaymentConfirmation($invoice, $booking, true));
                    } catch (\Exception $e) {
                        Log::error('Failed to send payment confirmation emails', [
                            'error' => $e->getMessage(),
                            'invoice_id' => $invoice->id,
                        ]);
                    }
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

    /**
     * Handle Pesapal IPN (Instant Payment Notification)
     * This endpoint receives server-to-server notifications from Pesapal about payment status
     */
    public function handleIpn(Request $request)
    {
        try {
            // Log incoming IPN request
            Log::info('Pesapal IPN Received', [
                'request_data' => $request->all(),
                'headers' => $request->headers->all(),
                'ip' => $request->ip(),
                'timestamp' => now()->toISOString(),
            ]);

            // Get notification data from request
            // Pesapal sends IPN as either GET or POST with query parameters or body
            $orderTrackingId = $request->input('OrderTrackingId') 
                ?? $request->input('order_tracking_id')
                ?? $request->input('OrderMerchantReference')
                ?? $request->query('OrderTrackingId');

            $orderMerchantReference = $request->input('OrderMerchantReference')
                ?? $request->input('order_merchant_reference')
                ?? $request->input('MerchantReference')
                ?? $request->query('OrderMerchantReference');

            if (!$orderTrackingId && !$orderMerchantReference) {
                Log::warning('Pesapal IPN: Missing tracking ID and merchant reference', [
                    'request_data' => $request->all(),
                ]);
                
                // Return 200 to acknowledge receipt (don't retry)
                return response()->json([
                    'status' => 'accepted',
                    'message' => 'IPN received but missing required data'
                ], 200);
            }

            $pesapal = new PesapalService();
            
            // If we have tracking ID, get payment status from Pesapal
            if ($orderTrackingId) {
                $statusResponse = $pesapal->getPaymentStatus($orderTrackingId);
                
                if ($statusResponse) {
                    Log::info('Pesapal IPN: Payment status retrieved', [
                        'tracking_id' => $orderTrackingId,
                        'status' => $statusResponse,
                    ]);

                    // Process payment status update
                    $this->processPaymentStatus($statusResponse, $orderMerchantReference);
                } else {
                    Log::warning('Pesapal IPN: Could not retrieve payment status', [
                        'tracking_id' => $orderTrackingId,
                    ]);
                }
            } else if ($orderMerchantReference) {
                // If we only have merchant reference, try to find invoice and check status
                Log::info('Pesapal IPN: Processing with merchant reference only', [
                    'merchant_reference' => $orderMerchantReference,
                ]);
                
                $invoice = Invoice::where('invoice_number', $orderMerchantReference)->first();
                if ($invoice && $invoice->payment_reference) {
                    $statusResponse = $pesapal->getPaymentStatus($invoice->payment_reference);
                    if ($statusResponse) {
                        $this->processPaymentStatus($statusResponse, $orderMerchantReference);
                    }
                }
            }

            // Always return 200 OK to acknowledge receipt
            // Pesapal will retry if we return an error status
            return response()->json([
                'status' => 'accepted',
                'message' => 'IPN processed successfully'
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Pesapal IPN Processing Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
            ]);

            // Still return 200 to prevent Pesapal from retrying immediately
            // We'll handle the error internally
            return response()->json([
                'status' => 'accepted',
                'message' => 'IPN received but processing failed'
            ], 200);
        }
    }

    /**
     * Process payment status update from IPN
     */
    private function processPaymentStatus($statusResponse, $merchantReference = null)
    {
        try {
            $merchantRef = $merchantReference ?? $statusResponse['merchant_reference'] ?? null;
            
            if (!$merchantRef) {
                Log::warning('Pesapal IPN: No merchant reference found', [
                    'status_response' => $statusResponse,
                ]);
                return;
            }

            // Find invoice by merchant reference (invoice number)
            $invoice = Invoice::where('invoice_number', $merchantRef)->first();

            if (!$invoice) {
                Log::warning('Pesapal IPN: Invoice not found', [
                    'merchant_reference' => $merchantRef,
                ]);
                return;
            }

            // Save or update transaction record
            $trackingId = $statusResponse['order_tracking_id'] ?? $statusResponse['tracking_id'] ?? null;
            
            if ($trackingId) {
                $transaction = PesapalTransaction::updateOrCreate(
                    ['tracking_id' => $trackingId],
                    [
                        'merchant_reference' => $merchantRef,
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
            }

            // Check if payment is completed
            $isCompleted = isset($statusResponse['payment_status_description']) 
                && strtolower($statusResponse['payment_status_description']) === 'completed';

            // Only update if status changed to avoid duplicate processing
            if ($isCompleted && $invoice->status !== 'paid') {
                $invoice->update([
                    'status' => 'paid',
                    'payment_reference' => $trackingId ?? $invoice->payment_reference,
                    'payment_date' => now(),
                ]);

                // Update related booking status
                $booking = \App\Models\Booking::where('invoice_id', $invoice->id)->first();
                if ($booking && $booking->status !== 'confirmed') {
                    $booking->update(['status' => 'confirmed']);
                }

                Log::info('Pesapal IPN: Payment processed successfully', [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'booking_id' => $booking->id ?? null,
                    'amount' => $statusResponse['amount'] ?? $invoice->total_price,
                ]);

                // Send payment confirmation emails
                try {
                    $invoice->load('user', 'fleets.car');
                    $booking = $booking ?? \App\Models\Booking::where('invoice_id', $invoice->id)->first();
                    
                    // Email to client
                    Mail::to($invoice->email)->send(new PaymentConfirmation($invoice, $booking, false));
                    
                    // Email to admin
                    Mail::to('bookings@nuhigreattravels.com')
                        ->cc('albertmuhatia@gmail.com')
                        ->send(new PaymentConfirmation($invoice, $booking, true));
                        
                    Log::info('Pesapal IPN: Payment confirmation emails sent', [
                        'invoice_id' => $invoice->id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Pesapal IPN: Failed to send payment confirmation emails', [
                        'error' => $e->getMessage(),
                        'invoice_id' => $invoice->id,
                    ]);
                }
            } else {
                Log::info('Pesapal IPN: Payment status update skipped', [
                    'invoice_id' => $invoice->id,
                    'current_status' => $invoice->status,
                    'payment_status' => $statusResponse['payment_status_description'] ?? 'unknown',
                    'is_completed' => $isCompleted,
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Pesapal IPN: Error processing payment status', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'merchant_reference' => $merchantReference,
            ]);
            throw $e;
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
