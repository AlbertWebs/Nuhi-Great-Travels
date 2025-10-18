@extends('layouts.admin')

@section('page-title', 'Pesapal Payments')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6">Pesapal Payments</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Tracking ID</th>
                    <th class="px-4 py-3">Invoice</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Payment Method</th>
                    <th class="px-4 py-3">Sender</th>
                    <th class="px-4 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-mono">{{ $payment->tracking_id }}</td>
                        <td class="px-4 py-2">{{ $payment->merchant_reference }}</td>
                        <td class="px-4 py-2 text-green-600 font-semibold">Ksh {{ number_format($payment->amount, 2) }}</td>
                        <td class="px-4 py-2 font-semibold
                            @if($payment->payment_status === 'failed') text-red-600
                            @elseif($payment->payment_status === 'completed') text-green-600
                            @else text-yellow-600 @endif">
                            {{ $payment->payment_status  }}
                        </td>

                        <td class="px-4 py-2">{{ $payment->payment_method }}</td>
                        <td class="px-4 py-2">{{ $payment->sender_name }}<br><span class="text-gray-500 text-xs">{{ $payment->sender_phone }}</span></td>
                        <td class="px-4 py-2">{{ $payment->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-6 text-gray-500">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>
@endsection
