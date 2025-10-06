@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-edit text-yellow-500 mr-2"></i> Edit Client</h2>

    <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1 font-semibold"><i class="fas fa-user mr-2 text-gray-500"></i>Name</label>
            <input type="text" name="name" value="{{ $client->name }}" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold"><i class="fas fa-image mr-2 text-gray-500"></i>Image</label>
            @if($client->image)
                <img src="{{ asset('storage/' . $client->image) }}" class="w-24 rounded mb-2" alt="Client Image">
            @endif
            <input type="file" name="image" class="w-full border-gray-300 rounded-lg p-2">
        </div>

        <button class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">
            <i class="fas fa-save mr-1"></i> Update
        </button>
    </form>
</div>
@endsection
