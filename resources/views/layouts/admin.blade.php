<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" />
    @include('layouts.partials.fonts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="font-sans antialiased bg-surface-100 text-surface-800"
    x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar overlay (mobile) -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/50 md:hidden"></div>

        <!-- Sidebar -->
        <aside
            class="admin-sidebar fixed inset-y-0 left-0 z-50 w-72 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:flex md:flex-col"
            :class="{'translate-x-0': sidebarOpen}">

            <!-- Sidebar Logo -->
            <div class="admin-sidebar-logo">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Star Cake" class="h-11 w-11 shrink-0 object-contain" />
                    <span>
                        <span class="block font-display text-lg font-medium leading-tight text-ink">Star Cake</span>
                        <span class="block text-[10px] font-semibold uppercase tracking-widest text-ink-40">Admin Panel</span>
                    </span>
                </a>
            </div>

            <!-- Navigation -->
            @php($current = request()->path())
            <nav class="admin-sidebar-nav">
                <p class="mb-2 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="{{ str_contains($current, 'admin/dashboard') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="gauge" class="admin-nav-icon" /><span>Dashboard</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="{{ str_contains($current, 'admin/orders') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="shopping-cart" class="admin-nav-icon" /><span>Pesanan</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="{{ str_contains($current, 'admin/products') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="box" class="admin-nav-icon" /><span>Produk</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="{{ str_contains($current, 'admin/categories') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="cake" class="admin-nav-icon" /><span>Kategori</span>
                </a>

                <p class="mb-2 mt-5 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Komunikasi</p>

                <a href="{{ route('admin.chat.index') }}"
                    class="{{ str_contains($current, 'admin/pesan') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="chat" class="admin-nav-icon" /><span>Live Chat</span>
                    @if (($adminChatUnread ?? 0) > 0)
                        <span class="ml-auto flex h-5 min-w-[20px] items-center justify-center bg-accent px-1.5 font-mono text-[10px] font-medium leading-none text-ink tabular-nums">{{ $adminChatUnread }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.reviews.index') }}"
                    class="{{ str_contains($current, 'admin/reviews') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="star" class="admin-nav-icon" /><span>Ulasan</span>
                </a>

                <p class="mb-2 mt-5 px-3 text-[10px] font-bold uppercase tracking-widest text-slate-600">Sistem</p>

                <a href="{{ route('admin.settings.index') }}"
                    class="{{ str_contains($current, 'admin/settings') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="settings" class="admin-nav-icon" /><span>Pengaturan</span>
                </a>
                <a href="{{ route('admin.profile') }}"
                    class="{{ str_contains($current, 'admin/profile') ? 'admin-nav-item-active' : 'admin-nav-item' }}">
                    <x-icon name="user" class="admin-nav-icon" /><span>Profil</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="border-t border-surface-200 p-3">
                <a href="{{ route('home') }}" target="_blank" rel="noopener"
                    class="mb-1 flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-surface-500 transition-colors hover:bg-surface-100 hover:text-surface-800">
                    <x-icon name="external-link" class="h-4 w-4 shrink-0" /><span>Lihat Website</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm font-medium text-rose-600 transition-colors hover:bg-rose-50 hover:text-rose-700">
                        <x-icon name="logout" class="h-4 w-4 shrink-0" /><span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Header (Glassmorphism) -->
            <header class="admin-header" data-site-header>
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="text-surface-500 transition-colors hover:text-primary-700 md:hidden" aria-label="Buka menu">
                        <x-icon name="menu" class="h-6 w-6" />
                    </button>

                    <!-- Greeting -->
                    <div class="hidden sm:block">
                        @php($greeting = ((int) now()->format('H')) < 11 ? 'Selamat pagi' : (((int) now()->format('H')) < 17 ? 'Selamat siang' : 'Selamat malam'))
                        <span class="text-sm font-semibold text-surface-700">{{ $greeting }}, {{ auth('admin')->user()->name ?? 'Admin' }} </span>
                        <span class="text-xs text-surface-400">{{ now()->translatedFormat('l, d M Y') }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Notification Bell -->
                    <button class="relative rounded-xl p-2.5 text-surface-400 transition-colors hover:bg-surface-100 hover:text-primary-700">
                        <x-icon name="bell" class="h-5 w-5" />
                        <span class="absolute right-1.5 top-1.5 flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-rose-500"></span>
                        </span>
                    </button>

                    <!-- Divider -->
                    <div class="hidden md:block h-6 w-px bg-surface-200"></div>

                    <!-- User -->
                    <div class="flex items-center gap-3">
                        <span class="hidden text-right text-xs leading-tight md:block">
                            <span class="block font-semibold text-surface-700">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
                            <span class="text-surface-400">Administrator</span>
                        </span>
                        <span class="flex h-10 w-10 items-center justify-center border border-ink font-mono text-sm font-medium text-ink">
                            {{ mb_substr(auth('admin')->user()->name ?? 'A', 0, 1) }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-4 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                        <x-icon name="check" class="h-4 w-4 shrink-0" /> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                        <x-icon name="x" class="h-4 w-4 shrink-0" /> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
