<nav class="p-4">
    <ul class="space-y-2">

                <!-- Main Website -->
        <li>
            <a href="{{ route('home') }}" target="new"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-globe text-gold"></i> Main Website
            </a>
        </li>

        <!-- Dashboard -->
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-home text-gold"></i> Dashboard
            </a>
        </li>

        <!-- Home Page Carousel -->
        <li>
            <a href="{{ route('admin.carousel.index') ?? '#' }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-images text-gold"></i> Carousel
            </a>
        </li>


        <!-- About -->
        <li>
            <a href="{{ route('admin.about') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-info-circle text-gold"></i> About Us
            </a>
        </li>

           <!-- About -->
        <li>
            <a href="{{ route('admin.services.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-wrench text-gold"></i> Services
            </a>
        </li>

        <!-- Cars -->
        <li>
            <a href="{{ route('admin.cars.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::is('admin/cars*') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-car text-gold"></i> Cars Types
            </a>
        </li>

         <!-- Cars -->
        <li>
            <a href="{{ route('admin.fleets.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::is('admin/cars*') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-car text-gold"></i> Fleet
            </a>
        </li>


        <!-- Clients -->
        <li>
            <a href="{{ route('admin.clients.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::is('admin/clients*') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-users text-gold"></i> Clients
            </a>
        </li>

        <!-- Feedbacks -->
        <li>
            <a href="{{ route('admin.feedbacks.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-comments text-gold"></i> Client Feedbacks
            </a>
        </li>

        <!-- Blog -->
        <li>
            <a href="{{ route('admin.blogs.index') ?? '#' }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-blog text-gold"></i> Blog Posts
            </a>
        </li>

         <!-- Users -->
        <li>
            <a href="{{ route('admin.users.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::is('admin/users*') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-user-cog text-gold"></i> Users
            </a>
        </li>



        <!-- Bookings -->
        <li>
            <a href="{{ route('admin.bookings.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::is('admin/bookings*') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-calendar-check text-gold"></i> Bookings
            </a>
        </li>

        <!-- Payments Dropdown -->
        <li x-data="{ open: false }">
            <button @click="open = !open"
                    class="flex items-center justify-between w-full px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <span class="flex items-center gap-3">
                    <i class="fas fa-credit-card text-gold"></i> Payments
                </span>
                <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
            </button>
            <ul x-show="open" class="pl-8 mt-2 space-y-1" x-transition>
                <li><a href="{{ route('admin.payments.mpesa') }}" class="block px-3 py-1 text-sm hover:text-indigo-600">M-Pesa</a></li>
                <li><a href="{{ route('admin.payments.card') }}" class="block px-3 py-1 text-sm hover:text-indigo-600">Card</a></li>
            </ul>
        </li>

        <!-- Reports -->
        <li>
            <a href="{{ route('admin.reports.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::is('admin/reports*') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-chart-bar text-gold"></i> Reports
            </a>
        </li>



        <!-- KYC -->
        <li>
            <a href="{{ route('admin.kyc.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-id-card text-gold"></i> KYC
            </a>
        </li>

        <!-- Subscribers -->
        <li>
            <a href="{{ route('admin.subscribers.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-envelope-open-text text-gold"></i> Subscribers
            </a>
        </li>

        <!-- SMS -->
        <li>
            <a href="{{ route('admin.sms.index') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <i class="fas fa-sms text-gold"></i> SMS
            </a>
        </li>


        <!-- Notifications with badge -->
        <li>
            <a href="{{ route('admin.notifications.index') ?? '#' }}"
               class="flex items-center justify-between px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <span class="flex items-center gap-3">
                    <i class="fas fa-bell text-gold"></i> Notifications
                </span>
                <span class="text-xs font-semibold text-white bg-red-500 rounded-full px-2 py-0.5">
                    {{ $notificationCount ?? 1 }}
                </span>
            </a>
        </li>



        <!-- Legal Dropdown -->
        <li x-data="{ open: {{ request()->is('admin/legals*') ? 'true' : 'false' }} }">
            <button
                @click="open = !open"
                class="flex items-center justify-between w-full px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm"
            >
                <span class="flex items-center gap-3">
                    <i class="fas fa-balance-scale text-yellow-500"></i>
                    <span>Legal</span>
                </span>
                <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
            </button>

            <ul
                x-show="open"
                x-transition
                class="pl-8 mt-2 space-y-1"
            >
                <li>
                    <a href="{{ route('admin.legals.edit', 'terms') }}"
                        class="block px-3 py-1 text-sm rounded hover:text-indigo-600 {{ request()->is('admin/legals/terms*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Terms & Conditions
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.legals.edit', 'privacy') }}"
                        class="block px-3 py-1 text-sm rounded hover:text-indigo-600 {{ request()->is('admin/legals/privacy*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.legals.edit', 'booking') }}"
                        class="block px-3 py-1 text-sm rounded hover:text-indigo-600 {{ request()->is('admin/legals/booking*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Booking & Return
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.legals.edit', 'copyright') }}"
                        class="block px-3 py-1 text-sm rounded hover:text-indigo-600 {{ request()->is('admin/legals/copyright*') ? 'text-indigo-600 font-semibold' : '' }}">
                        Copyright
                    </a>
                </li>
            </ul>
        </li>


        <li>
            <a href="{{ route('admin.faq.index') ?? '#' }}"
               class="flex items-center justify-between px-3 py-2 rounded-md border border-gray-200 transition hover:bg-gray-100 hover:shadow-sm">
                <span class="flex items-center gap-3">
                    <i class="fas fa-question text-gold"></i> FAQs
                </span>

            </a>
        </li>

        <!-- Settings -->
        <li>
            <a href="{{ route('admin.settings') ?? '#' }}"
               class="flex items-center gap-3 px-3 py-2 rounded-md border transition hover:bg-gray-100 hover:shadow-sm {{ Request::routeIs('admin.settings') ? 'bg-gray-100 font-semibold border-indigo-500' : 'border-gray-200' }}">
                <i class="fas fa-cog text-gold"></i> Settings
            </a>
        </li>

        <!-- Logout -->
        <li>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-3 w-full text-left px-3 py-2 rounded-md border border-red-300 text-red-600 transition hover:bg-red-50 hover:shadow-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</nav>
