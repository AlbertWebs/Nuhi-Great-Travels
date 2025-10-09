<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Fleet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function create()
    {
        $fleets = \App\Models\Fleet::all();
        $users  = \App\Models\User::where('role','client')->get();
        return view('admin.billing.create-invoice', compact('fleets','users'));
    }

    public function index(){
        $invoices = Invoice::with(['user', 'fleet'])->latest()->paginate(10);
        return view('admin.billing.index', compact('invoices'));
    }

    public function store(Request $request)
    {
        try {
            // Validate inputs
            $request->validate([
                'fleet_id' => 'required|exists:fleets,id',
                'pickup_date' => 'required|date',
                'dropoff_date' => 'required|date|after_or_equal:pickup_date',
                'userType' => 'required|string',
                'user_id' => 'nullable|exists:users,id',
                'full_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'mpesa_number' => 'nullable|string|max:20',
            ]);

            // Calculate days
            $pickup = Carbon::parse($request->pickup_date);
            $dropoff = Carbon::parse($request->dropoff_date);
            $days = max(1, $pickup->diffInDays($dropoff));

            // Get fleet rate
            $fleet = Fleet::findOrFail($request->fleet_id);
            $totalPrice = round($days * $fleet->price_per_day, -2); // nearest 100

            // Create invoice
            $invoice = Invoice::create([
                'fleet_id' => $fleet->id,
                'user_id' => $request->userType === 'existing' ? $request->user_id : null,
                'full_name' => $request->userType === 'new' ? $request->full_name : null,
                'email' => $request->userType === 'new' ? $request->email : null,
                'mpesa_number' => $request->userType === 'new' ? $request->mpesa_number : null,
                'pickup_date' => $pickup,
                'dropoff_date' => $dropoff,
                'days' => round($days),
                'total_price' => $totalPrice,
            ]);

            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice created successfully.');
        } catch (\Throwable $e) {
            // Log error details
            Log::error('Invoice creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to create invoice. Please check the logs.');
        }
    }

    public function show($id)
{
    $invoice = Invoice::with(['fleet', 'user'])->findOrFail($id);
    return view('admin.billing.show', compact('invoice'));
}

    public function edit($id)
{
    $invoice = Invoice::findOrFail($id);
    $fleets = Fleet::all();
    $users = User::all();

    return view('admin.billing.edit', compact('invoice', 'fleets', 'users'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'fleet_id' => 'required|exists:fleets,id',
        'pickup_date' => 'required|date',
        'dropoff_date' => 'required|date|after_or_equal:pickup_date',
        'total_price' => 'required|numeric',
    ]);

    $invoice = Invoice::findOrFail($id);
    $invoice->update($request->all());

    return redirect()->route('admin.invoices.index')
        ->with('success', 'Invoice updated successfully.');
}

public function sendSms($id)
{
    $invoice = Invoice::with('user')->findOrFail($id);

    $clientName = $invoice->full_name ?? optional($invoice->user)->name ?? 'Customer';
    $recipient = $invoice->mpesa_number
               ?? optional($invoice->user)->phone
               ?? optional($invoice->user)->mobile
               ?? null;

    if (! $recipient) {
        return redirect()->back()->with('error', 'No phone number found for this invoice.');
    }

    $pickup = \Carbon\Carbon::parse($invoice->pickup_date)->format('d M Y');
    $dropoff = \Carbon\Carbon::parse($invoice->dropoff_date)->format('d M Y');

    $message = "Hello {$clientName}, your invoice for Ksh "
             . number_format($invoice->total_price, 0)
             . " is ready. Booking dates: {$pickup} to {$dropoff}.";

    try {
        // Simulate sending SMS (replace with real API)
        \Log::info("SMS to {$recipient}: {$message}");
        //SendSMSHere

        // Update the invoice status
        $invoice->update(['is_sent' => true]);

        return redirect()->back()->with('success', 'Invoice sent via SMS successfully.');
    } catch (\Throwable $e) {
        \Log::error('SMS sending failed', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Failed to send invoice SMS.');
    }
}

}
