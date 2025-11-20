<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Fleet;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;




class BookingController extends Controller
{
    public function step1()
    {
        $cars = Car::all();
        return view('frontend.bookings.step1', compact('cars'));
    }

    public function storeStep1(Request $request)
    {
        // Log request early so we know the route/controller is hit
        Log::info('storeStep1 called', $request->all());

        // Validate using the HTML5 datetime-local format (no timezone, no seconds)
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:fleets,id',
            'pickup_datetime' => ['required','date_format:Y-m-d\TH:i'],
            'dropoff_datetime' => ['required','date_format:Y-m-d\TH:i'],
            'pickup_location' => 'required|string|max:255',
        ]);
        // Fetch the car to get price_per_day
        $car = \App\Models\Fleet::findOrFail($request->car_id);

        // Calculate number of days (always at least 1)
        $pickup = \Carbon\Carbon::parse($request->pickup_datetime);
        $dropoff = \Carbon\Carbon::parse($request->dropoff_datetime);
        $days = max(1, $pickup->diffInDays($dropoff));
        // Calculate total price
        $totalPrice = $days * $car->price_per_day;
        Log::info('storeStep1 saved session '.$totalPrice);

        if ($validator->fails()) {
            Log::info('storeStep1 validation failed', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Parse the values into Carbon to compare correctly
        try {
            $pickup = Carbon::createFromFormat('Y-m-d\TH:i', $request->pickup_datetime);
            $dropoff = Carbon::createFromFormat('Y-m-d\TH:i', $request->dropoff_datetime);
        } catch (\Exception $e) {
            Log::error('Datetime parse error in storeStep1: '.$e->getMessage());
            return redirect()->back()->withErrors(['pickup_datetime' => 'Invalid date/time format'])->withInput();
        }

        // Business checks
        if ($pickup->lt(Carbon::now())) {
            return redirect()->back()->withErrors(['pickup_datetime' => 'Pickup date/time must be in the future'])->withInput();
        }
        if ($dropoff->lte($pickup)) {
            return redirect()->back()->withErrors(['dropoff_datetime' => 'Dropoff must be after pickup'])->withInput();
        }

        // Save session (store ISO string or formatted string)
        session([
            'booking.step1' => [
                'car_id' => (int)$request->car_id,
                'pickup_datetime' => $pickup->toDateTimeString(),   // "YYYY-MM-DD HH:MM:SS"
                'dropoff_datetime' => $dropoff->toDateTimeString(),
                'pickup_location' => $request->pickup_location,
                'total_price' => round($totalPrice / 100) * 100,
                'days' => round($days),
                'car' =>$car->name,
            ],
        ]);

        Log::info('storeStep1 saved session', session('booking.step1'));

        return redirect()->route('bookings.step2');
    }

    public function step2()
    {
        $page_title = "Bookings";

        if (!session('booking.step1')) {
            return redirect()->route('bookings.step1');
        }
        return view('frontend.bookings.step2', compact('page_title'));
    }


    public function storeStep2(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
        ]);

        $step1 = session('booking.step1');
        $car = Fleet::findOrFail($step1['car_id']);

        // --- Check or Create User ---
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->full_name,
                'phone' => $request->mobile,
                'password' => Hash::make(Str::random(10)),
            ]
        );

        Auth::login($user);

        // --- Calculate total price ---
        $pickup = Carbon::parse($step1['pickup_datetime']);
        $dropoff = Carbon::parse($step1['dropoff_datetime']);
        $hours = $dropoff->diffInHours($pickup);
        $total_price = $hours * $car->rate_per_hour;

        // --- Store step 2 data ---
        session([
            'booking.step2' => $request->only(['full_name', 'email', 'mobile']),
            'booking.total_price' => $total_price,
        ]);

        // --- Redirect to Smile ID verification link ---
        $smileIdUrl = "https://links.sandbox.usesmileid.com/7578/ce4bd7ab-87df-4eea-a07e-3770e8829d0e";


        return redirect()->away($smileIdUrl);
    }


    public function step3()
    {
        $Settings = Setting::first();
        Auth::user()->update(['kyc_token' => Str::uuid()]);
        $client = User::find(Auth::User()->id);
        if (!session('booking.step2')) {
            return redirect()->route('bookings.step2');
        }

        $total_price = session('booking.total_price');
        return view('frontend.bookings.step3', compact('total_price','Settings','client'));
    }

    public function complete(Request $request)
    {
        $request->validate([
            'kyc_document' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        $step1 = session('booking.step1');
        $step2 = session('booking.step2');
        $total_price = session('booking.total_price');

        $filePath = $request->file('kyc_document')->store('kyc', 'public');

        $booking = Booking::create([
            'car_id' => $step1['car_id'],
            'user_id' => Auth::id(),
            'pickup_datetime' => $step1['pickup_datetime'],
            'dropoff_datetime' => $step1['dropoff_datetime'],
            'pickup_location' => $step1['pickup_location'],
            'status' => 'pending',
            'total_price' => $total_price,
            'notes' => 'KYC file: ' . $filePath,
        ]);

        // Clear session data
        session()->forget(['booking.step1', 'booking.step2', 'booking.total_price']);

        return redirect()->route('bookings.step1')->with('success', 'Booking submitted successfully!');
    }

    /**
     * Generate payment URL for a booking
     * Creates an invoice if one doesn't exist and returns the payment URL
     */
    public function generatePaymentUrl($id)
    {
        try {
            $booking = Booking::with(['user', 'invoice'])->findOrFail($id);

            // Check if booking already has an invoice
            if ($booking->invoice_id && $booking->invoice) {
                $paymentUrl = route('frontend.payment.show', $booking->invoice->invoice_number);
                
                return response()->json([
                    'success' => true,
                    'payment_url' => $paymentUrl,
                    'invoice_number' => $booking->invoice->invoice_number,
                    'message' => 'Payment URL generated successfully',
                ]);
            }

            // Create invoice from booking
            DB::beginTransaction();

            // Get the fleet (car_id in bookings actually refers to fleet_id)
            $fleet = Fleet::findOrFail($booking->car_id);
            
            // Calculate days
            $pickup = Carbon::parse($booking->pickup_datetime);
            $dropoff = Carbon::parse($booking->dropoff_datetime);
            $days = max(1, $pickup->diffInDays($dropoff));

            // Generate invoice number
            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $booking->user_id,
                'full_name' => $booking->user->name ?? null,
                'email' => $booking->user->email ?? null,
                'mpesa_number' => $booking->user->phone ?? null,
                'pickup_date' => $pickup->format('Y-m-d'),
                'dropoff_date' => $dropoff->format('Y-m-d'),
                'days' => $days,
                'price_per_day' => $fleet->price_per_day ?? $booking->total_price / $days,
                'total_price' => $booking->total_price ?? ($fleet->price_per_day * $days),
                'status' => 'pending',
            ]);

            // Attach fleet to invoice
            if ($fleet) {
                $invoice->fleets()->attach($fleet->id, [
                    'price_per_day' => $fleet->price_per_day ?? 0,
                    'quantity' => 1,
                ]);
            }

            // Update booking with invoice_id
            $booking->update(['invoice_id' => $invoice->id]);

            DB::commit();

            $paymentUrl = route('frontend.payment.show', $invoice->invoice_number);

            return response()->json([
                'success' => true,
                'payment_url' => $paymentUrl,
                'invoice_number' => $invoice->invoice_number,
                'message' => 'Invoice created and payment URL generated successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error generating payment URL for booking', [
                'booking_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate payment URL: ' . $e->getMessage(),
            ], 500);
        }
    }
}
