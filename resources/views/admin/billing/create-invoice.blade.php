@extends('layouts.admin')

@section('page-title', 'Create Invoice')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fas fa-file-invoice text-gold"></i>
            Create New Invoice
        </h2>
        <a href="{{ route('admin.estimates.create') }}"
           class="px-4 py-2 border border-gray-200 rounded-md text-sm hover:bg-gray-50 flex items-center gap-2">
            <i class="fas fa-file-signature"></i>
            Need an Estimate?
        </a>
    </div>

    <form action="{{ route('admin.invoices.store') }}" method="POST"
          x-data="{ userType: '{{ old('userType', 'existing') }}', total: {{ old('total_price', 0) }}, days: {{ old('days', 0) }} }">
        @csrf

        @include('admin.billing.partials.form-fields', [
            'fleets' => $fleets,
            'users' => $users,
            'submitLabel' => 'Generate Invoice'
        ])

        <div class="mt-8">
            <button type="submit"
                    class="px-6 py-2 bg-gold text-white font-semibold rounded hover:bg-yellow-600">
                Generate Invoice
            </button>
        </div>
    </form>
</div>

@push('scripts')
    @include('admin.billing.partials.form-script')
@endpush
@endsection
