@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Notifications</h1>
        <a href="{{ route('admin.notifications.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            <i class="fas fa-plus"></i> Add Notification
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2 text-left">Message</th>
                <th class="px-4 py-2 text-center">Status</th>
                <th class="px-4 py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $notification->title }}</td>
                    <td class="px-4 py-2">{{ Str::limit($notification->message, 50) }}</td>
                    <td class="px-4 py-2 text-center">
                        <span class="{{ $notification->is_active ? 'text-green-600' : 'text-red-600' }}">
                            {{ $notification->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('admin.notifications.edit', $notification) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this notification?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
