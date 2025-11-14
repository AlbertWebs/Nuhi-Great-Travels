@php
    $fleetQuantities = collect(old('fleets', []))->map(fn ($qty) => (int) $qty);
@endphp

{{-- Fleet Selection --}}
<div class="mb-6">
    <label class="block text-sm font-semibold mb-3">Select Vehicle(s)</label>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($fleets as $fleet)
            <div class="border p-3 rounded-md hover:bg-gray-50 flex flex-col gap-3">
                <div>
                    <p class="font-semibold text-sm">{{ $fleet->name }}</p>
                    <p class="text-xs text-gray-500">Ksh {{ number_format($fleet->price_per_day, 2) }} / day</p>
                </div>
                <div class="flex items-center gap-2">
                    <label for="fleet-qty-{{ $fleet->id }}" class="text-sm text-gray-600">Quantity</label>
                    <input type="number"
                           min="0"
                           name="fleets[{{ $fleet->id }}]"
                           id="fleet-qty-{{ $fleet->id }}"
                           class="fleet-quantity w-20 border-gray-300 rounded-md text-center"
                           data-rate="{{ $fleet->price_per_day }}"
                           value="{{ $fleetQuantities->get($fleet->id, 0) }}">
                </div>
            </div>
        @endforeach
    </div>
    <p class="text-xs text-gray-500 mt-1">Set quantity for each vehicle needed for this {{ $submitLabel === 'Save Estimate' ? 'estimate' : 'invoice' }}.</p>
    <input type="hidden" name="price_per_day_total" id="price_per_day">
</div>

{{-- Pickup & Dropoff Dates --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div>
        <label class="block text-sm font-semibold mb-2">Pickup Date</label>
        <input type="date" name="pickup_date" id="pickup_date"
               value="{{ old('pickup_date') }}"
               class="w-full border-gray-300 rounded-md" required>
    </div>
    <div>
        <label class="block text-sm font-semibold mb-2">Dropoff Date</label>
        <input type="date" name="dropoff_date" id="dropoff_date"
               value="{{ old('dropoff_date') }}"
               class="w-full border-gray-300 rounded-md" required>
    </div>
</div>

{{-- Total Price --}}
<div class="mb-6">
    <label class="block text-sm font-semibold mb-2">Total Price (Ksh)</label>
    <input type="text" readonly x-model="total"
           name="total_price"
           value="{{ old('total_price', '0.00') }}"
           class="w-full border-gray-300 rounded-md bg-gray-50 font-semibold text-lg">
</div>

<input type="hidden" name="days" x-model="days" value="{{ old('days', 0) }}">

{{-- Client Type --}}
<div class="mb-4">
    <label class="block text-sm font-semibold mb-2">Client Type</label>
    <div class="flex gap-4">
        <label class="flex items-center gap-2">
            <input type="radio" name="userType" value="existing" x-model="userType"
                   {{ old('userType', 'existing') === 'existing' ? 'checked' : '' }}>
            Existing User
        </label>
        <label class="flex items-center gap-2">
            <input type="radio" name="userType" value="new" x-model="userType"
                   {{ old('userType') === 'new' ? 'checked' : '' }}>
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
            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                {{ $user->name }} ({{ $user->email }})
            </option>
        @endforeach
    </select>
</div>

{{-- New User --}}
<div x-show="userType === 'new'" x-transition>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
        <div>
            <label class="block text-sm font-semibold mb-1">Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md">
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">M-Pesa Number</label>
            <input type="text" name="mpesa_number" value="{{ old('mpesa_number') }}" class="w-full border-gray-300 rounded-md">
        </div>
    </div>
</div>

