@extends('layouts.admin')

@section('page-title', 'Edit Invoice')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow-md mt-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2 text-gray-800">
            <i class="fas fa-file-invoice text-gold"></i>
            Edit Invoice
            <span class="text-gray-500 text-lg">#INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</span>
        </h2>
        <span class="text-sm text-gray-500">Created on: {{ $invoice->created_at->format('d M Y') }}</span>
    </div>

    <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Fleet Selection --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Select Vehicle / Fleet</label>
            <select name="fleet_id" class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold" required>
                @foreach ($fleets as $fleet)
                    <option value="{{ $fleet->id }}" {{ $invoice->fleet_id == $fleet->id ? 'selected' : '' }}>
                        {{ $fleet->name }} — Ksh {{ number_format($fleet->price_per_day, 2) }}/day
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Client Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Client Name</label>
                <input type="text" name="full_name" value="{{ old('full_name', $invoice->full_name ?? $invoice->user->name ?? '') }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', $invoice->email ?? $invoice->user->email ?? '') }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold">
            </div>
        </div>

        {{-- Dates --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pickup Date</label>
                <input type="date" name="pickup_date" value="{{ $invoice->pickup_date }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dropoff Date</label>
                <input type="date" name="dropoff_date" value="{{ $invoice->dropoff_date }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold" required>
            </div>
        </div>

        {{-- Financial Details --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Price Per Day</label>
                <input type="number" step="0.01" name="price_per_day" value="{{ $invoice->price_per_day }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Days</label>
                <input type="number" name="days" value="{{ $invoice->days }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Total Price (Ksh)</label>
                <input type="number" step="0.01" name="total_price" value="{{ $invoice->total_price }}"
                       class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold">
            </div>
        </div>

        {{-- Invoice Status --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
            <select name="status" class="w-full border-gray-300 rounded-md focus:ring-gold focus:border-gold">
                <option value="pending" {{ $invoice->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        {{-- Update Button --}}
        <div class="pt-4">
            <button type="submit"
                    class="px-6 py-3 bg-gold text-white font-semibold rounded-md hover:bg-yellow-600 transition">
                <i class="fas fa-save mr-2"></i> Update Invoice
            </button>
        </div>
    </form>
</div>
@endsection
