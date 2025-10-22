@extends('layouts.app-layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">All Leads</h1>
    <button id="newLeadBtn" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
      New Lead
    </button>
  </div>

  <!-- Success Message -->
  @if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  <!-- Error Message -->
  @if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      {{ session('error') }}
    </div>
  @endif

  <!-- Validation Errors -->
  @if ($errors->any())
    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      <strong>Oops! Please fix the following errors:</strong>
      <ul class="list-disc pl-5 mt-2">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Leads Table -->
  <div class="bg-white shadow rounded p-4">
    <table class="min-w-full table-auto border-collapse">
      <thead>
        <tr class="bg-gray-50 text-left text-sm text-gray-600">
          <th class="px-4 py-2 border-b">#</th>
          <th class="px-4 py-2 border-b">Name</th>
          <th class="px-4 py-2 border-b">Company</th>
          <th class="px-4 py-2 border-b">Phone</th>
          <th class="px-4 py-2 border-b">Email</th>
          <th class="px-4 py-2 border-b">Created</th>
        </tr>
      </thead>
      <tbody>
        @forelse($leads as $lead)
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-2 border-b text-gray-500">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 border-b">
              <a href="{{ route('leads.show', $lead) }}" class="text-indigo-600 hover:underline">
                {{ $lead->name }}
              </a>
            </td>
            <td class="px-4 py-2 border-b">{{ $lead->company ?? '--' }}</td>
            <td class="px-4 py-2 border-b">{{ $lead->phone ?? '--' }}</td>
            <td class="px-4 py-2 border-b">{{ $lead->email ?? '--' }}</td>
            <td class="px-4 py-2 border-b text-sm text-gray-400">{{ $lead->created_at->diffForHumans() }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="text-center text-gray-500 py-4">No leads found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

</div>

@include('leads.partials.create-modal')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  const newLeadBtn = document.getElementById('newLeadBtn');
  const leadModal = document.getElementById('leadModal');

  if(newLeadBtn && leadModal){
    newLeadBtn.addEventListener('click', () => leadModal.classList.remove('hidden'));
  }
});
</script>
@endsection
