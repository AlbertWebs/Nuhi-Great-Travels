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
        $validator = Validator::make($request->all(), [
            'fleet_id' => 'required|exists:fleets,id',
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
        // Note: payment_preference column will be added after running migration
        // Migration: 2025_11_20_130246_add_payment_preference_to_bookings_table
        $booking = Booking::create([
            'car_id' => $fleet->car_id,
            'user_id' => $user->id,
            'pickup_datetime' => $pickup,
            'dropoff_datetime' => $dropoff,
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location ?? $request->pickup_location,
            'status' => 'pending',
            'total_price' => $totalPrice,
            'notes' => $request->notes,
            // 'payment_preference' => $paymentPreference, // Uncomment after running migration
        ]);

        $responseData = [
            'id' => $booking->id,
            'fleet_name' => $fleet->name,
            'pickup_datetime' => $booking->pickup_datetime,
            'dropoff_datetime' => $booking->dropoff_datetime,
            'total_price' => $booking->total_price,
            'status' => $booking->status,
            // 'payment_preference' => $booking->payment_preference, // Uncomment after running migration
        ];

        // If pay now, create invoice and initiate payment
        if ($paymentPreference === 'pay_now') {
            $invoice = \App\Models\Invoice::create([
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5)),
                'fleet_id' => $fleet->id,
                'user_id' => $user->id,
                'full_name' => $request->full_name,
                'email' => $request->email,
                'mpesa_number' => $request->mobile,
                'pickup_date' => $pickup->format('Y-m-d'),
                'dropoff_date' => $dropoff->format('Y-m-d'),
                'days' => $days,
                'price_per_day' => $fleet->price_per_day,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // Attach fleet to invoice via pivot table
            $invoice->fleets()->attach($fleet->id, [
                'price_per_day' => $fleet->price_per_day,
                'quantity' => 1,
            ]);

            $booking->update(['invoice_id' => $invoice->id]);

            // Initiate Pesapal payment
            try {
                $pesapalService = new \App\Services\PesapalService();
                $paymentData = [
                    'amount' => $totalPrice,
                    'description' => 'Payment for ' . $fleet->name . ' booking',
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
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Pesapal payment initiation failed', [
                    'error' => $e->getMessage(),
                    'booking_id' => $booking->id,
                ]);
            }
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
}

