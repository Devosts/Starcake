@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-8 text-center">
        <h1 class="font-display text-3xl font-bold text-surface-800">Hubungi Kami</h1>
        <p class="mt-2 text-surface-600">Punya pertanyaan? Butuh kue khusus? Tim Star Cake siap membantumu.</p>
    </div>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        {{-- Kolom kiri: info kontak + form pesan --}}
        <div class="space-y-8">
            <div class="space-y-4">
                @php
                    $wa = $settings['whatsapp_number'] ?? '6281234567890';
                    $phone = preg_replace('/^0/', '62', $wa);
                @endphp
                <a href="https://wa.me/{{ $phone }}" target="_blank" rel="noopener"
                    class="group flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-surface-200/60 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-primary/30">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary-600 transition-colors group-hover:bg-primary-600 group-hover:text-white">
                        <x-icon name="phone" class="h-5 w-5" />
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-surface-800">WhatsApp</span>
                        <span class="block truncate text-sm text-surface-500">{{ $settings['whatsapp_number'] ?? '6281234567890' }}</span>
                    </span>
                    <x-icon name="external-link" class="ml-auto h-4 w-4 shrink-0 text-surface-300 transition-colors group-hover:text-primary-600" />
                </a>

                <a href="mailto:{{ $settings['email'] ?? 'order@starcake.com' }}"
                    class="group flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-surface-200/60 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-primary/30">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary-600 transition-colors group-hover:bg-primary-600 group-hover:text-white">
                        <x-icon name="mail" class="h-5 w-5" />
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-surface-800">Email</span>
                        <span class="block truncate text-sm text-surface-500">{{ $settings['email'] ?? 'order@starcake.com' }}</span>
                    </span>
                    <x-icon name="external-link" class="ml-auto h-4 w-4 shrink-0 text-surface-300 transition-colors group-hover:text-primary-600" />
                </a>

                <div class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-surface-200/60">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary-600">
                        <x-icon name="location" class="h-5 w-5" />
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-surface-800">Alamat</span>
                        <span class="block text-sm text-surface-500">{{ $settings['address'] ?? 'Jl. Kue Indah No. 1, Jakarta 10340' }}</span>
                    </span>
                </div>

                <div class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-surface-200/60">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary-600">
                        <x-icon name="clock" class="h-5 w-5" />
                    </span>
                    <span class="min-w-0">
                        <span class="block text-sm font-semibold text-surface-800">Jam Operasional</span>
                        <span class="block text-sm text-surface-500">{{ $settings['operating_hours'] ?? 'Senin–Minggu, 08.00 – 20.00' }}</span>
                    </span>
                </div>
            </div>
        </div>

        {{-- Kolom kanan: live chat --}}
        <div class="lg:sticky lg:top-24 lg:self-start">
            @auth
                @php
                    $seed = $chatMessages->map->toBroadcastArray()->all();
                @endphp
                <x-chat-widget
                    :channel="'conversation.' . $conversation->id"
                    my-role="user"
                    :send-url="route('chat.send')"
                    :read-url="route('chat.read')"
                    :seed="$seed"
                    title="Live Chat"
                    hint="Tulis pesanmu — tim Star Cake akan membalas secepatnya."
                />
            @else
                <div class="chat-panel">
                    <div class="chat-head">
                        <div class="flex min-w-0 items-center gap-2.5">
                            <span class="chat-dot chat-dot-off"></span>
                            <span class="truncate font-display text-base font-semibold text-ink">Live Chat</span>
                        </div>
                    </div>
                    <div class="chat-guest">
                        <p class="chat-empty">Masuk ke akun Star Cake untuk mulai mengobrol dengan tim kami.</p>
                        <div class="flex gap-2">
                            <a href="{{ route('login') }}" class="btn-primary flex-1 justify-center">Masuk</a>
                            <a href="{{ route('register') }}" class="btn-outline flex-1 justify-center">Daftar</a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
