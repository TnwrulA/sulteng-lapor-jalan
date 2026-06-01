@php
    $dashboardRoute = Auth::user()->isAdmin() ? 'admin.dashboard' : 'dashboard';
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-md shadow-sm transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3 group">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-[#ff5e00] to-[#ff7e33] text-white shadow-md shadow-[#ff5e00]/15 transition-all duration-300 group-hover:scale-105 group-hover:rotate-3">
                            <x-application-logo class="h-6 w-6" />
                        </span>
                        <span class="hidden text-base font-extrabold text-[#1a1e1b] tracking-wide lg:block transition-all duration-300 group-hover:text-[#ff5e00]">Sulteng Lapor Jalan</span>
                    </a>
                </div>
 
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                        <i data-lucide="layout-dashboard" class="me-2 h-4.5 w-4.5 text-[#ff5e00]"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
 
                    @if (! Auth::user()->isAdmin())
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            <i data-lucide="file-text" class="me-2 h-4.5 w-4.5 text-[#ff5e00]"></i>
                            Laporan Saya
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                            <i data-lucide="shield-alert" class="me-2 h-4.5 w-4.5 text-[#ff5e00]"></i>
                            Kelola Laporan
                        </x-nav-link>
                    @endif
                </div>
            </div>
 
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-xl border border-gray-200/50 bg-white/40 backdrop-blur px-4 py-2 text-sm font-bold leading-4 text-gray-600 transition duration-300 hover:text-[#1a1e1b] hover:bg-white/80 focus:outline-none shadow-sm cursor-pointer active:scale-95">
                            <i data-lucide="user-circle" class="me-2 h-4.5 w-4.5 text-[#ff5e00]"></i>
                            <div>{{ Auth::user()->name }}</div>
 
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
 
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="flex items-center text-[#1a1e1b]">
                                <i data-lucide="user" class="me-2.5 h-4 w-4 text-gray-500"></i>
                                {{ __('Profil Saya') }}
                            </span>
                        </x-dropdown-link>
 
                        <hr class="border-t border-gray-100 my-1">
 
                        <!-- Authentication -->
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                            @csrf
                        </form>
 
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <span class="flex items-center text-red-600 hover:text-red-700">
                                <i data-lucide="log-out" class="me-2.5 h-4 w-4 text-red-500"></i>
                                {{ __('Log Out') }}
                            </span>
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
 
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl p-2 text-gray-500 transition hover:bg-gray-100 hover:text-[#1a1e1b] focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
 
    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white border-b border-gray-100">
            <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
                <span class="flex items-center">
                    <i data-lucide="layout-dashboard" class="me-2.5 h-4.5 w-4.5 text-[#ff5e00]"></i>
                    {{ __('Dashboard') }}
                </span>
            </x-responsive-nav-link>
 
            @if (! Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                    <span class="flex items-center">
                        <i data-lucide="file-text" class="me-2.5 h-4.5 w-4.5 text-[#ff5e00]"></i>
                        Laporan Saya
                    </span>
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('admin.reports.index')" :active="request()->routeIs('admin.reports.*')">
                    <span class="flex items-center">
                        <i data-lucide="shield-alert" class="me-2.5 h-4.5 w-4.5 text-[#ff5e00]"></i>
                        Kelola Laporan
                    </span>
                </x-responsive-nav-link>
            @endif
        </div>
 
        <!-- Responsive Settings Options -->
        <div class="border-t border-gray-100 pb-1 pt-4 bg-gray-50">
            <div class="px-4">
                <div class="text-base font-bold text-[#1a1e1b] flex items-center">
                    <i data-lucide="user" class="me-2 h-4 w-4 text-[#ff5e00]"></i>
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm font-medium text-gray-500 mt-0.5">{{ Auth::user()->email }}</div>
            </div>
 
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <span class="flex items-center text-[#1a1e1b]">
                        <i data-lucide="user-cog" class="me-2.5 h-4 w-4 text-gray-500"></i>
                        {{ __('Profil Saya') }}
                    </span>
                </x-responsive-nav-link>
 
                <!-- Authentication -->
                <form id="logout-form-mobile" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
 
                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form-mobile').submit();">
                    <span class="flex items-center text-red-600">
                        <i data-lucide="log-out" class="me-2.5 h-4 w-4 text-red-500"></i>
                        {{ __('Log Out') }}
                    </span>
                </x-responsive-nav-link>
            </div>
        </div>
    </div>
</nav>
