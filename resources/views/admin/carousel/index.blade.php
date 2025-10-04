@extends('layouts.admin')

@section('page-title', 'Carousel')

@section('content')
<div class="max-w-12xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Carousel</h1>
        <a href="{{ route('admin.carousel.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            + Add New Slide
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <table class="w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 border">#</th>
                <th class="p-3 border">Title</th>
                <th class="p-3 border">Subtitle</th>
                <th class="p-3 border">Image</th>
                <th class="p-3 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carousels as $carousel)
                <tr>
                    <td class="p-3 border">{{ $carousel->id }}</td>
                    <td class="p-3 border">{{ $carousel->title }}</td>
                    <td class="p-3 border">{{ $carousel->subtitle }}</td>
                    <td class="p-3 border">
                        @if($carousel->image)
                            <img src="{{ asset('storage/' . $carousel->image) }}" class="h-12">
                        @endif
                    </td>
                    <td class="p-3 border flex gap-2">
                        <a href="{{ route('admin.carousel.edit', $carousel->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('admin.carousel.destroy', $carousel->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 text-center">No slides found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
