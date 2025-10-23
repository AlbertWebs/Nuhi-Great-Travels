<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{Auth::User()->name}} - Dashboard - Nuhi Great Travels</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Tailwind & App Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
  <link rel="manifest" href="{{asset('favicon//site.webmanifest')}}">
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
<?php $Settings = \App\Models\Setting::first(); ?>
  <!-- Navigation -->
  <nav class="bg-white border-b border-gray-200 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <!-- Logo -->
        <a href="{{ url('/dashboard') }}" class="text-xl font-bold text-yellow-600 hover:text-yellow-700 transition">
        <img style="width:100px; object-fit:cover;" src="{{ asset('storage/'.$Settings->logo) }}" alt="">
        </a>

        <!-- Desktop Links -->
        <div class="hidden sm:flex items-center space-x-6">
          <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-yellow-600 transition">Dashboard</a>
          <a href="{{ route('tasks.index') }}" class="text-gray-700 hover:text-yellow-600 transition">Tasks</a>
          <a href="{{ route('leads.index') }}" class="text-gray-700 hover:text-yellow-600 transition">Leads</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-gray-700 hover:text-red-500 transition">Logout</button>
          </form>
        </div>

        <!-- Mobile Menu Button -->
        <div class="sm:hidden">
          <button id="mobileMenuBtn" class="text-gray-700 hover:text-yellow-600 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div id="mobileMenu" class="hidden sm:hidden mt-2 space-y-2 pb-2">
        <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-yellow-600 transition px-2 py-1">Dashboard</a>
        <a href="{{ route('tasks.index') }}" class="block text-gray-700 hover:text-yellow-600 transition px-2 py-1">Tasks</a>
        <a href="{{ route('leads.index') }}" class="block text-gray-700 hover:text-yellow-600 transition px-2 py-1">Leads</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full text-left px-2 py-1 text-gray-700 hover:text-red-500 transition">Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <!-- Page Heading -->
  @hasSection('header')
    <header class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-semibold text-yellow-600">@yield('header')</h1>
      </div>
    </header>
  @endif

  <!-- Main Content -->
  <main class="flex-1 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      @yield('content')
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-gray-200 text-center py-6 mt-auto shadow-inner">
    <p class="text-gray-500 text-sm">© {{ date('Y') }} Nuhi Great Travels Limited. All rights reserved.</p>
  </footer>

  <!-- Page Scripts -->
  @yield('scripts')

  <script>
    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn?.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</body>
</html>
