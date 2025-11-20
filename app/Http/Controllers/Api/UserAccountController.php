<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAccountController extends Controller
{
    /**
     * Get user's bookings
     */
    public function getBookings(Request $request)
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $bookings = Booking::where('user_id', $user->id)
            ->with(['car'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'pickup_datetime' => $booking->pickup_datetime,
                    'dropoff_datetime' => $booking->dropoff_datetime,
                    'pickup_location' => $booking->pickup_location,
                    'dropoff_location' => $booking->dropoff_location,
                    'status' => $booking->status,
                    'total_price' => $booking->total_price,
                    'notes' => $booking->notes,
                    'created_at' => $booking->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    /**
     * Get user's invoices
     */
    public function getInvoices(Request $request)
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $invoices = Invoice::where('user_id', $user->id)
            ->with(['fleet'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'pickup_date' => $invoice->pickup_date,
                    'dropoff_date' => $invoice->dropoff_date,
                    'days' => $invoice->days,
                    'total_price' => $invoice->total_price,
                    'status' => $invoice->status,
                    'fleet_name' => $invoice->fleet ? $invoice->fleet->name : null,
                    'created_at' => $invoice->created_at,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $invoices
        ]);
    }

    /**
     * Get user's payments
     */
    public function getPayments(Request $request)
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        // Get paid invoices as payments
        $payments = Invoice::where('user_id', $user->id)
            ->where('status', 'paid')
            ->with(['fleet'])
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->total_price,
                    'status' => $invoice->status,
                    'payment_date' => $invoice->updated_at,
                    'fleet_name' => $invoice->fleet ? $invoice->fleet->name : null,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $payments
        ]);
    }

    /**
     * Get user's loyalty points and summary
     */
    public function getLoyaltyPoints(Request $request)
    {
        $user = $request->user() ?? auth()->user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }
        
        $totalSpent = Invoice::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('total_price');
        
        $loyaltyPoints = floor($totalSpent / 10); // 1 point per $10
        $nextRewardAt = (($loyaltyPoints + 1) * 10) - $totalSpent;
        
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $completedBookings = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'loyalty_points' => $loyaltyPoints,
                'total_spent' => $totalSpent,
                'next_reward_at' => $nextRewardAt,
                'total_bookings' => $totalBookings,
                'completed_bookings' => $completedBookings,
            ]
        ]);
    }
}

