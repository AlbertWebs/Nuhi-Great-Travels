@extends('layouts.admin')

@section('title', 'Manage Images for ' . $fleet->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-images text-blue-600"></i>
        Manage Images — {{ $fleet->name }}
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.fleets.images.store', $fleet->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-4 shadow rounded mb-6">
        @csrf
        <label for="images" class="block mb-2 font-medium text-gray-700">Upload Fleet Images</label>
        <input type="file" name="images[]" id="images" multiple class="border p-2 rounded w-full mb-3" required>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">
            <i class="fas fa-upload"></i> Upload
        </button>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @forelse($fleet->images as $image)
            <div class="relative rounded overflow-hidden shadow">
                <img src="{{ asset('storage/' . $image->image_path) }}"
                     alt="Fleet Image"
                     class="w-full h-40 object-cover rounded">
                <form action="{{ route('admin.fleets.images.destroy', [$fleet->id, $image->id]) }}"
                      method="POST" class="absolute top-2 right-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded shadow-lg"
                            onclick="return confirm('Are you sure you want to delete this image?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center py-6">No images uploaded yet.</p>
        @endforelse
    </div>
</div>
@endsection
