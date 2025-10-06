@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Blog Posts</h2>
        <a href="{{ route('admin.blogs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Add New</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border border-gray-200 rounded-lg shadow-sm">
        <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
            <tr>
                <th class="p-3 text-left">Title</th>
                <th class="p-3 text-left">Author</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3 font-medium">{{ $blog->title }}</td>
                    <td class="p-3">{{ $blog->author ?? 'N/A' }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded {{ $blog->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ $blog->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-3">
                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
