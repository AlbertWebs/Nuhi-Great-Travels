<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Payment - {{ $invoice->client_name ?? 'Client' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl p-8 border border-gray-200">

      {{-- Header --}}
      <div class="text-center mb-8">
        @if(isset($Settings->logo))
          <img src="{{ asset('storage/' . $Settings->logo) }}" alt="Company Logo" class="h-16 mx-auto mb-3">
        @endif
        <h1 class="text-2xl font-bold text-gray-800">Complete Your Payment</h1>
        <p class="text-gray-500 text-sm mt-1">We appreciate your trust — your payment is 100% secure.</p>
      </div>

      {{-- Invoice Summary --}}
      <div class="bg-gray-50 rounded-xl border border-gray-200 p-5 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-3">Payment Details</h2>

        <div class="space-y-1 text-sm text-gray-600">
          <p><span class="font-medium text-gray-800">Invoice Number:</span> {{ $invoice->invoice_number }}</p>
          <p><span class="font-medium text-gray-800">Client Name:</span> {{ $invoice->client_name ?? $invoice->full_name ?? 'N/A' }}</p>
          <p><span class="font-medium text-gray-800">Service:</span> {{ $invoice->description ?? 'Car Hire / Travel Service' }}</p>
        </div>

        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-100 rounded-lg flex justify-between items-center">
          <span class="text-gray-700 font-semibold">Total Amount Due:</span>
          <span class="text-xl font-bold text-green-700">Ksh {{ number_format($invoice->total_price, 2) }}</span>
        </div>
      </div>

      {{-- Friendly note --}}
      <div class="text-sm text-gray-500 mb-6 text-center">
        <p>After clicking <strong>“Make Payment”</strong>, you’ll be securely redirected to complete your transaction.
        We’ll confirm your payment instantly once it’s processed.</p>
      </div>

      {{-- CTA Button --}}
      <form action="{{ route('frontend.payment.process', $invoice->invoice_number) }}" method="POST">
        @csrf
        <input type="hidden" name="invoice_id" value="{{ $invoice->invoice_number }}">

        <button type="submit"
          class="w-full bg-yellow-500 text-white text-lg font-semibold py-3 rounded-lg shadow hover:bg-yellow-600 transition duration-200 ease-in-out">
          💳 Make Secure Payment
        </button>
      </form>

      {{-- Support footer --}}
      <div class="text-center mt-6 text-xs text-gray-400">
        <p>Need help? Contact our support team at
          <a href="mailto:{{ $Settings->email ?? 'support@example.com' }}" class="text-yellow-600 hover:underline">
            {{ $Settings->email ?? 'support@example.com' }}
          </a>
        </p>
        <p class="mt-1">Thank you for choosing {{ $Settings->name ?? 'our service' }}!</p>
      </div>

    </div>
  </div>

</body>
</html>
