@extends('layouts.admin')

@section('page-title', 'Add New Carousel Slide')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-semibold mb-6">Add New Carousel Slide</h1>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('admin.carousel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block font-semibold">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" 
                   class="w-full border rounded p-2" required>
                   <small class="text-gray-500">Text in theme color should be inside &lt;span&gt;inside here&lt;/span&gt;</small>
        </div>

        <div>
            <label class="block font-semibold">Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle') }}" 
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Subtitle Two</label>
            <input type="text" name="subtitle_two" value="{{ old('subtitle_two') }}" 
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Button Text</label>
            <input type="text" name="button_text" value="{{ old('button_text') }}" 
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Button Link</label>
            <input type="url" name="button_link" value="{{ old('button_link') }}" 
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Video Link (YouTube)</label>
            <input type="url" name="video_link" value="{{ old('video_link') }}" 
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block font-semibold">Background Image</label>
            <input type="file" name="image" class="w-full border rounded p-2" required>
        </div>

        <div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">
                Save Slide
            </button>
            <a href="{{ route('admin.carousel.index') }}" class="ml-3 text-gray-600">Cancel</a>
        </div>
    </form>
</div>
@endsection
