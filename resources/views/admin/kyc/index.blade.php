@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">KYC Submissions</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
    @endif

    <div class="mb-4 text-right">
        <a href="{{ route('admin.kyc.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">New Submission</a>
    </div>

    <table class="min-w-full border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="py-2 px-3 border">#</th>
                <th class="py-2 px-3 border">Name</th>
                <th class="py-2 px-3 border">Document Type</th>
                <th class="py-2 px-3 border">Status</th>
                <th class="py-2 px-3 border">Created</th>
                <th class="py-2 px-3 border text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kycs as $kyc)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-3 border">{{ $loop->iteration }}</td>
                    <td class="py-2 px-3 border">{{ $kyc->name }}</td>
                    <td class="py-2 px-3 border capitalize">{{ $kyc->document_type }}</td>
                    <td class="py-2 px-3 border">
                        <span class="px-2 py-1 rounded text-xs
                            @if($kyc->status == 'approved') bg-green-100 text-green-700
                            @elseif($kyc->status == 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700
                            @endif">
                            {{ ucfirst($kyc->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-3 border">{{ $kyc->created_at->format('d M Y') }}</td>
                    <td class="py-2 px-3 border text-center">
                        <a href="{{ route('admin.kyc.show', $kyc->id) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $kycs->links() }}
    </div>
</div>
@endsection
