@extends('layouts.admin')

@section('content')
<div class="max-w-12xl mx-auto p-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold mb-6 flex items-center gap-2 text-gray-800">
        <i class="fas fa-edit text-blue-600"></i> Edit Blog Post
    </h2>

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Title</label>
            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-300">
                <span class="px-3 text-gray-500 bg-gray-50"><i class="fas fa-heading"></i></span>
                <input type="text" name="title" value="{{ $blog->title }}"
                       class="w-full p-2 outline-none focus:ring-0" required>
            </div>
        </div>

        <!-- Author -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Author</label>
            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-300">
                <span class="px-3 text-gray-500 bg-gray-50"><i class="fas fa-user"></i></span>
                <input type="text" name="author" value="{{ $blog->author }}"
                       class="w-full p-2 outline-none focus:ring-0">
            </div>
        </div>

        <!-- Excerpt -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Excerpt</label>
            <div class="flex items-start border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-300">
                <span class="px-3 py-2 text-gray-500 bg-gray-50"><i class="fas fa-align-left"></i></span>
                <textarea name="excerpt" rows="3"
                          class="w-full p-2 outline-none focus:ring-0">{{ $blog->excerpt }}</textarea>
            </div>
        </div>

        <!-- Content -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Content</label>
            <div class="flex items-start border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-300">
                <span class="px-3 py-2 text-gray-500 bg-gray-50"><i class="fas fa-file-alt"></i></span>
                <textarea name="content" rows="6"
                          class="w-full p-2 outline-none focus:ring-0" required>{{ $blog->content }}</textarea>
            </div>
        </div>

        <!-- Featured Image -->
        <div>
            <label class="block mb-2 font-semibold text-gray-700">Featured Image</label>
            @if($blog->featured_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $blog->featured_image) }}"
                         alt="Featured Image"
                         class="w-40 h-32 object-cover rounded-lg shadow border">
                </div>
            @endif
            <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-blue-300">
                <span class="px-3 text-gray-500 bg-gray-50"><i class="fas fa-image"></i></span>
                <input type="file" name="featured_image" class="w-full p-2 outline-none focus:ring-0">
            </div>
        </div>

        <!-- Update Button -->
        <div class="pt-4">
            <button class="w-full bg-blue-600 text-white font-semibold px-5 py-3 rounded-lg shadow-md hover:bg-blue-700 transition">
                <i class="fas fa-save mr-2"></i> Update Post
            </button>
        </div>
    </form>
</div>
@endsection
