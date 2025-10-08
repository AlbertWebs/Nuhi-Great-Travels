@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-10 max-w-12xl">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.5l4 4L7 21H3v-4L16.5 3.5z" />
        </svg>
        <h1 class="text-3xl font-bold text-gray-800">
            Edit: <span class="capitalize text-blue-600">{{ $legal->page }}</span>
        </h1>
    </div>

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.legals.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Legal Pages
        </a>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">
        <form action="{{ route('admin.legals.update', $legal->page) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m0 4v12m-4 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Page Title
                </label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $legal->title) }}"
                    class="w-full border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                    required
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Content Field --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M12 4h9m-9 4h9m-9 4h9M4 4h.01M4 8h.01M4 12h.01M4 16h.01" />
                    </svg>
                    Page Content
                </label>
                <textarea
                    name="content"
                    id="editor"
                    rows="15"
                    class="w-full border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-400 focus:outline-none shadow-sm"
                    style="min-height:500px !important"
                >{{ old('content', $legal->content) }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CKEditor 5 (Free, No API Key) --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<style>
    /* Set the minimum height for the CKEditor editing area */
    .ck-editor__editable_inline {
        min-height: 500px;
    }
</style>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'undo', 'redo', '|',
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>

@endsection
