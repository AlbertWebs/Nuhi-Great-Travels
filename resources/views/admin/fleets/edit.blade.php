@extends('layouts.admin')

@section('title', 'Edit Fleet')

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-edit text-yellow-500"></i>
        Edit Fleet
    </h2>

    <form action="{{ route('admin.fleets.update', $fleet->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-2">Fleet Name</label>
            <input type="text" name="name" value="{{ $fleet->name }}" required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Type</label>
            <input type="text" name="type" value="{{ $fleet->type }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div class="mb-3">
            <label for="car_id" class="form-label">Select Car</label>
            <select name="car_id" id="car_id" class="form-select" required>
                <option value="">-- Select Car --</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" {{ $fleet->car_id == $car->id ? 'selected' : '' }}>
                        {{ $car->make }} {{ $car->model ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>


        <div>
            <label class="block text-gray-700 font-medium mb-2">Image</label>
            @if($fleet->image)
                <img src="{{ asset('storage/'.$fleet->image) }}" class="w-32 h-32 object-cover rounded mb-3">
            @endif
            <input type="file" name="image" accept="image/*"
                   class="block w-full text-gray-700 border border-gray-300 rounded-lg p-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ $fleet->description }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.fleets.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
