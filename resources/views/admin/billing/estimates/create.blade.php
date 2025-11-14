@extends('layouts.admin')

@section('page-title', 'Create Estimate')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fas fa-file-signature text-gold"></i>
            New Estimate
        </h2>
        <a href="{{ route('admin.invoices.create') }}"
           class="px-4 py-2 border border-gray-200 rounded-md text-sm hover:bg-gray-50 flex items-center gap-2">
            <i class="fas fa-file-invoice"></i>
            Create Invoice Instead
        </a>
    </div>

    <form action="{{ route('admin.estimates.store') }}" method="POST"
          x-data="{ userType: '{{ old('userType', 'existing') }}', total: {{ json_encode(old('total_price', '0.00')) }}, days: {{ (int) old('days', 0) }} }">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-700">
                <p class="font-semibold mb-2 flex items-center gap-2">
                    <i class="fas fa-lightbulb"></i>
                    Quick tips
                </p>
                <ul class="list-disc ml-5 space-y-1">
                    <li>Select one or more vehicles to pre-fill the daily rate.</li>
                    <li>Dates drive the total. Same-day bookings count as 1 day.</li>
                    <li>Converting to an invoice is a single click after saving.</li>
                </ul>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-700">
                <p class="font-semibold mb-2 flex items-center gap-2">
                    <i class="fas fa-print"></i>
                    Ready-to-print layout
                </p>
                <p>
                    After saving, open the estimate and use the built-in print button (same as invoices) to generate a PDF or paper copy for your client.
                </p>
            </div>
        </div>

        @include('admin.billing.partials.form-fields', [
            'fleets' => $fleets,
            'users' => $users,
            'submitLabel' => 'Save Estimate'
        ])

        <div class="mt-6">
            <label class="block text-sm font-semibold mb-2">Internal Notes (optional)</label>
            <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md"
                      placeholder="Add any special terms, add-ons, or reminders for the team.">{{ old('notes') }}</textarea>
        </div>

        <div class="mt-8 flex items-center gap-3">
            <button type="submit"
                    class="px-6 py-2 bg-gold text-white font-semibold rounded hover:bg-yellow-600">
                Save Estimate
            </button>
            <p class="text-sm text-gray-500">You can convert to an invoice later from the estimate page.</p>
        </div>
    </form>
</div>

@push('scripts')
    @include('admin.billing.partials.form-script')
@endpush
@endsection

