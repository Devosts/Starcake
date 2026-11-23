@extends('layouts.app')

@section('title', 'Tracking Pesanan')

@section('content')
@php
    $statusMeta = match($order->status ?? null) {
        'pending' => ['badge' => 'badge-pending', 'label' => 'Menunggu', 'icon' => 'clock', 'color' => 'amber'],
        'processing' => ['badge' => 'badge-processing', 'label' => 'Diproses', 'icon' => 'box', 'color' => 'blue'],
        'completed' => ['badge' => 'badge-completed', 'label' => 'Selesai', 'icon' => 'check', 'color' => 'emerald'],
        'cancelled' => ['badge' => 'badge-cancelled', 'label' => 'Dibatalkan', 'icon' => 'x', 'color' => 'rose'],
        default => ['badge' => 'badge-pending', 'label' => ucfirst($order->status ?? ''), 'icon' => 'clock', 'color' => 'amber'],
    };
    $steps = ['pending', 'processing', 'completed'];
    $stepLabels = ['Menunggu', 'Diproses', 'Selesai'];
    $stepIcons = ['clock', 'box', 'check'];
    $currentStep = $order ? (array_search($order->status, $steps) !== false ? array_search($order->status, $steps) : -1) : -1;
    $wa = $settings['whatsapp_number'] ?? '6281234567890';
@endphp

<div class="mx-auto max-w-3xl px-5 py-12 sm:px-6 lg:px-8">
    <!-- Header -->
    <h1 class="font-display text-3xl font-bold tracking-tight text-surface-800">Lacak Pesanan</h1>
    <p class="mt-2 text-sm text-surface-600">Masukkan nomor pesananmu untuk melihat status terkini.</p>

    <!-- Search Form -->
    <form method="GET" action="{{ route('tracking') }}" class="mt-8">
        <div class="card p-2">
            <div class="flex gap-2">
                <div class="relative flex-1">
                    <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-surface-400" />
                    <input type="text" name="order_number" value="{{ request('order_number') }}" required
                        placeholder="cth: STR-260809-0001"
                        class="input !border-0 !ring-0 !pl-10 !shadow-none" aria-label="Nomor pesanan" />
                </div>
                <button type="submit" class="btn-primary shrink-0">
                    Cari
                </button>
            </div>
        </div>
    </form>

    @if($order)
        <!-- Order Card -->
        <div class="card mt-8 overflow-hidden animate-slide-up">

            <!-- Order Header -->
            <div class="border-b border-surface-100 px-5 py-5 sm:px-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="font-mono text-xl font-bold text-surface-800">{{ $order->order_number }}</h2>
                        <p class="mt-0.5 text-xs text-surface-500">
                            Dipesan {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                    <span class="badge {{ $statusMeta['badge'] }} text-sm">
                        <x-icon name="{{ $statusMeta['icon'] }}" class="h-3.5 w-3.5" />
                        {{ $statusMeta['label'] }}
                    </span>
                </div>
            </div>

            <!-- Progress Stepper -->
            @if($currentStep >= 0)
                <div class="px-5 py-8 sm:px-6">
                    <ol class="flex items-center" aria-label="Progress pesanan">
                        @foreach($steps as $i => $s)
                            @php
                                $done = $i <= $currentStep;
                                $active = $i === $currentStep;
                                $isLast = $i === count($steps) - 1;
                            @endphp
                            <li class="flex flex-1 items-center {{ $isLast ? '' : '' }}">
                                <!-- Step Circle -->
                                <div class="flex flex-col items-center gap-2">
                                    <span class="flex h-11 w-11 items-center justify-center font-mono text-sm font-medium transition-colors duration-200
                                        {{ $done
                                            ? 'bg-ink text-paper'
                                            : 'border border-rule bg-transparent text-ink-40' }}
                                        {{ $active ? 'outline outline-2 outline-offset-2 outline-accent' : '' }}">
                                        @if($done && !$active)
                                            <x-icon name="check" class="h-5 w-5" />
                                        @else
                                            {{ $i + 1 }}
                                        @endif
                                    </span>
                                    <span class="text-xs font-semibold {{ $done ? 'text-surface-800' : 'text-surface-400' }}">
                                        {{ $stepLabels[$i] }}
                                    </span>
                                </div>

                                <!-- Connecting Line -->
                                @if(! $isLast)
                                    <span class="mx-2 h-0.5 flex-1 sm:mx-4 {{ $i < $currentStep ? 'bg-primary-500' : 'bg-surface-200' }} transition-colors duration-500"></span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            @endif

            <!-- Order Info Grid -->
            <div class="grid grid-cols-1 gap-px bg-surface-100 sm:grid-cols-2">
                <!-- Payment -->
                <div class="bg-white p-5 sm:p-6">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-surface-500">
                        <x-icon name="shield-check" class="h-4 w-4" />
                        Pembayaran
                    </div>
                    <p class="mt-2 font-medium text-surface-800">
                        {{ $order->payment_method === 'cod' ? 'Bayar Tunai (COD)' : ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                    </p>
                    <span class="mt-1.5 inline-block badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                        {{ $order->payment_status === 'paid' ? 'Lunas' : ($order->payment_status === 'unpaid' ? 'Belum dibayar' : 'Gagal') }}
                    </span>
                </div>

                <!-- Total -->
                <div class="bg-white p-5 sm:p-6">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-surface-500">
                        <x-icon name="box" class="h-4 w-4" />
                        Total
                    </div>
                    <p class="mt-2 font-display text-xl font-bold text-primary-700">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Schedule -->
                <div class="bg-white p-5 sm:col-span-2 sm:p-6">
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-surface-500">
                        <x-icon name="calendar" class="h-4 w-4" />
                        Jadwal
                    </div>
                    <p class="mt-2 font-medium text-surface-800">
                        {{ $order->delivery_type === 'pickup' ? 'Ambil di Toko' : 'Antar ke Tempat' }}
                        — {{ \Carbon\Carbon::parse($order->scheduled_date)->translatedFormat('d M Y') }}
                        ({{ $order->scheduled_time_slot }})
                    </p>
                    @if($order->delivery_type === 'delivery' && $order->customer_address)
                        <p class="mt-1 text-sm text-surface-500">{{ $order->customer_address }}</p>
                    @endif
                </div>
            </div>

            <!-- History Timeline -->
            <div class="border-t border-surface-100 px-5 py-6 sm:px-6">
                <h3 class="font-display text-lg font-semibold text-surface-800">Riwayat Pesanan</h3>
                @if($order->histories->isNotEmpty())
                    <ul class="mt-5 space-y-0">
                        @foreach($order->histories as $i => $h)
                            @php($isLatest = $i === 0)
                            <li class="relative flex gap-4">
                                <!-- Timeline Line & Dot -->
                                <div class="flex flex-col items-center">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center transition-colors duration-200
                                        {{ $isLatest
                                            ? 'bg-ink text-paper'
                                            : 'border border-rule bg-transparent text-ink-40' }}">
                                        <x-icon name="check" class="h-4 w-4" />
                                    </span>
                                    @if(! $loop->last)
                                        <span class="w-px flex-1 bg-rule"></span>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="flex-1 pb-6 {{ $loop->last ? 'pb-0' : '' }}">
                                    <p class="font-semibold text-surface-800">{{ $h->title }}</p>
                                    <p class="mt-0.5 text-xs text-surface-500">
                                        {{ \Carbon\Carbon::parse($h->created_at)->translatedFormat('d M Y, H:i') }}
                                    </p>
                                    @if($h->note)
                                        <p class="mt-2 rounded-xl bg-surface-50 px-3.5 py-2 text-xs leading-relaxed text-surface-600">
                                            {{ $h->note }}
                                        </p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="mt-4 flex items-center gap-3 rounded-xl bg-surface-50 p-4">
                        <x-icon name="clock" class="h-5 w-5 text-surface-400" />
                        <p class="text-sm text-surface-500">Belum ada riwayat perubahan.</p>
                    </div>
                @endif
            </div>

            <!-- WhatsApp CTA -->
            <div class="border-t border-surface-100 px-5 py-5 sm:px-6">
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $wa) }}?text=Halo, saya ingin menanyakan pesanan {{ $order->order_number }}"
                    target="_blank" rel="noopener"
                    class="btn-primary w-full justify-center">
                    <x-icon name="phone" class="h-4 w-4" />
                    Tanya via WhatsApp
                </a>
            </div>
        </div>

    @elseif($error)
        <div class="empty-state mt-10 py-16">
            <div class="empty-state-icon">
                <x-icon name="search" class="h-7 w-7" />
            </div>
            <p class="empty-state-title">Pesanan tidak ditemukan</p>
            <p class="empty-state-text">{{ $error }}</p>
            <a href="{{ route('tracking') }}" class="btn-outline mt-3">
                Coba Lagi
            </a>
        </div>
    @endif
</div>
@endsection
