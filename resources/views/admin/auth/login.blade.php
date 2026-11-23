@extends('layouts.admin-auth')

@section('title', 'Login Admin')

@section('content')
<div class="flex min-h-screen">
    <!-- Left Panel — Decorative (show on md+) -->
    <div class="hidden md:flex md:w-1/2 admin-login-left">
        <!-- Decorative circles -->
        <div class="admin-login-decorative animate-float" style="width: 300px; height: 300px; top: -50px; left: -80px;">
            <div class="admin-login-decorative-circle h-full w-full"></div>
        </div>
        <div class="admin-login-decorative animate-float-delayed" style="width: 200px; height: 200px; bottom: 10%; right: -40px;">
            <div class="admin-login-decorative-circle h-full w-full"></div>
        </div>
        <div class="admin-login-decorative animate-float" style="width: 120px; height: 120px; top: 30%; right: 15%;">
            <div class="admin-login-decorative-circle h-full w-full"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 mx-auto max-w-md px-8 text-center">
            <span class="inline-flex h-24 w-24 items-center justify-center rounded-3xl bg-white p-2 shadow-2xl animate-glow">
                <img src="{{ asset('images/logo.png') }}" alt="Star Cake" class="h-full w-full object-contain" />
            </span>
            <h1 class="mt-6 font-display text-3xl font-bold text-white">Star Cake</h1>
            <p class="mt-2 text-sm font-medium uppercase tracking-widest text-primary-300">Admin Panel</p>
            <p class="mt-6 text-base leading-relaxed text-white/70">
                Kelola produk, pesanan, dan pelanggan dalam satu dashboard yang mudah digunakan.
            </p>

            <div class="mt-10 flex items-center justify-center gap-6 text-xs text-white/50">
                <span class="flex items-center gap-1.5">
                    <x-icon name="check" class="h-4 w-4 text-primary-400" /> Kelola Produk
                </span>
                <span class="flex items-center gap-1.5">
                    <x-icon name="check" class="h-4 w-4 text-primary-400" /> Pantau Pesanan
                </span>
                <span class="flex items-center gap-1.5">
                    <x-icon name="check" class="h-4 w-4 text-primary-400" /> Analitik
                </span>
            </div>
        </div>
    </div>

    <!-- Right Panel — Login Form -->
    <div class="flex w-full items-center justify-center px-4 py-12 md:w-1/2">
        <div class="w-full max-w-md animate-slide-up">
            <!-- Mobile branding (hidden on desktop) -->
            <div class="mb-8 text-center md:hidden">
                <img src="{{ asset('images/logo.png') }}" alt="Star Cake" class="mx-auto h-16 w-16 object-contain" />
                <h1 class="mt-3 font-display text-xl font-bold text-surface-800">Star Cake</h1>
                <p class="mt-1 text-sm font-medium uppercase tracking-widest text-primary-600">Admin Panel</p>
                <p class="mt-3 text-sm text-surface-500">Kelola produk, pesanan, dan pelanggan</p>
            </div>

            <!-- Welcome text -->
            <div class="mb-8">
                <h2 class="font-display text-2xl font-bold text-surface-800">Selamat Datang Kembali</h2>
                <p class="mt-1.5 text-sm text-surface-500">Masuk ke dashboard admin untuk mengelola bisnismu.</p>
            </div>

            <!-- Form Card -->
            <div class="rounded-2xl border border-surface-200 bg-white p-6 shadow-xl shadow-surface-300/20 sm:p-8">
                @if($errors->any())
                    <div class="mb-5 flex items-center gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-800">
                        <x-icon name="x" class="h-4 w-4 shrink-0" /> {{ $errors->first('email') ?: 'Email atau password salah.' }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" class="space-y-5" x-data="{ show: false }">
                    @csrf
                    <div>
                        <label class="label" for="admin_email">Email</label>
                        <div class="relative">
                            <x-icon name="mail" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-surface-400" />
                            <input id="admin_email" type="email" name="email" value="{{ old('email', 'admin@starcake.com') }}" required autofocus autocomplete="username" class="input pl-10" placeholder="admin@starcake.com" />
                        </div>
                    </div>
                    <div>
                        <label class="label" for="admin_password">Password</label>
                        <div class="relative">
                            <x-icon name="lock" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-surface-400" />
                            <input id="admin_password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Masukkan password" class="input pl-10 pr-11" />
                            <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                                <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                                <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex cursor-pointer items-center gap-2 text-sm text-surface-600">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500" />
                            Ingat saya
                        </label>
                    </div>

                    <button type="submit" class="btn-primary w-full !py-3">
                        <x-icon name="logout" class="h-4 w-4 rotate-180" /> Masuk ke Dashboard
                    </button>
                </form>
            </div>

            <!-- Back link -->
            <p class="mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-surface-500 transition-colors hover:text-primary-700">
                    <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke website
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
