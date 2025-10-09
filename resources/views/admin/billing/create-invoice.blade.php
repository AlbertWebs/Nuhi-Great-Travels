@extends('layouts.admin')

@section('page-title', 'Create Invoice')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fas fa-file-invoice text-gold"></i>
        Create New Invoice
    </h2>

    <form action="{{ route('admin.invoices.store') }}" method="POST"
          x-data="{ userType: 'existing', total: 0, rate: 0 }">
        @csrf

        {{-- Fleet Selection --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Select Fleet</label>
            <select name="fleet_id" id="fleet_id" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Select Vehicle --</option>
                @foreach ($fleets as $fleet)
                    <option value="{{ $fleet->id }}" data-rate="{{ $fleet->price_per_day }}">
                        {{ $fleet->name }} - {{ number_format($fleet->price_per_day, 2) }} / day
                    </option>
                @endforeach
            </select>
            {{-- Hidden price per day --}}
            <input type="hidden" name="price_per_day" id="price_per_day">
        </div>

        {{-- Dates --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold mb-2">Pickup Date</label>
                <input type="date" name="pickup_date" id="pickup_date"
                       class="w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Dropoff Date</label>
                <input type="date" name="dropoff_date" id="dropoff_date"
                       class="w-full border-gray-300 rounded-md" required>
            </div>
        </div>

        {{-- Total Price --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Total Price</label>
            <input type="text" x-model="total" readonly name="total_price"
                   class="w-full border-gray-300 rounded-md bg-gray-50 font-semibold text-lg">
        </div>

        {{-- Client Type --}}
        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Client Type</label>
            <div class="flex gap-4">
                <label class="flex items-center gap-2">
                    <input type="radio" name="userType" value="existing" x-model="userType" checked>
                    Existing User
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="userType" value="new" x-model="userType">
                    New User
                </label>
            </div>
        </div>

        {{-- Existing User --}}
        <div x-show="userType === 'existing'" x-transition>
            <label class="block text-sm font-semibold mb-2">Select Existing User</label>
            <select name="user_id" class="w-full border-gray-300 rounded-md">
                <option value="">-- Choose User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- New User --}}
        <div x-show="userType === 'new'" x-transition>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Full Name</label>
                    <input type="text" name="full_name" class="w-full border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Email</label>
                    <input type="email" name="email" class="w-full border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">M-Pesa Number</label>
                    <input type="text" name="mpesa_number" class="w-full border-gray-300 rounded-md">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-8">
            <button type="submit"
                    class="px-6 py-2 bg-gold text-white font-semibold rounded hover:bg-yellow-600">
                Generate Invoice
            </button>
        </div>
    </form>
</div>

{{-- Auto Calculate Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fleetSelect = document.getElementById('fleet_id');
        const pickupInput = document.getElementById('pickup_date');
        const dropoffInput = document.getElementById('dropoff_date');
        const totalInput = document.querySelector('[x-model="total"]');
        const priceInput = document.getElementById('price_per_day');

        function calculateTotal() {
            const rate = parseFloat(fleetSelect.selectedOptions[0]?.dataset.rate || 0);
            const pickup = new Date(pickupInput.value);
            const dropoff = new Date(dropoffInput.value);

            // update hidden price field
            priceInput.value = rate;

            if (pickup && dropoff && !isNaN(pickup) && !isNaN(dropoff)) {
                const days = Math.max(1, Math.ceil((dropoff - pickup) / (1000 * 60 * 60 * 24)));
                totalInput.value = Math.round(days * rate);
            } else {
                totalInput.value = 0;
            }
        }

        fleetSelect.addEventListener('change', calculateTotal);
        pickupInput.addEventListener('change', calculateTotal);
        dropoffInput.addEventListener('change', calculateTotal);
    });
</script>
@endsection
