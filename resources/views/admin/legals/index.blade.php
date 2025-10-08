@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-10 max-w-12xl">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 4-4m0-5V3m-4 0a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2V5a2 2 0 00-2-2h-4z" />
            </svg>
            Legal Pages Management
        </h1>
    </div>

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-hidden bg-white shadow-md rounded-lg border border-gray-200">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-50 text-gray-700 uppercase text-sm font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left">Page</th>
                    <th class="px-6 py-3 text-left">Title</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($legals as $legal)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3-1.343-3-3S10.343 2 12 2s3 1.343 3 3-1.343 3-3 3zm0 4c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4z" />
                            </svg>
                            <span class="capitalize font-medium text-gray-800">{{ $legal->page }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $legal->title }}</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.legals.edit', $legal->page) }}"
                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-sm transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 13v7h7l10-10a2.828 2.828 0 00-4-4L4 13z" />
                                </svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-6 0h6" />
                            </svg>
                            No legal pages found. Try seeding them first.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
