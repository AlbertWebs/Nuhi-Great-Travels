@extends('layouts.admin')

@section('title', 'Manage Services')
@section('page-title', 'Services')

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-cogs text-blue-600"></i> Services
        </h2>
        <a href="{{ route('admin.services.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Add Service
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-100">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="py-3 px-4 text-left border-b">#</th>
                    <th class="py-3 px-4 text-left border-b">Title</th>
                    <th class="py-3 px-4 text-left border-b">Status</th>
                    <th class="py-3 px-4 text-left border-b">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse($services as $service)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 border-b">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border-b font-medium">{{ $service->title }}</td>
                        <td class="py-3 px-4 border-b">
                            @if($service->is_active)
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b flex gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}"
                               class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">No services found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
