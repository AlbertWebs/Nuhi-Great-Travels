@extends('layouts.app-layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">

    </div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-800">My Leads</h1>

        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            {{-- Filter by Status --}}
            <form method="GET" action="{{ route('leads.index') }}" class="flex gap-2">
                <select name="status" onchange="this.form.submit()" class="border rounded-md px-3 py-2 w-full text-sm" style="min-width:200px">
                    <option value="">All Statuses</option>
                    @foreach(['new','contacted','qualified','lost','converted'] as $status)
                        <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </form>


        <button id="newLeadBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition w-full sm:w-auto">
            New Lead
        </button>
        </div>
    </div>


    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            <strong>Oops! Please fix the following errors:</strong>
            <ul class="list-disc pl-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Leads Table for larger screens --}}
    <div class="hidden sm:block bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto border-collapse whitespace-nowrap">
            <thead class="bg-gray-50 text-gray-600 text-left text-sm">
                <tr>
                    <th class="px-4 py-2 border-b w-12">#</th>

                    <th class="px-4 py-2 border-b">Name</th>
                    <th class="px-4 py-2 border-b">Company</th>
                    <th class="px-4 py-2 border-b">Phone</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Notes</th>
                    <th class="px-4 py-2 border-b w-40">Status</th>
                    <th class="px-4 py-2 border-b w-32">Created</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
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
                        <td class="px-4 py-2 border-b">{{ $lead->notes ?? '--' }}</td>
                        <td class="px-4 py-2 border-b">
                            <form action="{{ route('leads.updateStatus', $lead) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select
                                    name="status"
                                    onchange="this.form.submit()"
                                    class="border rounded px-3 py-2 text-sm w-full sm:w-40
                                        @switch($lead->status)
                                            @case('new') bg-blue-100 text-blue-700 @break
                                            @case('contacted') bg-yellow-100 text-yellow-700 @break
                                            @case('qualified') bg-indigo-100 text-indigo-700 @break
                                            @case('lost') bg-red-100 text-red-700 @break
                                            @case('converted') bg-green-100 text-green-700 @break
                                        @endswitch
                                    "
                                >
                                    @foreach(['new','contacted','qualified','lost','converted'] as $status)
                                        <option value="{{ $status }}" {{ $lead->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-2 border-b text-sm text-gray-400">{{ $lead->created_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-500 py-4">No leads found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Card view for mobile --}}
    <div class="sm:hidden space-y-4">
        @forelse($leads as $lead)
            <div class="bg-white shadow rounded-lg p-4">
                <p><strong>#:</strong> {{ $loop->iteration }}</p>
                <p><strong>Name:</strong> <a href="{{ route('leads.show', $lead) }}" class="text-indigo-600 hover:underline">{{ $lead->name }}</a></p>
                <p><strong>Company:</strong> {{ $lead->company ?? '--' }}</p>
                <p><strong>Phone:</strong> {{ $lead->phone ?? '--' }}</p>
                <p><strong>Email:</strong> {{ $lead->email ?? '--' }}</p>
                <p><strong>Notes:</strong> {{ $lead->notes ?? '--' }}</p>
                <p>
                    <strong>Status:</strong>
                    <form action="{{ route('leads.updateStatus', $lead) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select
                            name="status"
                            onchange="this.form.submit()"
                            class="border rounded px-3 py-2 text-sm w-full
                                @switch($lead->status)
                                    @case('new') bg-blue-100 text-blue-700 @break
                                    @case('contacted') bg-yellow-100 text-yellow-700 @break
                                    @case('qualified') bg-indigo-100 text-indigo-700 @break
                                    @case('lost') bg-red-100 text-red-700 @break
                                    @case('converted') bg-green-100 text-green-700 @break
                                @endswitch
                            "
                        >
                            @foreach(['new','contacted','qualified','lost','converted'] as $status)
                                <option value="{{ $status }}" {{ $lead->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </p>
                <p class="text-gray-400 text-sm">Created: {{ $lead->created_at->diffForHumans() }}</p>
            </div>
        @empty
            <p class="text-center text-gray-500 py-4">No leads found.</p>
        @endforelse
    </div>

</div>

{{-- Include Create Lead Modal --}}
@include('leads.partials.create-modal')
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newLeadBtn = document.getElementById('newLeadBtn');
        const leadModal = document.getElementById('leadModal');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const saveLeadButton = document.getElementById('saveLeadButton');
        const locationMessage = document.getElementById('locationMessage');
        const shareLocationButton = document.getElementById('shareLocationButton');

        const showLocationMessage = (message) => {
            if (!locationMessage) {
                return;
            }
            if (message) {
                locationMessage.textContent = message;
            }
            locationMessage.classList.remove('hidden');
        };

        const hideLocationMessage = () => {
            if (locationMessage) {
                locationMessage.classList.add('hidden');
            }
        };

        const resetLocationState = () => {
            if (latitudeInput) latitudeInput.value = '';
            if (longitudeInput) longitudeInput.value = '';
            if (saveLeadButton) saveLeadButton.disabled = true;
            showLocationMessage('Please share your location to enable saving this lead.');
            if (shareLocationButton) {
                shareLocationButton.classList.remove('hidden');
                shareLocationButton.disabled = false;
            }
        };

        const enableSaveButton = () => {
            if (saveLeadButton) saveLeadButton.disabled = false;
            hideLocationMessage();
            if (shareLocationButton) {
                shareLocationButton.classList.add('hidden');
            }
        };

        const requestLocation = () => {
            if (!navigator.geolocation) {
                console.warn('Geolocation is not supported by this browser.');
                showLocationMessage('Location access is not supported in this browser. Please use a device that allows sharing location.');
                if (shareLocationButton) {
                    shareLocationButton.disabled = true;
                }
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    if (latitudeInput) latitudeInput.value = position.coords.latitude;
                    if (longitudeInput) longitudeInput.value = position.coords.longitude;
                    enableSaveButton();
                },
                function(error) {
                    console.warn('Geolocation error:', error.message);
                    showLocationMessage('Please enable location sharing in your browser to save this lead.');
                    if (shareLocationButton) {
                        shareLocationButton.disabled = false;
                    }
                }
            );
        };

        if (newLeadBtn && leadModal) {
            newLeadBtn.addEventListener('click', () => {
                leadModal.classList.remove('hidden');
                resetLocationState();
            });
        }

        if (shareLocationButton) {
            shareLocationButton.addEventListener('click', () => {
                shareLocationButton.disabled = true;
                requestLocation();
            });
        }
    });
</script>

@endsection
