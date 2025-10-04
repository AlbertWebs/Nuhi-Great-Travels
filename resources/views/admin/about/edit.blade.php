@extends('layouts.admin')

@section('page-title', 'About Us')

@section('content')
<div class="max-w-4xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Edit About Us Page</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">Featured Image</label>
            @if($about && $about->featured_image)
                <img src="{{ asset('storage/' . $about->featured_image) }}" class="w-48 mb-3 rounded-lg shadow">
            @endif
            <input type="file" name="featured_image" class="w-full border border-gray-300 rounded-lg p-2">
        </div>
        <div>
            <label class="block text-sm font-medium mb-2">Description</label>
            <textarea id="editor" name="description" class="w-full border border-gray-300 rounded-lg p-2">{{ $about->description ?? '' }}</textarea>
        </div>

        {{-- Initialize CKEditor with min-height --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let editorInstance;

                ClassicEditor
                    .create(document.querySelector('#editor'))
                    .then(editor => {
                        editorInstance = editor;

                        // Set minimum height
                        editor.editing.view.change(writer => {
                            writer.setStyle('min-height', '200px', editor.editing.view.document.getRoot());
                        });

                        // Sync editor content to textarea before form submission
                        const form = document.querySelector('form');
                        if (form) {
                            form.addEventListener('submit', function () {
                                document.querySelector('#editor').value = editorInstance.getData();
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor:', error);
                    });
            });
        </script>


        <div>
            <label class="block text-sm font-medium mb-2">Mission</label>
            <input type="text" name="mission" value="{{ $about->mission ?? '' }}" class="w-full border border-gray-300 rounded-lg p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Vision</label>
            <input type="text" name="vision" value="{{ $about->vision ?? '' }}" class="w-full border border-gray-300 rounded-lg p-2" required>
        </div>

        <div class="text-right">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
        </div>
    </form>
</div>
@endsection
