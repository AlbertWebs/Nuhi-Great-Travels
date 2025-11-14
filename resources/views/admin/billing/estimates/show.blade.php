@extends('layouts.admin')

@section('page-title', 'Estimate Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow relative print:p-0 print:shadow-none print:max-w-full">
    <div class="flex justify-between items-start border-b pb-6 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">ESTIMATE</h1>
            <p class="text-gray-500">{{ $estimate->estimate_number }}</p>
            <p class="text-gray-500">Date: {{ $estimate->created_at->format('F j, Y') }}</p>
        </div>

        <div class="text-right">
            @if($settings && $settings->logo)
                <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="h-12 w-auto mx-auto mb-2">
            @endif
            <h2 class="text-xl font-semibold text-gold">{{ $settings->company_name ?? 'Nuhi Great Travels' }}</h2>
            <p class="text-sm text-gray-500">{{ $settings->location ?? 'P.O. Box 12345 - Nairobi, Kenya' }}</p>
            <p class="text-sm text-gray-500">Email: {{ $settings->email ?? 'info@nuhigreattravels.com' }}</p>
            <p class="text-sm text-gray-500">Phone: {{ $settings->mobile ?? '+254 700 123 456' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Prepared For:</h3>
            @if ($estimate->user)
                <p class="font-medium text-gray-800">{{ $estimate->user->name }}</p>
                <p class="text-gray-600 text-sm">{{ $estimate->user->email }}</p>
            @else
                <p class="font-medium text-gray-800">{{ $estimate->full_name ?? 'N/A' }}</p>
                <p class="text-gray-600 text-sm">{{ $estimate->email ?? 'N/A' }}</p>
                @if($estimate->mpesa_number)
                    <p class="text-gray-600 text-sm">{{ $estimate->mpesa_number }}</p>
                @endif
            @endif
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Trip Summary:</h3>
            <p><strong>Status:</strong>
                <span class="font-semibold {{ $estimate->status === 'converted' ? 'text-green-600' : 'text-gray-600' }}">
                    {{ ucfirst($estimate->status) }}
                </span>
            </p>
            <p><strong>Pickup Date:</strong> {{ optional($estimate->pickup_date)->format('M d, Y') }}</p>
            <p><strong>Dropoff Date:</strong> {{ optional($estimate->dropoff_date)->format('M d, Y') }}</p>
            <p><strong>Days:</strong> {{ $estimate->days }}</p>
        </div>
    </div>

    <table class="w-full border border-gray-200 text-left mb-8">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="p-3 border-b">#</th>
                <th class="p-3 border-b">Vehicle</th>
                <th class="p-3 border-b text-right">Rate (Ksh)</th>
                <th class="p-3 border-b text-right">Qty</th>
                <th class="p-3 border-b text-right">Days</th>
                <th class="p-3 border-b text-right">Total (Ksh)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($estimate->fleets as $index => $fleet)
                @php
                    $lineDaily = $fleet->pivot->price_per_day * $fleet->pivot->quantity;
                    $vehicleTotal = $lineDaily * $estimate->days;
                    $grandTotal += $vehicleTotal;
                @endphp
                <tr>
                    <td class="p-3 border-b">{{ $index + 1 }}</td>
                    <td class="p-3 border-b">{{ $fleet->name }}</td>
                    <td class="p-3 border-b text-right">{{ number_format($fleet->pivot->price_per_day, 2) }}</td>
                    <td class="p-3 border-b text-right">{{ $fleet->pivot->quantity }}</td>
                    <td class="p-3 border-b text-right">{{ $estimate->days }}</td>
                    <td class="p-3 border-b text-right font-semibold">{{ number_format($vehicleTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="flex justify-end mb-8">
        <div class="w-1/2 md:w-1/3">
            <div class="flex justify-between border-t py-2 font-semibold">
                <span>Total:</span>
                <span>Ksh {{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>
    </div>

    @if ($estimate->notes)
        <div class="border border-blue-100 bg-blue-50 rounded-lg p-4 mb-8">
            <h3 class="font-semibold text-blue-800 mb-2">Notes</h3>
            <p class="text-blue-900 text-sm">{{ $estimate->notes }}</p>
        </div>
    @endif

    <div class="flex flex-wrap gap-3 items-center justify-between print:hidden">
        <div class="flex gap-3">
            <button
                onclick="window.print()"
                class="px-6 py-2 bg-gold text-white font-semibold rounded hover:bg-yellow-600">
                <i class="fas fa-print mr-2"></i> Print Estimate
            </button>

            @if ($estimate->status !== 'converted')
                <form action="{{ route('admin.estimates.convert', $estimate->id) }}" method="POST"
                      onsubmit="return confirm('Convert this estimate to an invoice?');">
                    @csrf
                    <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700">
                        <i class="fas fa-file-invoice mr-2"></i> Convert to Invoice
                    </button>
                </form>
            @else
                <a href="{{ route('admin.invoices.show', $estimate->converted_invoice_id) }}"
                   class="px-6 py-2 bg-green-50 text-green-700 font-semibold rounded border border-green-200">
                    <i class="fas fa-file-invoice mr-2"></i> View Invoice
                </a>
            @endif
        </div>
        <p class="text-sm text-gray-500">Tip: Use the browser print dialog to save as PDF.</p>
    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
            margin: 0;
        }
        body * {
            visibility: hidden;
        }
        .max-w-4xl, .max-w-4xl * {
            visibility: visible;
        }
        .max-w-4xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
            border: none;
        }
        .print\:hidden {
            display: none !important;
        }
    }
</style>
@endsection

