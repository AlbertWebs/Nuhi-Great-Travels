<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Admin Panel')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<?php $Settings = DB::table('settings')->first(); ?>
<body class="min-h-screen bg-gray-100">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside x-data="{ open: true }" class="bg-white w-64 border-r hidden lg:block shadow-md">
      <div class="p-4 border-b">
        <div class="bg-black px-2 py-2 rounded">
        <img src="{{ asset('storage/'.$Settings->logo) }}" alt="Logo" class="h-10 w-auto mx-auto mb-4">
        </div>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
          <div class="text-2xl font-bold text-gold">Nuhi Great Travels</div>
        </a>
      </div>

      @include('admin.sidebar')

    </aside>

    <!-- Main content -->
    <main class="flex-1 overflow-auto">
      <div class="p-6">
        {{--  --}}
        <header class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>

            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none">
                <span class="text-sm text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false"
                x-transition
                class="absolute right-0 mt-2 w-52 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-50">

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.305.49 6.121 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Profile
                </a>

                <a href="{{ route('admin.settings') ?? '#' }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.983 2.132a1 1 0 011.034 0l2.517 1.452 2.347-.546a1 1 0 01.992.272l1.624 1.624a1 1 0 01.272.992l-.546 2.347 1.452 2.517a1 1 0 010 1.034l-1.452 2.517.546 2.347a1 1 0 01-.272.992l-1.624 1.624a1 1 0 01-.992.272l-2.347-.546-2.517 1.452a1 1 0 01-1.034 0l-2.517-1.452-2.347.546a1 1 0 01-.992-.272l-1.624-1.624a1 1 0 01-.272-.992l.546-2.347-1.452-2.517a1 1 0 010-1.034l1.452-2.517-.546-2.347a1 1 0 01.272-.992l1.624-1.624a1 1 0 01.992-.272l2.347.546 2.517-1.452z"/>
                    </svg>
                    Settings
                </a>

                <a href="{{ route('admin.users.index') ?? '#' }}"
                    class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5V4H2v16h5m10-6a3 3 0 100-6 3 3 0 000 6zm-6 0a3 3 0 100-6 3 3 0 000 6z"/>
                    </svg>
                    Users
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m0-10V5a2 2 0 114 0v1"/>
                    </svg>
                    Logout
                    </button>
                </form>
                </div>
            </div>
        </header>
        {{--  --}}


        <section>
          @yield('content')
        </section>
      </div>
    </main>
  </div>

  <!-- Minimal Alpine toggle for smaller screens -->
  <script src="https://unpkg.com/alpinejs@3" defer></script>
</body>
</html>
