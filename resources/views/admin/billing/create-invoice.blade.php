@extends('layouts.admin')

@section('page-title', 'Create Invoice')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fas fa-file-invoice text-gold"></i>
        Create New Invoice
    </h2>

    <form action="{{ route('admin.invoices.store') }}" method="POST"
          x-data="{ userType: 'existing', total: 0, days: 0 }">
        @csrf

        {{-- Fleet Selection --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold mb-3">Select Vehicle(s)</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                @foreach ($fleets as $fleet)
                    <label class="flex items-center gap-2 border p-3 rounded-md hover:bg-gray-50 cursor-pointer">
                        <input type="checkbox" name="fleet_ids[]" value="{{ $fleet->id }}"
                            data-rate="{{ $fleet->price_per_day }}" class="fleet-checkbox">
                        <span>{{ $fleet->name }} — Ksh {{ number_format($fleet->price_per_day, 2) }} / day</span>
                    </label>
                @endforeach
            </div>
            <p class="text-xs text-gray-500 mt-1">Select one or more vehicles for this invoice.</p>
            {{-- <input type="hidden" name="price_per_day" id="price_per_day"> --}}
            <input type="hidden" name="price_per_day_total" id="price_per_day">
        </div>

        {{-- Pickup & Dropoff Dates --}}
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
            <label class="block text-sm font-semibold mb-2">Total Price (Ksh)</label>
            <input type="text" readonly x-model="total"
                   name="total_price"
                   class="w-full border-gray-300 rounded-md bg-gray-50 font-semibold text-lg">
        </div>

        <input type="hidden" name="days" x-model="days">

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

{{-- Calculation Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.fleet-checkbox');
    const pickupInput = document.getElementById('pickup_date');
    const dropoffInput = document.getElementById('dropoff_date');
    const totalInput = document.querySelector('[x-model="total"]');
    const daysInput = document.querySelector('[x-model="days"]');
    const priceInput = document.getElementById('price_per_day');

    const MS_PER_DAY = 1000 * 60 * 60 * 24;

    // Parse YYYY-MM-DD into a local Date at midnight (avoid timezone offset)
    function parseDateLocal(dateString) {
        if (!dateString) return null;
        const parts = dateString.split('-').map(Number);
        // parts: [year, month, day] — month is 1-based
        return new Date(parts[0], parts[1] - 1, parts[2]);
    }

    function calculateTotal() {
        // Sum selected vehicles' daily rates
        let totalRate = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) totalRate += parseFloat(cb.dataset.rate || 0);
        });

        priceInput.value = totalRate; // total daily rate (sum of each vehicle's day rate)

        const pickup = parseDateLocal(pickupInput.value);
        const dropoff = parseDateLocal(dropoffInput.value);

        if (pickup && dropoff) {
            // compute difference in full days using local-midnight dates
            const diffMs = dropoff.getTime() - pickup.getTime();

            // If dropoff is before pickup, show 0 and leave validation for server/HTML
            if (diffMs < 0) {
                daysInput.value = 0;
                totalInput.value = '0.00';
                return;
            }

            // Convert to days (use Math.round to avoid tiny floating / DST gaps after local-midnight parsing)
            const diffDays = Math.round(diffMs / MS_PER_DAY);
            // If same day diffDays === 0 -> rental should be 1 day
            const days = Math.max(1, diffDays);
            daysInput.value = days;

            // Total = days * totalRate
            const total = days * totalRate;
            // Update Alpine x-model bound field (string)
            totalInput.value = total.toFixed(2);
        } else {
            daysInput.value = 0;
            totalInput.value = '0.00';
        }
    }

    // Attach listeners
    checkboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
    pickupInput.addEventListener('change', calculateTotal);
    dropoffInput.addEventListener('change', calculateTotal);

    // Optionally run at load to prefill if dates/checkboxes are pre-populated
    calculateTotal();
});
</script>
@endsection
