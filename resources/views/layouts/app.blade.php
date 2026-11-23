<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Star Cake') }}@hasSection('title') - @yield('title') @endif</title>

    @php
        $settings = $settings ?? [];
    @endphp

    @php
        $favicon = $settings['favicon'] ?? null;
        $faviconUrl = $favicon
            ? (str_starts_with($favicon, 'http') ? $favicon : (str_starts_with($favicon, 'images/') ? asset($favicon) : asset('storage/' . $favicon)))
            : asset('images/logo.png');
    @endphp
    <link rel="icon" href="{{ $faviconUrl }}" />

    @include('layouts.partials.fonts')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>

<body class="bg-paper font-sans text-ink antialiased">
    <div x-data="{ open: false, searchOpen: false }" class="flex min-h-screen flex-col">

        {{-- Utility strip. Removed by app.js once dismissed (cookie, 24h). --}}
        <div class="announcement-bar">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 sm:px-6 lg:px-8">
                <p class="flex min-w-0 items-center gap-2 truncate">
                    <span>Gratis antar Kota Bekasi</span>
                    <span class="hidden text-paper/50 sm:inline">Khusus area Kota Bekasi</span>
                </p>
                <button type="button" data-dismiss
                    class="-mr-1 shrink-0 p-1 text-paper/60 transition-colors hover:text-paper"
                    aria-label="Tutup pengumuman">
                    <x-icon name="x" class="h-3.5 w-3.5" />
                </button>
            </div>
        </div>

        {{-- Masthead --}}
        <header data-site-header class="site-header">
            <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
                <div class="masthead h-20 justify-between">

                    {{-- Nameplate --}}
                    <a href="{{ route('home') }}" class="masthead shrink-0">
                        <img src="{{ asset('images/logo.png') }}" alt="Star Cake" class="h-14 w-14 shrink-0 object-contain" />
                        <span class="wordmark">{{ config('app.name', 'Star Cake') }}</span>
                        <span class="wordmark-sub hidden lg:block">Kue Handmade<br />Sejak 2019</span>
                    </a>

                    {{-- Desktop index --}}
                    <nav class="hidden items-center gap-8 md:flex">
                        <a href="{{ route('home') }}"
                            class="{{ request()->routeIs('home') ? 'nav-link-active' : 'nav-link' }}">Beranda</a>
                        <a href="{{ route('products.index') }}"
                            class="{{ request()->is('menu', 'kategori/*', 'produk/*') ? 'nav-link-active' : 'nav-link' }}">Menu</a>
                        <a href="{{ route('about') }}"
                            class="{{ request()->is('tentang') ? 'nav-link-active' : 'nav-link' }}">Tentang</a>
                        <a href="{{ route('tracking') }}"
                            class="{{ request()->is('tracking*') ? 'nav-link-active' : 'nav-link' }}">Lacak</a>
                        <a href="{{ route('contact') }}"
                            class="{{ request()->is('kontak') ? 'nav-link-active' : 'nav-link' }}">Kontak</a>
                    </nav>

                    {{-- Utility cluster --}}
                    <div class="flex shrink-0 items-center gap-1">

                        <button type="button" @click="searchOpen = !searchOpen" :aria-expanded="searchOpen"
                            class="btn-icon-sm" aria-label="Cari">
                            <x-icon name="search" class="h-5 w-5" />
                        </button>

                        <a href="{{ route('cart') }}" class="btn-icon-sm relative" aria-label="Keranjang">
                            <x-icon name="cart" class="h-5 w-5" />
                            @if (($cartCount ?? 0) > 0)
                                <span
                                    class="absolute -right-1 -top-1 flex h-4 min-w-[16px] items-center justify-center bg-accent px-1 font-mono text-[10px] font-medium leading-none text-ink tabular-nums">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        @auth
                            <div class="relative" x-data="{ open: false }">
                                <button type="button" @click="open = !open" :aria-expanded="open"
                                    class="flex items-center gap-2 py-1 pl-2 pr-1 text-ink-70 transition-colors hover:text-ink">
                                    <span class="hidden text-label uppercase tracking-[0.12em] sm:inline">
                                        {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}
                                    </span>
                                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/logo.png') }}"
                                        alt="{{ auth()->user()->name }}"
                                        class="h-8 w-8 object-cover" />
                                </button>

                                <div x-show="open" x-cloak @click.outside="open = false"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="absolute right-0 z-50 mt-2 w-56 border border-ink bg-paper-warm shadow-hard">
                                    <div class="colophon-rule border-t-0 pt-0">
                                        <p class="truncate px-4 pb-3 text-label uppercase text-ink-40">
                                            {{ auth()->user()->name }}
                                        </p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="colophon-link border-t border-rule px-4">
                                        <span class="flex items-center gap-2.5">
                                            <x-icon name="user" class="h-4 w-4" /> Profil
                                        </span>
                                    </a>
                                    <a href="{{ route('tracking') }}" class="colophon-link border-t border-rule px-4">
                                        <span class="flex items-center gap-2.5">
                                            <x-icon name="box" class="h-4 w-4" /> Riwayat Pesanan
                                        </span>
                                    </a>
                                    <a href="{{ route('contact') }}#chat" class="colophon-link border-t border-rule px-4">
                                        <span class="flex items-center gap-2.5">
                                            <x-icon name="chat" class="h-4 w-4" /> Pesan
                                            @if (($chatUnread ?? 0) > 0)
                                                <span class="ml-auto flex h-4 min-w-[16px] items-center justify-center bg-accent px-1 font-mono text-[10px] font-medium leading-none text-ink tabular-nums">{{ $chatUnread }}</span>
                                            @endif
                                        </span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="border-t border-rule">
                                        @csrf
                                        <button type="submit"
                                            class="colophon-link flex w-full items-center gap-2.5 px-4 text-left hover:text-accent">
                                            <x-icon name="logout" class="h-4 w-4" /> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="btn-ghost hidden sm:inline-flex">Masuk</a>
                            <a href="{{ route('register') }}" class="btn-primary-sm ml-1">Daftar</a>
                        @endauth

                        <button type="button" @click="open = !open" :aria-expanded="open"
                            class="btn-icon-sm md:hidden" aria-label="Menu">
                            <x-icon x-show="!open" name="menu" class="h-5 w-5" />
                            <x-icon x-show="open" name="x" class="h-5 w-5" />
                        </button>
                    </div>
                </div>
            </div>
        </header>

        {{-- Search band: slides under the masthead --}}
        <div x-show="searchOpen" x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @keydown.escape.window="searchOpen = false"
            class="search-band">
            <form action="{{ route('products.index') }}" method="GET"
                class="mx-auto flex max-w-7xl items-center gap-3 px-5 py-4 sm:px-6 lg:px-8">
                <div class="relative flex-1">
                    <x-icon name="search" class="pointer-events-none absolute left-0 top-1/2 h-5 w-5 -translate-y-1/2 text-ink-40" />
                    <input type="text" name="search" placeholder="Cari kue favoritmu..."
                        class="input input-lg !border-0 !border-b !border-b-ink !bg-transparent !pl-8 !px-0"
                        autofocus />
                </div>
                <button type="submit" class="btn-primary shrink-0">Cari</button>
                <button type="button" @click="searchOpen = false" class="btn-ghost shrink-0">Tutup</button>
            </form>
        </div>

        {{-- Mobile index --}}
        <div x-show="open" x-cloak
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="border-b border-ink bg-paper-warm md:hidden">
            <nav class="mx-auto max-w-7xl px-5 sm:px-6">
                <a href="{{ route('home') }}" @click="open = false"
                    class="{{ request()->routeIs('home') ? 'mobile-nav-active' : 'mobile-nav' }}">Beranda</a>
                <a href="{{ route('products.index') }}" @click="open = false"
                    class="{{ request()->is('menu', 'kategori/*', 'produk/*') ? 'mobile-nav-active' : 'mobile-nav' }}">Menu</a>
                <a href="{{ route('about') }}" @click="open = false"
                    class="{{ request()->is('tentang') ? 'mobile-nav-active' : 'mobile-nav' }}">Tentang</a>
                <a href="{{ route('tracking') }}" @click="open = false"
                    class="{{ request()->is('tracking*') ? 'mobile-nav-active' : 'mobile-nav' }}">Lacak Pesanan</a>
                <a href="{{ route('contact') }}" @click="open = false"
                    class="{{ request()->is('kontak') ? 'mobile-nav-active' : 'mobile-nav' }}">Kontak</a>
                @auth
                    <a href="{{ route('contact') }}#chat" @click="open = false" class="mobile-nav">
                        <span class="flex items-center gap-2">
                            Chat
                            @if (($chatUnread ?? 0) > 0)
                                <span class="flex h-4 min-w-[16px] items-center justify-center bg-accent px-1 font-mono text-[10px] font-medium leading-none text-ink tabular-nums">{{ $chatUnread }}</span>
                            @endif
                        </span>
                    </a>
                @endauth
                @guest
                    <div class="flex gap-2 py-4">
                        <a href="{{ route('login') }}" @click="open = false" class="btn-outline flex-1">Masuk</a>
                        <a href="{{ route('register') }}" @click="open = false" class="btn-primary flex-1">Daftar</a>
                    </div>
                @endguest
            </nav>
        </div>

        {{-- Page --}}
        <main class="flex-grow">
            @yield('content')
        </main>

        {{-- Colophon --}}
        @include('layouts.footer')
    </div>

    @auth
        <a href="{{ route('contact') }}#chat" class="chat-fab" aria-label="Buka live chat">
            <x-icon name="chat" class="h-5 w-5" />
            @if (($chatUnread ?? 0) > 0)
                <span class="chat-fab-badge">{{ $chatUnread }}</span>
            @endif
        </a>
    @endauth

    @stack('scripts')
</body>

</html>