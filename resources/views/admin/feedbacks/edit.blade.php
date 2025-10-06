@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-12xl mx-auto bg-white rounded-xl shadow-sm">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-gray-800">
        <!-- Pencil Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5l3 3L10 17l-4 1 1-4L18.5 2.5z" />
        </svg>
        Edit Feedback
    </h2>

    <form action="{{ route('admin.feedbacks.update', $feedback) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 flex items-center gap-2">
                <!-- User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1118.879 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Name
            </label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $feedback->name) }}"
                class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200 focus:outline-none"
                required>
        </div>

        {{-- Position --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 flex items-center gap-2">
                <!-- Briefcase Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M9 3h6a2 2 0 012 2v2H7V5a2 2 0 012-2zM3 7v10a2 2 0 002 2h14a2 2 0 002-2V7" />
                </svg>
                Position
            </label>
            <input
                type="text"
                name="position"
                value="{{ old('position', $feedback->position) }}"
                class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Company --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 flex items-center gap-2">
                <!-- Building Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M9 8h6m-6 4h6m-9 4h12V3H6v13z" />
                </svg>
                Company
            </label>
            <input
                type="text"
                name="company"
                value="{{ old('company', $feedback->company) }}"
                class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Message --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 flex items-center gap-2">
                <!-- Message Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h8m-8 4h6m2 6l4-4H6a2 2 0 01-2-2V6a2 2 0 012-2h16v12a2 2 0 01-2 2h-4z" />
                </svg>
                Message
            </label>
            <textarea
                name="message"
                rows="5"
                class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200 focus:outline-none"
                required>{{ old('message', $feedback->message) }}</textarea>
        </div>

        {{-- Photo --}}
        <div>
            <label class="block mb-1 font-medium text-gray-700 flex items-center gap-2">
                <!-- Image Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4 4 4 4-4 4 4M4 8l4 4 4-4 4 4 4-4" />
                </svg>
                Photo
            </label>

            @if($feedback->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$feedback->photo) }}" alt="Photo" class="w-24 h-24 rounded-lg object-cover border">
                </div>
            @endif

            <input
                type="file"
                name="photo"
                class="w-full border rounded-lg p-2.5 focus:ring focus:ring-blue-200 focus:outline-none">
        </div>

        {{-- Submit --}}
        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition">
            <!-- Save Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Update Feedback
        </button>
    </form>
</div>
@endsection
