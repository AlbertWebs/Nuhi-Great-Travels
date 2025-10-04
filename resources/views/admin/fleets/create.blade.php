@extends('layouts.admin')

@section('title', 'Add New Fleet')

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-car text-blue-600"></i>
        Add New Fleet
    </h2>

    <form action="{{ route('admin.fleets.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Fleet Name</label>
            <input type="text" name="name" required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                   placeholder="Enter fleet name">
        </div>

        <div class="mb-3">
            <label class="form-label">Select Car type</label>
            <select name="car_id" class="form-select" required>
                <option value="">-- Select Car --</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->make }} {{ $car->model }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Type</label>
            <input type="text" name="type"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                   placeholder="e.g. Sedan, SUV, Van">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Image</label>
            <input type="file" name="image" accept="image/*"
                   class="block w-full text-gray-700 border border-gray-300 rounded-lg p-2">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Enter a short description"></textarea>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-save"></i> Save
            </button>
            <a href="{{ route('admin.fleets.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
