<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\Fleet;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EstimateController extends Controller
{
    public function index()
    {
        $estimates = Estimate::with(['user', 'fleets', 'convertedInvoice'])
            ->latest()
            ->paginate(10);

        return view('admin.billing.estimates.index', compact('estimates'));
    }

    public function create()
    {
        $fleets = Fleet::all();
        $users  = User::where('role', 'client')->get();

        return view('admin.billing.estimates.create', compact('fleets', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fleets' => 'required|array',
            'fleets.*' => 'nullable|integer|min:0',
            'pickup_date' => 'required|date',
            'dropoff_date' => 'required|date|after_or_equal:pickup_date',
            'userType' => 'required|string|in:existing,new',
            'user_id' => 'nullable|exists:users,id',
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mpesa_number' => 'nullable|string|max:20',
            'days' => 'required|integer|min:1',
            'total_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
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

            $estimate = Estimate::create([
                'estimate_number' => 'EST-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
                'user_id' => $request->userType === 'existing' ? $request->user_id : null,
                'full_name' => $request->userType === 'new' ? $request->full_name : null,
                'email' => $request->userType === 'new' ? $request->email : null,
                'mpesa_number' => $request->userType === 'new' ? $request->mpesa_number : null,
                'pickup_date' => $request->pickup_date,
                'dropoff_date' => $request->dropoff_date,
                'days' => $days,
                'price_per_day' => $totalRate,
                'total_price' => $totalPrice,
                'notes' => $request->notes,
            ]);

            $estimate->fleets()->attach(
                $fleets->mapWithKeys(function (Fleet $fleet) use ($fleetSelections) {
                    return [
                        $fleet->id => [
                            'price_per_day' => $fleet->price_per_day,
                            'quantity' => $fleetSelections->get($fleet->id, 1),
                        ],
                    ];
                })
            );

            return redirect()
                ->route('admin.estimates.show', $estimate->id)
                ->with('success', 'Estimate created successfully.');
        } catch (\Throwable $th) {
            Log::error('Estimate creation failed', [
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Unable to create estimate at the moment.');
        }
    }

    public function show(Estimate $estimate)
    {
        $estimate->load(['user', 'fleets', 'convertedInvoice']);
        $settings = Setting::first();

        return view('admin.billing.estimates.show', compact('estimate', 'settings'));
    }

    public function convert(Estimate $estimate)
    {
        if ($estimate->converted_at) {
            return redirect()
                ->route('admin.estimates.show', $estimate->id)
                ->with('info', 'This estimate has already been converted to an invoice.');
        }

        $estimate->load('fleets');

        try {
            DB::beginTransaction();

            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => $estimate->user_id,
                'full_name' => $estimate->full_name,
                'email' => $estimate->email,
                'mpesa_number' => $estimate->mpesa_number,
                'pickup_date' => $estimate->pickup_date,
                'dropoff_date' => $estimate->dropoff_date,
                'days' => $estimate->days,
                'price_per_day' => $estimate->price_per_day,
                'total_price' => $estimate->total_price,
            ]);

            $invoice->fleets()->attach(
                $estimate->fleets->mapWithKeys(function ($fleet) {
                    return [
                        $fleet->id => [
                            'price_per_day' => $fleet->pivot->price_per_day,
                            'quantity' => $fleet->pivot->quantity,
                        ],
                    ];
                })
            );

            $estimate->update([
                'status' => 'converted',
                'converted_at' => now(),
                'converted_invoice_id' => $invoice->id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.invoices.show', $invoice->id)
                ->with('success', 'Estimate converted to invoice successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Estimate conversion failed', ['error' => $th->getMessage()]);

            return redirect()
                ->route('admin.estimates.show', $estimate->id)
                ->with('error', 'Failed to convert estimate. Please try again.');
        }
    }

}

