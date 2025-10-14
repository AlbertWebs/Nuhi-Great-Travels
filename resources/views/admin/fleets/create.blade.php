@extends('layouts.admin')

@section('title', 'Add New Fleet')

@section('content')
<div class="max-w-10xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center gap-2">
        <i class="fas fa-car text-blue-600"></i>
        Add New Fleet
    </h2>

    <form action="{{ route('admin.fleets.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white shadow-lg rounded-xl p-6 space-y-6">
        @csrf

        <!-- Grid Container for side-by-side fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Fleet Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Fleet Name</label>
                <input type="text" name="name" required
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Enter fleet name">
            </div>

            <!-- Car Selection -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Select Car</label>
                <select name="car_id" class="w-full border border-gray-300 rounded-lg p-3" required>
                    <option value="">-- Select Car --</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->make }} {{ $car->model }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Type</label>
                <input type="text" name="type"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. Sedan, SUV, Van">
            </div>

            <!-- Transmission -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Transmission</label>
                <select name="transmission" class="w-full border border-gray-300 rounded-lg p-3">
                    <option value="">-- Select Transmission --</option>
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                </select>
            </div>

            <!-- Fuel Type -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Fuel Type</label>
                <select name="fuel_type" class="w-full border border-gray-300 rounded-lg p-3">
                    <option value="">-- Select Fuel Type --</option>
                    <option value="Petrol">Petrol</option>
                    <option value="Diesel">Diesel</option>
                    <option value="Hybrid">Hybrid</option>
                    <option value="Electric">Electric</option>
                </select>
            </div>

            <!-- Seats -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Seats</label>
                <input type="number" name="seats"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="Enter number of seats">
            </div>

            <!-- Year -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Year</label>
                <input type="number" name="year"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 2023">
            </div>

            <!-- Price Per Day -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Price Per Day (KES)</label>
                <input type="number" step="0.01" name="price_per_day"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 7500">
            </div>

            <!-- Total Price -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Total Price (KES)</label>
                <input type="number" step="0.01" name="price"
                       class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       placeholder="e.g. 120000">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg p-3">
                    <option value="available">Available</option>
                    <option value="unavailable">Unavailable</option>
                    <option value="maintenance">Under Maintenance</option>
                </select>
            </div>

        </div> <!-- End of Grid -->

        <!-- Image -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Fleet Image</label>
            <input type="file" name="image" accept="image/*"
                   class="block w-full text-gray-700 border border-gray-300 rounded-lg p-2">
        </div>

        <!-- Description (Pre) -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Pre</label>
            <textarea name="description" rows="4"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                      placeholder="Enter a short description"></textarea>
        </div>

        <!-- Content -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Content</label>
            <textarea id="content" name="content" rows="6"
                      class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                      style="min-width:500px;"
                      placeholder="Enter content here...">{{ old('content', $fleet->content ?? '') }}</textarea>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- CKEditor --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                ClassicEditor
                    .create(document.querySelector('#content'), {
                        toolbar: [
                            'heading', '|', 'bold', 'italic', 'link', 'bulletedList',
                            'numberedList', 'blockQuote', '|', 'undo', 'redo'
                        ],
                        removePlugins: ['MediaEmbed']
                    })
                    .catch(error => { console.error(error); });
            });
        </script>

        <!-- Actions -->
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
