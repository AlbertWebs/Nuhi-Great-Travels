@extends('layouts.admin')

@section('page-title', 'Invoice Details')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
        <i class="fas fa-file-invoice text-gold"></i> Invoice #{{ $invoice->id }}
    </h2>

    <p><strong>Client:</strong> {{ $invoice->full_name ?? $invoice->user->name ?? 'N/A' }}</p>
    <p><strong>Email:</strong> {{ $invoice->email ?? $invoice->user->email ?? 'N/A' }}</p>
    <p><strong>Vehicle:</strong> {{ $invoice->fleet->name }}</p>
    <p><strong>Price per Day:</strong> {{ number_format($invoice->price_per_day, 2) }}</p>
    <p><strong>Total:</strong> {{ number_format($invoice->total_price, 2) }}</p>
    <p><strong>Period:</strong> {{ $invoice->pickup_date }} → {{ $invoice->dropoff_date }}</p>
</div>
@endsection
