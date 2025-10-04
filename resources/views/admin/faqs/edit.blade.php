@extends('layouts.admin')

@section('title', 'Edit FAQ')

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <!-- Page Title -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-edit text-blue-600"></i>
        Edit FAQ
    </h2>

    <!-- Form -->
    <form action="{{ route('admin.faq.update', $faq) }}" method="POST" class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Question -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Question</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fas fa-question"></i>
                </span>
                <input type="text" name="question" value="{{ $faq->question }}" required
                    class="pl-10 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                    placeholder="Enter the FAQ question">
            </div>
        </div>

        <!-- Answer -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Answer</label>
            <div class="relative">
                <span class="absolute top-3 left-3 text-gray-400">
                    <i class="fas fa-pen"></i>
                </span>
                <textarea name="answer" rows="5" required
                    class="pl-10 w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"
                    placeholder="Write the answer here...">{{ $faq->answer }}</textarea>
            </div>
        </div>

        <!-- Active Toggle -->
        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" id="is_active" {{ $faq->is_active ? 'checked' : '' }}
                class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_active" class="text-gray-700 font-medium">Active</label>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.faq.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
