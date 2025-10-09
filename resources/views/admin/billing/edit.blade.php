@extends('layouts.admin')

@section('page-title', 'Edit Invoice')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fas fa-file-invoice text-gold"></i>
        Edit Invoice #{{ $invoice->id }}
    </h2>

    <form action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Select Fleet</label>
            <select name="fleet_id" class="w-full border-gray-300 rounded-md" required>
                @foreach ($fleets as $fleet)
                    <option value="{{ $fleet->id }}" {{ $invoice->fleet_id == $fleet->id ? 'selected' : '' }}>
                        {{ $fleet->name }} - {{ number_format($fleet->price_per_day, 2) }} / day
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold mb-2">Pickup Date</label>
                <input type="date" name="pickup_date" value="{{ $invoice->pickup_date }}" class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Dropoff Date</label>
                <input type="date" name="dropoff_date" value="{{ $invoice->dropoff_date }}" class="w-full border-gray-300 rounded-md" required>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Total Price</label>
            <input type="number" name="total_price" value="{{ $invoice->total_price }}" class="w-full border-gray-300 rounded-md">
        </div>

        <div class="mt-8">
            <button type="submit"
                    class="px-6 py-2 bg-gold text-white font-semibold rounded hover:bg-yellow-600">
                Update Invoice
            </button>
        </div>
    </form>
</div>
@endsection
