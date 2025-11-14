@extends('layouts.admin')

@section('page-title', 'Invoice Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow relative print:p-0 print:shadow-none print:max-w-full">

    <!-- Header -->
    <div class="flex justify-between items-start border-b pb-6 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">INVOICE</h1>
            <p class="text-gray-500">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p class="text-gray-500">Date: {{ $invoice->created_at->format('F j, Y') }}</p>
        </div>

        <div class="text-right">
            <img src="{{ asset('storage/' . $Settings->logo) }}" alt="Logo" class="h-12 w-auto mx-auto mb-2">
            <h2 class="text-xl font-semibold text-gold">{{ $Settings->company_name ?? 'Nuhi Great Travels' }}</h2>
            <p class="text-sm text-gray-500">{{ $Settings->location ?? 'P.O. Box 12345 - Nairobi, Kenya' }}</p>
            <p class="text-sm text-gray-500">Email: {{ $Settings->email ?? 'info@nuhigreattravels.com' }}</p>
            <p class="text-sm text-gray-500">Phone: {{ $Settings->mobile ?? '+254 700 123 456' }}</p>
        </div>
    </div>

    <!-- Billing Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Billed To:</h3>
            <p class="font-medium text-gray-800">
                {{ $invoice->full_name ?? $invoice->user->name ?? 'N/A' }}
            </p>
            <p class="text-gray-600 text-sm">
                {{ $invoice->email ?? $invoice->user->email ?? 'N/A' }}
            </p>
            @if($invoice->mpesa_number)
                <p class="text-gray-600 text-sm">
                    M-Pesa: {{ $invoice->mpesa_number }}
                </p>
            @endif
        </div>

        <div>
            <h3 class="font-semibold text-gray-700 mb-2">Invoice Summary:</h3>
            <p><strong>Status:</strong>
                <span class="@if($invoice->status === 'paid') text-green-600
                            @elseif($invoice->status === 'pending') text-yellow-600
                            @else text-red-600 @endif font-semibold">
                    {{ ucfirst($invoice->status) }}
                </span>
            </p>
            <p><strong>Pickup Date:</strong> {{ \Carbon\Carbon::parse($invoice->pickup_date)->format('M d, Y') }}</p>
            <p><strong>Dropoff Date:</strong> {{ \Carbon\Carbon::parse($invoice->dropoff_date)->format('M d, Y') }}</p>
            <p><strong>Days:</strong> {{ $invoice->days }}</p>
        </div>
    </div>

    <!-- Invoice Table -->
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
            @foreach($invoice->fleets as $index => $fleet)
                @php
                    $lineDaily = $fleet->pivot->price_per_day * $fleet->pivot->quantity;
                    $vehicleTotal = $lineDaily * $invoice->days;
                    $grandTotal += $vehicleTotal;
                @endphp
                <tr>
                    <td class="p-3 border-b">{{ $index + 1 }}</td>
                    <td class="p-3 border-b">
                        {{ $fleet->name }}
                        <div class="text-sm text-gray-500">{{ $fleet->registration_number ?? '' }}</div>
                    </td>
                    <td class="p-3 border-b text-right">{{ number_format($fleet->pivot->price_per_day, 2) }}</td>
                    <td class="p-3 border-b text-right">{{ $fleet->pivot->quantity }}</td>
                    <td class="p-3 border-b text-right">{{ $invoice->days }}</td>
                    <td class="p-3 border-b text-right font-semibold">{{ number_format($vehicleTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Totals -->
    <div class="flex justify-end">
        <div class="w-1/2 md:w-1/3">
            <div class="flex justify-between border-t py-2 font-semibold">
                <span>Total:</span>
                <span>Ksh {{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Details -->
    <div class="mt-8 text-gray-700">
        <h3 class="font-semibold mb-2">Payment Details:</h3>
        <ul class="text-sm leading-6">
            <li><strong>Payment Method:</strong> {{ ucfirst($invoice->payment_method ?? 'M-Pesa / Bank Transfer') }}</li>

            @if($invoice->payment_method === 'mpesa' || !$invoice->payment_method)
                <li><strong>M-Pesa Paybill:</strong> 123456</li>
                <li><strong>Account Number:</strong> {{ 'INV' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</li>
            @endif

            @if($invoice->payment_method === 'bank')
                <li><strong>Bank Name:</strong> Equity Bank</li>
                <li><strong>Account Name:</strong> Nuhi Great Travels</li>
                <li><strong>Account Number:</strong> 0123456789012</li>
                <li><strong>Branch:</strong> Nairobi West</li>
            @endif

            @if($invoice->payment_reference)
                <li><strong>Payment Reference:</strong> {{ $invoice->payment_reference }}</li>
            @endif

            @if($invoice->payment_date)
                <li><strong>Payment Date:</strong> {{ \Carbon\Carbon::parse($invoice->payment_date)->format('F j, Y') }}</li>
            @endif
        </ul>
    </div>

    <!-- Notes -->
    <div class="mt-6 text-gray-600 text-sm">
        <p><strong>Payment Instructions:</strong></p>
        <p>Pay via M-Pesa Till No: <strong>123456</strong> (Nuhi Great Travels).</p>
        <p>Once payment is complete, kindly share the M-Pesa confirmation message or bank slip with our billing team.</p>
        <p class="mt-2 italic text-gray-500">Thank you for choosing Nuhi Great Travels. We appreciate your business!</p>
    </div>

    <!-- Print Button -->
    <div class="mt-8 text-right print:hidden">
        <button
            onclick="window.print()"
            class="px-6 py-2 bg-gold text-white font-semibold rounded hover:bg-yellow-600"
        >
            <i class="fas fa-print mr-2"></i> Print Invoice
        </button>
    </div>
</div>

<!-- Print Styles -->
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
        .print\\:hidden {
            display: none !important;
        }
    }
</style>
@endsection
