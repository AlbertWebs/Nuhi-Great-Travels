@extends('layouts.admin')

@section('page-title', 'Invoices')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-12xl mx-auto bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold flex items-center gap-2">
            <i class="fas fa-file-invoice text-gold"></i>
            Invoices
        </h2>
        <div class="flex gap-3">
            <a href="{{ route('admin.invoices.create') }}"
               class="px-4 py-2 bg-gold text-white rounded hover:bg-yellow-600 flex items-center gap-2">
                <i class="fas fa-plus"></i> New Invoice
            </a>
            <a href="{{ route('admin.estimates.create') }}"
               class="px-4 py-2 border border-gray-200 rounded hover:bg-gray-50 flex items-center gap-2">
                <i class="fas fa-file-signature"></i> New Estimate
            </a>
        </div>
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
                        <td class="px-4 py-2">
                            {{ $invoice->fleets->pluck('name')->join(', ') ?: '—' }}
                        </td>
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
                                {{-- Pay --}}
                               {{-- Payment Popup Trigger --}}
                                <div x-data="{ open: false, link: '{{ route('frontend.payment.show', $invoice->invoice_number) }}' }" class="relative">
                                    <button @click="open = true" class="text-gold hover:text-yellow-600" title="Make Payment">
                                        <i class="fas fa-link"></i>
                                    </button>

                                    {{-- Popup Modal --}}
                                    <div x-show="open"
                                        x-transition
                                        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                                        <div @click.away="open = false"
                                            class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
                                            {{-- Close Button --}}
                                            <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-times"></i>
                                            </button>

                                            {{-- Header --}}
                                            <h3 class="text-lg font-semibold mb-4 flex items-center gap-2 text-gray-800">
                                                <i class="fas fa-credit-card text-gold"></i> Payment Link
                                            </h3>

                                            {{-- Payment Link Box --}}
                                            <div class="flex items-center bg-gray-100 border border-gray-300 rounded-lg p-2 mb-4">
                                                <input type="text" x-model="link" readonly
                                                    class="w-full bg-transparent focus:outline-none text-sm text-gray-700">
                                                <button @click="navigator.clipboard.writeText(link)"
                                                        class="text-sm text-gold font-medium hover:underline ml-2">
                                                    Copy
                                                </button>
                                            </div>

                                            {{-- Actions --}}
                                            <div class="flex justify-between items-center mt-4">
                                                {{-- WhatsApp --}}
                                                <a :href="'https://wa.me/?text=' + encodeURIComponent('Please make your payment here: ' + link)"
                                                target="_blank"
                                                class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded">
                                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                                </a>

                                                {{-- SMS --}}
                                                <a :href="'sms:?body=' + encodeURIComponent('Please make your payment here: ' + link)"
                                                class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded">
                                                    <i class="fas fa-sms"></i> SMS
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pay  --}}
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
