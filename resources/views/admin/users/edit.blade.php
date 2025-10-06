@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit User</h2>

    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                <option value="client" @if($user->role == 'client') selected @endif>Client</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 w-full">Update</button>
    </form>
</div>
@endsection
