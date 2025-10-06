@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Clients</h2>

    <a href="{{ route('admin.clients.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">
        <i class="fas fa-plus"></i> Add Client
    </a>

    <div class="overflow-x-auto mt-4">
        <table class="min-w-full border border-gray-200 bg-white rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Image</th>
                    <th class="py-2 px-4 text-left">Name</th>
                    <th class="py-2 px-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr class="border-t">
                    <td class="py-2 px-4">
                        @if($client->image)
                            <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}" class="h-12 rounded">
                        @else
                            <span class="text-gray-400">No image</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 font-semibold">{{ $client->name }}</td>
                    <td class="py-2 px-4 text-right space-x-2">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="text-blue-500 hover:underline">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Delete this client?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
