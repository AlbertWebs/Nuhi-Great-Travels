@extends('layouts.admin')

@section('title', 'Edit Car')

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-edit text-yellow-500"></i>
        Edit Car
    </h2>

    <form action="{{ route('admin.cars.update', $car->id) }}" method="POST"
          class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-gray-700 font-medium mb-2">Car Make</label>
            <input type="text" name="make" value="{{ $car->make }}" required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">{{ $car->description }}</textarea>
        </div>

        <div class="flex items-center gap-3 pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('admin.cars.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow flex items-center gap-2">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>
@endsection
