<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Fleet;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Setting;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function create()
    {
        $fleets = \App\Models\Fleet::all();
        $users  = \App\Models\User::where('role','client')->get();
        return view('admin.billing.create-invoice', compact('fleets','users'));
    }

    public function index(){
        $invoices = Invoice::with(['user', 'fleets'])->latest()->paginate(10);
        return view('admin.billing.index', compact('invoices'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'fleets' => 'required|array',
                'fleets.*' => 'nullable|integer|min:0',
                'pickup_date' => 'required|date',
                'dropoff_date' => 'required|date|after_or_equal:pickup_date',
                'userType' => 'required|string',
                'user_id' => 'nullable|exists:users,id',
                'full_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'mpesa_number' => 'nullable|string|max:20',
                'days' => 'required|integer|min:1',
                'total_price' => 'nullable|numeric|min:0',
            ]);

            $fleetSelections = collect($request->fleets ?? [])
                ->map(fn ($qty) => (int) $qty)
                ->filter(fn ($qty) => $qty > 0);

            if ($fleetSelections->isEmpty()) {
                return back()
                    ->withErrors(['fleets' => 'Select at least one vehicle.'])
                    ->withInput();
            }

            $fleets = Fleet::whereIn('id', $fleetSelections->keys())->get();
            $days = max(1, (int) ($request->days ?? 1));

            $totalRate = $fleets->sum(function (Fleet $fleet) use ($fleetSelections) {
                return $fleet->price_per_day * $fleetSelections->get($fleet->id, 1);
            });
            $totalPrice = round($totalRate * $days, 2);
            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $request->userType === 'existing' ? $request->user_id : null,
                'full_name' => $request->userType === 'new' ? $request->full_name : null,
                'email' => $request->userType === 'new' ? $request->email : null,
                'mpesa_number' => $request->userType === 'new' ? $request->mpesa_number : null,
                'pickup_date' => $request->pickup_date,
                'dropoff_date' => $request->dropoff_date,
                'days' => $days,
                'price_per_day' => $totalRate,
                'total_price' => $totalPrice,
            ]);

            $invoice->fleets()->attach(
                $fleets->mapWithKeys(function (Fleet $fleet) use ($fleetSelections) {
                    return [
                        $fleet->id => [
                            'price_per_day' => $fleet->price_per_day,
                            'quantity' => $fleetSelections->get($fleet->id, 1),
                        ],
                    ];
                })
            );



            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice created successfully with number: ' . $invoice->invoice_number);
        } catch (\Throwable $e) {
            Log::error('Invoice creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Failed to create invoice. Please check the logs.');
        }
    }






    public function show($id)
    {
        $Settings = Setting::first(); // fetch first row
        $invoice = Invoice::with(['fleets', 'user'])->findOrFail($id);
        return view('admin.billing.show', compact('invoice','Settings'));
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
