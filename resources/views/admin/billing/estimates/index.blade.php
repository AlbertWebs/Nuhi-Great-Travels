@extends('layouts.admin')

@section('page-title', 'Estimates')

@section('content')
<div class="max-w-12xl mx-auto bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fas fa-file-signature text-gold"></i>
            Estimates
        </h2>
        <div class="flex gap-3">
            <a href="{{ route('admin.estimates.create') }}"
               class="px-4 py-2 bg-gold text-white rounded hover:bg-yellow-600 flex items-center gap-2">
                <i class="fas fa-plus"></i> New Estimate
            </a>
            <a href="{{ route('admin.invoices.create') }}"
               class="px-4 py-2 border border-gray-200 rounded hover:bg-gray-50 flex items-center gap-2">
                <i class="fas fa-file-invoice"></i> Create Invoice
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Estimate #</th>
                    <th class="px-4 py-3 text-left">Client</th>
                    <th class="px-4 py-3 text-left">Vehicles</th>
                    <th class="px-4 py-3 text-left">Pickup</th>
                    <th class="px-4 py-3 text-left">Dropoff</th>
                    <th class="px-4 py-3 text-left">Days</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($estimates as $estimate)
                    <tr>
                        <td class="px-4 py-2 font-semibold text-gray-700">{{ $estimate->estimate_number }}</td>
                        <td class="px-4 py-2">
                            @if ($estimate->user)
                                {{ $estimate->user->name }} <br>
                                <span class="text-gray-500 text-xs">{{ $estimate->user->email }}</span>
                            @else
                                {{ $estimate->full_name ?? 'Walk-in Client' }} <br>
                                <span class="text-gray-500 text-xs">{{ $estimate->email }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-gray-600">
                            {{ $estimate->fleets->pluck('name')->join(', ') ?: '—' }}
                        </td>
                        <td class="px-4 py-2">{{ optional($estimate->pickup_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ optional($estimate->dropoff_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2 text-center">{{ $estimate->days }}</td>
                        <td class="px-4 py-2 font-semibold text-green-600">
                            Ksh {{ number_format($estimate->total_price, 0) }}
                        </td>
                        <td class="px-4 py-2">
                            @if ($estimate->status === 'converted')
                                <span class="inline-flex items-center gap-1 text-green-600">
                                    <i class="fas fa-check-circle"></i> Converted
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-gray-600">
                                    <i class="fas fa-file"></i> {{ ucfirst($estimate->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.estimates.show', $estimate->id) }}"
                                   class="text-blue-600 hover:text-blue-800" title="View & Print">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($estimate->status !== 'converted')
                                    <form action="{{ route('admin.estimates.convert', $estimate->id) }}" method="POST"
                                          onsubmit="return confirm('Convert this estimate to an invoice?');">
                                        @csrf
                                        <button type="submit" class="text-gold hover:text-yellow-600" title="Convert to Invoice">
                                            <i class="fas fa-repeat"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-6 text-gray-500">
                            No estimates yet. Create your first one to share with clients.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $estimates->links() }}
    </div>
</div>
@endsection

