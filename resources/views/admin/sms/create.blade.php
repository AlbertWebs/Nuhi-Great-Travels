@extends('layouts.admin')

@section('content')
<div class="max-w-12xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Send New SMS</h1>

    <form action="{{ route('admin.sms.store') }}" method="POST">
        @csrf

        {{-- SMS Message --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">Message</label>
            <textarea name="message" rows="4" class="w-full border rounded p-2 focus:ring focus:ring-blue-300" required></textarea>
        </div>

        {{-- Select Registered Users --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">Select Users (optional)</label>
            <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto border p-2 rounded">
                @foreach($users as $user)
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="recipients[]" value="{{ $user->id }}">
                        <span>{{ $user->name }} ({{ $user->phone ?? 'No Phone' }})</span>
                    </label>
                @endforeach
            </div>
            <p class="text-sm text-gray-500 mt-1">Select one or more users to send the SMS.</p>
        </div>

        {{-- Manual Phone Numbers --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Enter Phone Numbers (optional)</label>
            <textarea
                name="manual_numbers"
                rows="3"
                placeholder="e.g. 0712345678, 0723456789 or one per line"
                class="w-full border rounded p-2 focus:ring focus:ring-blue-300"></textarea>
            <p class="text-sm text-gray-500 mt-1">Separate multiple numbers with commas or new lines.</p>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
                📤 Send SMS
            </button>
        </div>
    </form>
</div>
@endsection
