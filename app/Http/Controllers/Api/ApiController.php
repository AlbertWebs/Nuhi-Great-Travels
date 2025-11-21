<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Fleet;
use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;

class ApiController extends Controller
{
    /**
     * Get all car categories
     */
    public function getCars()
    {
        $cars = Car::all();
        return response()->json([
            'success' => true,
            'data' => $cars
        ]);
    }

    /**
     * Get all fleets (vehicles)
     */
    public function getFleets(Request $request)
    {
        $query = Fleet::with(['car', 'images'])
            ->where('status', 'available');

        // Filter by car category if provided
        if ($request->has('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        // Search by name
        if ($request->has('search') && !empty($request->search) && trim($request->search) !== '') {
            $query->where('name', 'like', '%' . trim($request->search) . '%');
        }

        $fleets = $query->get()->map(function ($fleet) {
            return [
                'id' => $fleet->id,
                'name' => $fleet->name,
                'type' => $fleet->type,
                'transmission' => $fleet->transmission,
                'fuel_type' => $fleet->fuel_type,
                'seats' => $fleet->seats,
                'year' => $fleet->year,
                'price_per_day' => $fleet->price_per_day,
                'description' => $fleet->description,
                'image' => $fleet->image ? asset('storage/' . $fleet->image) : null,
                'images' => $fleet->images->map(function ($img) {
                    return asset('storage/' . $img->image_path);
                }),
                'car' => $fleet->car ? [
                    'id' => $fleet->car->id,
                    'make' => $fleet->car->make,
                ] : null,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $fleets
        ]);
    }

    /**
     * Get single fleet by ID
     */
    public function getFleet($id)
    {
        $fleet = Fleet::with(['car', 'images'])->find($id);

        if (!$fleet) {
            return response()->json([
                'success' => false,
                'message' => 'Fleet not found'
            ], 404);
        }

        $data = [
            'id' => $fleet->id,
            'name' => $fleet->name,
            'type' => $fleet->type,
            'transmission' => $fleet->transmission,
            'fuel_type' => $fleet->fuel_type,
            'seats' => $fleet->seats,
            'year' => $fleet->year,
            'price_per_day' => $fleet->price_per_day,
            'description' => $fleet->description,
            'content' => $fleet->content,
            'image' => $fleet->image ? asset('storage/' . $fleet->image) : null,
            'images' => $fleet->images->map(function ($img) {
                return asset('storage/' . $img->image_path);
            }),
            'car' => $fleet->car ? [
                'id' => $fleet->car->id,
                'make' => $fleet->car->make,
            ] : null,
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Calculate booking price
     */
    public function calculatePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fleet_id' => 'required|exists:fleets,id',
            'pickup_datetime' => 'required|date',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $fleet = Fleet::findOrFail($request->fleet_id);
        $pickup = Carbon::parse($request->pickup_datetime);
        $dropoff = Carbon::parse($request->dropoff_datetime);
        
        // Calculate days using hours for more accuracy, then round to nearest whole number
        $hours = $pickup->diffInHours($dropoff);
        $days = max(1, round($hours / 24));
        $totalPrice = round($days * $fleet->price_per_day, 2);

        return response()->json([
            'success' => true,
            'data' => [
                'days' => $days,
                'price_per_day' => $fleet->price_per_day,
                'total_price' => $totalPrice,
            ]
        ]);
    }

    /**
     * Create a new booking
     */
    public function createBooking(Request $request)
    {
        // Support both fleet_id (single) and fleet_ids (array) for backward compatibility
        $fleetIds = $request->has('fleet_ids') && is_array($request->fleet_ids) 
            ? $request->fleet_ids 
            : ($request->has('fleet_id') ? [$request->fleet_id] : []);

        $validator = Validator::make($request->all(), [
            'fleet_id' => 'sometimes|exists:fleets,id',
            'fleet_ids' => 'sometimes|array',
            'fleet_ids.*' => 'exists:fleets,id',
            'pickup_datetime' => 'required|date|after:now',
            'dropoff_datetime' => 'required|date|after:pickup_datetime',
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
            'notes' => 'nullable|string',
            'payment_preference' => 'nullable|in:pay_now,pay_later',
        ]);

        // Ensure at least one fleet is provided
        if (empty($fleetIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => ['fleet_id' => ['At least one fleet is required'], 'fleet_ids' => ['At least one fleet is required']]
            ], 422);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $pickup = Carbon::parse($request->pickup_datetime);
        $dropoff = Carbon::parse($request->dropoff_datetime);
        
        // Calculate days using hours for more accuracy, then round to nearest whole number
        $hours = $pickup->diffInHours($dropoff);
        $days = max(1, round($hours / 24));
        
        // Calculate total price for all fleets
        $fleets = Fleet::whereIn('id', $fleetIds)->get();
        $totalPrice = 0;
        foreach ($fleets as $fleet) {
            $totalPrice += round($days * $fleet->price_per_day, 2);
        }
        
        // Use first fleet's car_id for backward compatibility
        $firstFleet = $fleets->first();

        // Create or get user
        $user = \App\Models\User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->full_name,
                'phone' => $request->mobile,
                'password' => bcrypt(\Illuminate\Support\Str::random(10)),
            ]
        );

        $paymentPreference = $request->payment_preference ?? 'pay_later';
        
        // Create booking
        $booking = Booking::create([
            'car_id' => $firstFleet->car_id,
            'user_id' => $user->id,
            'pickup_datetime' => $pickup,
            'dropoff_datetime' => $dropoff,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location ?? $request->pickup_location,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'notes' => $request->notes,
            'payment_preference' => $paymentPreference,
        ]);

        // Attach fleets to booking
        foreach ($fleets as $fleet) {
            $booking->fleets()->attach($fleet->id, [
                'price_per_day' => $fleet->price_per_day,
                'quantity' => 1,
            ]);
        }

        $responseData = [
            'id' => $booking->id,
            'fleet_name' => $fleets->count() > 1 ? $fleets->count() . ' vehicles' : $firstFleet->name,
            'pickup_datetime' => $booking->pickup_datetime,
            'dropoff_datetime' => $booking->dropoff_datetime,
            'total_price' => $booking->total_price,
            'status' => $booking->status,
            'payment_preference' => $booking->payment_preference,
        ];

        // If pay now, create invoice and initiate payment
        if ($paymentPreference === 'pay_now') {
            $invoice = \App\Models\Invoice::create([
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
                'fleet_id' => $firstFleet->id, // Keep for backward compatibility
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'mpesa_number' => $request->mobile,
                'pickup_date' => $pickup->format('Y-m-d'),
                'dropoff_date' => $dropoff->format('Y-m-d'),
                'days' => $days,
                'price_per_day' => $firstFleet->price_per_day, // Average or first fleet
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Attach all fleets to invoice via pivot table
            foreach ($fleets as $fleet) {
                $invoice->fleets()->attach($fleet->id, [
                    'price_per_day' => $fleet->price_per_day,
                    'quantity' => 1,
                ]);
            }

            $booking->update(['invoice_id' => $invoice->id]);

            // Initiate Pesapal payment
            try {
                $pesapalService = new \App\Services\PesapalService();
                $fleetNames = $fleets->pluck('name')->implode(', ');
                $paymentData = [
                    'amount' => $totalPrice,
                    'description' => 'Payment for ' . ($fleets->count() > 1 ? $fleets->count() . ' vehicles' : $firstFleet->name) . ' booking',
                    'reference' => $invoice->invoice_number,
                    'first_name' => $request->full_name,
                    'email' => $request->email,
                    'phone_number' => $request->mobile,
                    'line_1' => $request->pickup_location,
                    'city' => 'Nairobi',
                ];

                $paymentUrl = $pesapalService->makePayment($paymentData);
                
                if ($paymentUrl) {
                    $responseData['payment_url'] = $paymentUrl;
                    $responseData['invoice_id'] = $invoice->id;
                    $responseData['invoice_number'] = $invoice->invoice_number;
                } else {
                    // Log when payment URL generation fails
                    \Illuminate\Support\Facades\Log::error('Payment URL generation failed - Pesapal returned null', [
                        'error_type' => 'payment_url_generation_failed',
                        'message' => 'Payment URL is not available. Please contact support or try booking again.',
                        'booking_id' => $booking->id,
                        'invoice_id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'payment_data' => $paymentData,
                        'total_price' => $totalPrice,
                        'fleet_ids' => $fleetIds,
                        'user_email' => $request->email,
                        'user_name' => $request->full_name,
                        'timestamp' => now()->toISOString(),
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Pesapal payment initiation failed - Exception', [
                    'error_type' => 'payment_url_generation_exception',
                    'message' => 'Payment URL is not available. Please contact support or try booking again.',
                    'error' => $e->getMessage(),
                    'error_trace' => $e->getTraceAsString(),
                    'booking_id' => $booking->id,
                    'invoice_id' => $invoice->id ?? null,
                    'invoice_number' => $invoice->invoice_number ?? null,
                    'payment_data' => $paymentData ?? null,
                    'total_price' => $totalPrice,
                    'fleet_ids' => $fleetIds,
                    'user_email' => $request->email,
                    'user_name' => $request->full_name,
                    'timestamp' => now()->toISOString(),
                ]);
            }
        }

        // Send booking confirmation emails
        try {
            $booking->load('user', 'fleets.car');
            
            // Email to client
            Mail::to($user->email)->send(new BookingConfirmation($booking, $booking->fleets, false));
            
            // Email to admin
            Mail::to('bookings@nuhigreattravels.com')
                ->cc('albertmuhatia@gmail.com')
                ->send(new BookingConfirmation($booking, $booking->fleets, true));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send booking confirmation emails', [
                'error' => $e->getMessage(),
                'booking_id' => $booking->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $responseData
        ], 201);
    }

    /**
     * Get booking by ID
     */
    public function getBooking($id)
    {
        $booking = Booking::with(['car', 'user'])->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $booking->id,
                'pickup_datetime' => $booking->pickup_datetime,
                'dropoff_datetime' => $booking->dropoff_datetime,
                'pickup_location' => $booking->pickup_location,
                'dropoff_location' => $booking->dropoff_location,
                'total_price' => $booking->total_price,
                'status' => $booking->status,
                'notes' => $booking->notes,
            ]
        ]);
    }

    /**
     * Get settings
     */
    public function getSettings()
    {
        $settings = Setting::first();
        
        if (!$settings) {
            return response()->json([
                'success' => true,
                'data' => [
                    'logo' => null,
                    'name' => 'Nuhi Great Travels',
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'logo' => $settings->logo ? asset('storage/' . $settings->logo) : null,
                'name' => 'Nuhi Great Travels',
                'email' => $settings->email ?? null,
                'mobile' => $settings->mobile ?? null,
                'location' => $settings->location ?? null,
            ]
        ]);
    }

    /**
     * Register Pesapal IPN URL
     */
    public function registerIpn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ipn_url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pesapalService = new \App\Services\PesapalService();
            $ipnId = $pesapalService->registerIpn($request->ipn_url);

            if ($ipnId) {
                return response()->json([
                    'success' => true,
                    'message' => 'IPN registered successfully',
                    'data' => [
                        'ipn_id' => $ipnId,
                        'ipn_url' => $request->ipn_url,
                        'note' => 'Add this IPN ID to your .env file: PESAPAL_IPN_ID=' . $ipnId
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Failed to register IPN. Check logs for details.'
            ], 500);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('IPN Registration Error', [
                'error' => $e->getMessage(),
                'ipn_url' => $request->ipn_url,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error registering IPN: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Log errors from frontend
     */
    public function logError(Request $request)
    {
        try {
            $errorData = [
                'error_type' => $request->input('error_type', 'unknown'),
                'message' => $request->input('message', 'No message provided'),
                'booking_id' => $request->input('booking_id'),
                'error_details' => $request->input('error_details', []),
                'context' => $request->input('context', []),
                'user_agent' => $request->input('user_agent'),
                'url' => $request->input('url'),
                'timestamp' => $request->input('timestamp', now()->toISOString()),
                'ip_address' => $request->ip(),
            ];

            // Log to Laravel log file
            \Illuminate\Support\Facades\Log::error('Payment URL Error', $errorData);

            // Optionally, you can also store in database if needed
            // For now, we'll just log to file

            return response()->json([
                'success' => true,
                'message' => 'Error logged successfully'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to log error', [
                'exception' => $e->getMessage(),
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to log error'
            ], 500);
        }
    }
}

