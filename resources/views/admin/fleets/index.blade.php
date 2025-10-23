@extends('layouts.admin')

@section('title', 'Fleet List')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="max-w-12xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-car text-blue-600"></i> Fleet List
        </h2>
        <a href="{{ route('admin.fleets.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Fleet
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Car</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Price (Ksh)</th>
                    <th class="p-3">Description</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fleets as $fleet)
                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">
                        @if($fleet->image)
                            <img src="{{ asset('storage/'.$fleet->image) }}" class="w-16 h-16 object-cover rounded shadow-sm">
                        @else
                            <i class="fas fa-car text-gray-400 text-2xl"></i>
                        @endif
                    </td>
                    <td class="p-3 font-medium text-gray-900">{{ $fleet->name }}</td>
                    <td class="p-3">
                        {{ $fleet->car ? $fleet->car->make . ' ' . $fleet->car->model : '—' }}
                    </td>
                    <td class="p-3 text-gray-700">{{ $fleet->type ?? '—' }}</td>
                    <td class="p-3 text-gray-800 font-semibold">
                        {{ $fleet->price ? number_format($fleet->price, 2) : '—' }}
                    </td>
                    <td class="p-3 text-gray-600">
                        <span title="{{ $fleet->description }}">
                            {{ Str::limit($fleet->description, 60) }}
                        </span>
                    </td>
                    <td class="p-3 text-right flex justify-end gap-2">
                        <!-- ✏️ Edit Button -->
                        <a href="{{ route('admin.fleets.edit', $fleet->id) }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- 🖼️ Manage Images Button -->
                        <a href="{{ route('admin.fleets.images', $fleet->id) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                            <i class="fas fa-images"></i>
                        </a>

                        <!-- 🗑️ Delete Button -->
                        <form action="{{ route('admin.fleets.destroy', $fleet->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this fleet?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500">No fleets found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $fleets->links() }}
    </div>
</div>
@endsection
