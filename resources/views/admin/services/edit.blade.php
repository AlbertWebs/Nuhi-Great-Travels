@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-edit text-yellow-500"></i> Edit Service
    </h2>

    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-lg rounded-xl p-6 space-y-6 border border-gray-100">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" name="title" value="{{ $service->title }}" required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="editor" name="description" rows="5"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none">{{ $service->description }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Change Image</label>
            @if($service->image)
                <img style="width:200px; object-fit:cover" src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->title }}" class="h-24 rounded-lg mb-3 border">
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" name="is_active" id="is_active" {{ $service->is_active ? 'checked' : '' }}
                   class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_active" class="text-gray-700 font-medium">Active</label>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.services.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
<!-- Include CKEditor 5 from CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error('CKEditor initialization error:', error);
            });
    </script>
@endsection

@section('scripts')

@endsection
