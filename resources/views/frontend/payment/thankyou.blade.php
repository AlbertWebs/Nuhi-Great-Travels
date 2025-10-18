<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Thank You - Payment Successful</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen text-gray-800">
  <div class="bg-white rounded-xl shadow-lg p-8 max-w-lg text-center">
    <div class="text-green-600 text-5xl mb-4">✅</div>
    <h1 class="text-2xl font-bold mb-2">Payment Successful</h1>
    <p class="text-gray-600 mb-6">Thank you for your payment. We’ve received it successfully and will process your booking shortly.</p>
    <a href="{{ url('/') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-semibold">Return to Home</a>
  </div>
</body>
</html>
