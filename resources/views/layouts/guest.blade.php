<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Star Cake') }}@hasSection('title') - @yield('title') @endif</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" />
    @include('layouts.partials.fonts')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body class="min-h-screen bg-paper font-sans antialiased text-ink">
    <div class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="animate-pop flex items-center gap-2.5">
            <img src="{{ asset('images/logo.png') }}" alt="Star Cake" class="h-11 w-auto" />
            <span class="font-display text-2xl text-primary-700">Star Cake</span>
        </a>

        <div class="animate-slide-up mt-8 w-full max-w-md rounded-2xl border border-surface-200 bg-white p-6 shadow-xl shadow-surface-300/30 sm:p-8">
            {{ $slot ?? '' }}
            @yield('content')
        </div>

        <p class="mt-8 text-center text-xs text-surface-500">
            &copy; {{ date('Y') }} Star Cake — Kue Enak, Hati Senang.
        </p>
    </div>
</body>

</html>