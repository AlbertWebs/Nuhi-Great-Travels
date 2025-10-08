@extends('layouts.admin')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded max-w-10xl">
    <h2 class="text-2xl font-bold mb-4 text-center">Add User</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Role</label>
            <select name="role" class="w-full border rounded p-2">
                <option value="admin">Admin</option>
                <option value="client" selected>Client</option>
            </select>
        </div>

        <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 w-full">Save</button>
    </form>
</div>
@endsection
