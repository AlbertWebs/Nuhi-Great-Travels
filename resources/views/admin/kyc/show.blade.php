@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">KYC Review: {{ $kyc->name }}</h1>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div>
            <h2 class="font-semibold text-gray-700 mb-2">Document Type</h2>
            <p class="capitalize">{{ $kyc->document_type }}</p>

            <h2 class="font-semibold text-gray-700 mt-4 mb-2">Status</h2>
            <p class="capitalize">{{ $kyc->status }}</p>

            <h2 class="font-semibold text-gray-700 mt-4 mb-2">Liveliness Data</h2>
            <p class="whitespace-pre-wrap text-sm bg-gray-50 p-2 rounded">
                {{ $kyc->liveliness_data ?? 'N/A' }}
            </p>
        </div>

        <div>
            <h2 class="font-semibold text-gray-700 mb-2">Document Image</h2>
            <img src="{{ asset('storage/' . $kyc->document_image) }}" class="rounded border mb-4" alt="Document Image">

            <h2 class="font-semibold text-gray-700 mb-2">Selfie Image</h2>
            <img src="{{ asset('storage/' . $kyc->selfie_image) }}" class="rounded border" alt="Selfie">
        </div>
    </div>

    <form action="{{ route('admin.kyc.updateStatus', $kyc->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block font-semibold mb-2">Update Status</label>
        <select name="status" class="border px-3 py-2 rounded" required>
            <option value="pending" @selected($kyc->status == 'pending')>Pending</option>
            <option value="approved" @selected($kyc->status == 'approved')>Approved</option>
            <option value="rejected" @selected($kyc->status == 'rejected')>Rejected</option>
        </select>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-2">
            Update
        </button>
    </form>
</div>
@endsection
