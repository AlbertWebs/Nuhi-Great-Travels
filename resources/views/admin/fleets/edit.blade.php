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
        @csrf
        @method('PUT')

        {{-- Fleet Name --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Fleet Name</label>
            <input type="text" name="name" value="{{ old('name', $fleet->name) }}" required
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        {{-- Car --}}
        <div class="mb-3">
            <label for="car_id" class="block text-gray-700 font-medium mb-2">Select Car</label>
            <select name="car_id" id="car_id"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none" required>
                <option value="">-- Select Car --</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" {{ $fleet->car_id == $car->id ? 'selected' : '' }}>
                        {{ $car->make }} {{ $car->model ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Type --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Type</label>
            <input type="text" name="type" value="{{ old('type', $fleet->type) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                   placeholder="e.g. SUV, Sedan, Van">
        </div>

        {{-- Transmission --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Transmission</label>
            <input type="text" name="transmission" value="{{ old('transmission', $fleet->transmission) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                   placeholder="e.g. Automatic, Manual">
        </div>

        {{-- Fuel Type --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Fuel Type</label>
            <input type="text" name="fuel_type" value="{{ old('fuel_type', $fleet->fuel_type) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                   placeholder="e.g. Petrol, Diesel, Electric">
        </div>

        {{-- Seats and Year --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Seats</label>
                <input type="number" name="seats" value="{{ old('seats', $fleet->seats) }}"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 5">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Year</label>
                <input type="number" name="year" value="{{ old('year', $fleet->year) }}"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 2023">
            </div>
        </div>

        {{-- Prices --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Price per Day (KES)</label>
                <input type="number" step="0.01" name="price_per_day" value="{{ old('price_per_day', $fleet->price_per_day) }}"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 5000">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Full Price (KES)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $fleet->price) }}"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 30000">
            </div>
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Status</label>
            <select name="status" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none">
                <option value="available" {{ $fleet->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ $fleet->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                <option value="maintenance" {{ $fleet->status == 'maintenance' ? 'selected' : '' }}>Under Maintenance</option>
            </select>
        </div>

        {{-- Image --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Image</label>
            @if($fleet->image)
                <img src="{{ asset('storage/'.$fleet->image) }}" alt="Fleet Image"
                     class="w-32 h-32 object-cover rounded mb-3">
            @endif
            <input type="file" name="image" accept="image/*"
                   class="block w-full text-gray-700 border border-gray-300 rounded-lg p-2">
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Enter a detailed description">{{ old('description', $fleet->description) }}</textarea>
        </div>
        {{--  --}}
       <div>
            <label class="block text-gray-700 font-medium mb-2">Content</label>
            <textarea id="content" name="content" rows="6"
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                    style="min-width:500px;"
                    placeholder="Enter content here...">{{ old('content', $fleet->content ?? '') }}</textarea>
        </div>

        {{-- Include CKEditor CDN --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                ClassicEditor
                    .create(document.querySelector('#content'), {
                        toolbar: [
                            'heading', '|', 'bold', 'italic', 'link', 'bulletedList',
                            'numberedList', 'blockQuote', '|', 'undo', 'redo'
                        ],
                        removePlugins: ['MediaEmbed'] // optional cleanup
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
        </script>
        {{--  --}}

        {{-- Actions --}}
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
