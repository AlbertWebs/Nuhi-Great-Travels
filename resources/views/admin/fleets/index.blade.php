@extends('layouts.admin')

@section('title', 'Fleet List')

@section('content')
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
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Type</th>
                    <th class="p-3">Description</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fleets as $fleet)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3">
                        @if($fleet->image)
                            <img src="{{ asset('storage/'.$fleet->image) }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <i class="fas fa-car text-gray-400 text-2xl"></i>
                        @endif
                    </td>
                    <td class="p-3 font-medium">{{ $fleet->name }}</td>
                    <td class="p-3">
                        {{-- {{ $fleet->type ?? '—' }}<br>
                        <hr> --}}
                        {{ $fleet->car ? $fleet->car->make . ' ' . $fleet->car->model : 'N/A' }}
                    </td>
                    <td class="p-3">{{ Str::limit($fleet->description, 500) }}</td>
                    <td class="p-3 text-right flex justify-end gap-2">
                        <a href="{{ route('admin.fleets.edit', $fleet->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                           <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.fleets.destroy', $fleet->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">No fleets found.</td>
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
