@extends('layouts.admin')

@section('page-title', 'All Leads')

@section('content')
<div class="max-w-7xl mx-auto py-10">

    <!-- Success / Error Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <!-- Leads Table -->
    <div class="bg-white shadow rounded p-4 overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-50 text-left text-sm text-gray-600">
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">Name</th>
                    <th class="px-4 py-2 border-b">Company</th>
                    <th class="px-4 py-2 border-b">Phone</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Task</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Notes</th>
                    <th class="px-4 py-2 border-b">Location</th>
                    <th class="px-4 py-2 border-b">Created By</th>
                    <th class="px-4 py-2 border-b">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $lead->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $lead->company ?? '--' }}</td>
                        <td class="px-4 py-2 border-b">{{ $lead->phone ?? '--' }}</td>
                        <td class="px-4 py-2 border-b">{{ $lead->email ?? '--' }}</td>
                        <td class="px-4 py-2 border-b">
                            @if($lead->task)
                                <a href="{{ route('admin.tasks.show', $lead->task) }}" class="text-indigo-600 hover:underline">
                                    {{ $lead->task->title }}
                                </a>
                            @else
                                --
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">
                            <span class="px-2 py-1 rounded text-white text-sm
                                @switch($lead->status)
                                    @case('new') bg-blue-500 @break
                                    @case('contacted') bg-yellow-500 @break
                                    @case('qualified') bg-green-500 @break
                                    @case('lost') bg-red-500 @break
                                    @case('converted') bg-indigo-500 @break
                                    @default bg-gray-400
                                @endswitch
                            ">
                                {{ ucfirst($lead->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border-b">{{ Str::limit($lead->notes, 50) ?? '--' }}</td>

                        {{-- Location Column --}}
                        <td class="px-4 py-2 border-b">
                            @if($lead->latitude && $lead->longitude)
                                <a href="https://www.google.com/maps?q={{ $lead->latitude }},{{ $lead->longitude }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                   View Location
                                </a>
                            @else
                                --
                            @endif
                        </td>

                        <td class="px-4 py-2 border-b">{{ $lead->user->name ?? 'Unknown' }}</td>
                        <td class="px-4 py-2 border-b text-sm text-gray-400">{{ $lead->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-gray-500 py-4">No leads found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $leads->links() }}
        </div>
    </div>
</div>
@endsection
