@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Sent Messages</h1>
        <a href="{{ route('admin.sms.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
            + Send New SMS
        </a>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-3 py-2">#</th>
                <th class="px-3 py-2">Message</th>
                <th class="px-3 py-2">Recipients</th>
                <th class="px-3 py-2">Date</th>
                <th class="px-3 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $msg)
                <tr>
                    <td class="px-3 py-2">{{ $msg->id }}</td>
                    <td class="px-3 py-2">{{ Str::limit($msg->message, 40) }}</td>
                    <td class="px-3 py-2">{{ count($msg->recipients) }}</td>
                    <td class="px-3 py-2">{{ $msg->created_at->format('d M Y H:i') }}</td>
                    <td class="px-3 py-2">
                        <a href="{{ route('admin.sms.show', $msg) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $messages->links() }}
    </div>
</div>
@endsection
