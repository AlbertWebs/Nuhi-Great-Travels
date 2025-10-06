@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-user-plus text-blue-500 mr-2"></i> Add Client</h2>

    <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-semibold"><i class="fas fa-user mr-2 text-gray-500"></i>Name</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-lg p-2 focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold"><i class="fas fa-image mr-2 text-gray-500"></i>Image</label>
            <input type="file" name="image" class="w-full border-gray-300 rounded-lg p-2">
        </div>

        <button class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700">
            <i class="fas fa-save mr-1"></i> Save
        </button>
    </form>
</div>
@endsection
