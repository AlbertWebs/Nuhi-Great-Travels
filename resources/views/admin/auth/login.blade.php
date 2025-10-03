<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-md mx-auto">
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-xl font-semibold mb-4">Admin Login</h2>

      <form method="POST" action="{{ route('admin.login.attempt') }}">
        @csrf

        <div class="mb-3">
          <label class="block text-sm">Email</label>
          <input type="email" name="email" required class="w-full border rounded px-3 py-2" />
        </div>

        <div class="mb-3">
          <label class="block text-sm">Password</label>
          <input type="password" name="password" required class="w-full border rounded px-3 py-2" />
        </div>

        @if($errors->any())
          <div class="text-sm text-red-600 mb-3">{{ $errors->first() }}</div>
        @endif

        <div class="flex items-center justify-between">
          <button class="px-4 py-2 bg-blue-600 text-white rounded">Login</button>
          <a href="{{ route('login') }}" class="text-sm text-gray-500">Client login</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
