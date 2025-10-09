@extends('layouts.admin')

@section('page-title', 'Invoices')

@section('content')
<div class="max-w-12xl mx-auto bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fas fa-file-invoice text-gold"></i>
            Invoices
        </h2>
        <a href="{{ route('admin.invoices.create') }}"
           class="px-4 py-2 bg-gold text-white rounded hover:bg-yellow-600 flex items-center gap-2">
            <i class="fas fa-plus"></i> Create New Invoice
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Client</th>
                    <th class="px-4 py-3 text-left">Vehicle</th>
                    <th class="px-4 py-3 text-left">Pickup</th>
                    <th class="px-4 py-3 text-left">Dropoff</th>
                    <th class="px-4 py-3 text-left">Days</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Created On</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($invoices as $invoice)
                    <tr>
                        <td class="px-4 py-2 font-semibold text-gray-700">
                            INV-{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-2">
                            @if ($invoice->user)
                                {{ $invoice->user->name }} <br>
                                <span class="text-gray-500 text-xs">{{ $invoice->user->email }}</span>
                            @else
                                {{ $invoice->full_name }} <br>
                                <span class="text-gray-500 text-xs">{{ $invoice->email }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $invoice->fleet->name ?? '—' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($invoice->pickup_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($invoice->dropoff_date)->format('d M Y') }}</td>
                        <td class="px-4 py-2 text-center">{{ $invoice->days }}</td>
                        <td class="px-4 py-2 font-semibold text-green-600">
                            Ksh {{ number_format($invoice->total_price, 0) }}
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($invoice->is_sent)
                                <span class="text-green-600 font-semibold flex items-center justify-center gap-1">
                                    <i class="fas fa-check-circle"></i> Sent
                                </span>
                            @else
                                <span class="text-gray-500 flex items-center justify-center gap-1">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-2 text-gray-600">{{ $invoice->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- View --}}
                                <a href="{{ route('admin.invoices.show', $invoice->id) }}"
                                   class="text-blue-600 hover:text-blue-800" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.invoices.edit', $invoice->id) }}"
                                   class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.invoices.destroy', $invoice->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                {{-- Send via SMS --}}
                                <form action="{{ route('admin.invoices.send-sms', $invoice->id) }}" method="POST"
                                      onsubmit="return confirm('Send this invoice via SMS to the client?');">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800" title="Send SMS">
                                        <i class="fas fa-sms"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-6 text-gray-500">
                            No invoices have been created yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
