@extends('layouts.admin')

@section('page-title', 'All Tasks')

@section('content')
<div class="max-w-7xl mx-auto py-10">

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Filter / Sort Tasks -->
    <div class="flex justify-end mb-4">
        <form method="GET" action="{{ route('admin.tasks.index') }}" class="flex items-center space-x-2">
            <label for="status" class="text-gray-700 font-medium">Filter:</label>
            <select name="status" id="status" onchange="this.form.submit()" class="border border-gray-300 rounded px-2 py-1">
                <option value="">All</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="not_completed" {{ request('status') === 'not_completed' ? 'selected' : '' }}>Not Completed</option>
            </select>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-50 text-left text-sm text-gray-600">
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">Title</th>
                    <th class="px-4 py-2 border-b">Notes</th>
                    <th class="px-4 py-2 border-b">Planned Date</th>
                    <th class="px-4 py-2 border-b">Planned Time</th>
                    <th class="px-4 py-2 border-b">Completed</th>
                    <th class="px-4 py-2 border-b">Created By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $task->title }}</td>
                        <td class="px-4 py-2 border-b">{{ Str::limit($task->notes, 50) ?? '--' }}</td>
                        <td class="px-4 py-2 border-b">{{ $task->planned_date ? $task->planned_date->format('d M Y') : '--' }}</td>
                        <td class="px-4 py-2 border-b">{{ $task->planned_time ?? '--' }}</td>
                        <td class="px-4 py-2 border-b">
                            @if($task->is_completed)
                                <span class="px-2 py-1 rounded text-white bg-green-500 text-sm">Yes</span>
                                <small class="text-gray-400 block">{{ $task->completed_at?->diffForHumans() }}</small>
                            @else
                                <span class="px-2 py-1 rounded text-white bg-yellow-500 text-sm">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">{{ $task->user->name ?? 'Unknown' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">No tasks found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $tasks->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
