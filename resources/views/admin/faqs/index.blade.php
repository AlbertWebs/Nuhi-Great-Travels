@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'FAQs')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@section('content')
<div class="max-w-12xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i class="fas fa-question-circle text-blue-600"></i> FAQs
        </h2>
        <a href="{{ route('admin.faq.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Add FAQ
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="w-full border-collapse border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase">
                <tr class="border-b border-gray-200">
                    <th class="py-3 px-4 font-semibold w-12 text-center">#</th>
                    <th class="py-3 px-4 font-semibold">Question</th>
                    <th class="py-3 px-4 font-semibold w-32 text-center">Status</th>
                    <th class="py-3 px-4 font-semibold w-48 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-100">
                @forelse($faqs as $faq)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 align-middle">{{ $faq->question }}</td>
                        <td class="py-3 px-4 text-center">
                            @if($faq->is_active)
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-200 rounded-full">
                                    <i class="fas fa-ban mr-1"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="inline-flex gap-2 justify-center">
                                <a href="{{ route('admin.faq.edit', $faq) }}"
                                   class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-xs font-medium flex items-center gap-1 transition">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.faq.destroy', $faq) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-medium flex items-center gap-1 transition">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">No FAQs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
