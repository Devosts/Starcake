@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $statusBadges = [
        'pending' => 'badge-pending',
        'processing' => 'badge-processing',
        'completed' => 'badge-completed',
        'cancelled' => 'badge-cancelled',
    ];
@endphp
<div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold text-surface-800">Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="mt-1 text-sm text-surface-500">Lacak status pesananmu kapan saja.</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-primary">
            <x-icon name="plus" class="h-4 w-4" /> Pesan Kue
        </a>
    </div>

    <div class="mt-8 grid grid-cols-3 gap-4">
        <div class="card card-pad text-center">
            <p class="font-display text-3xl font-bold text-primary-700">{{ $stats['total'] }}</p>
            <p class="mt-0.5 text-xs font-medium text-surface-500">Total Pesanan</p>
        </div>
        <div class="card card-pad text-center">
            <p class="font-display text-3xl font-bold text-secondary-500">{{ $stats['active'] }}</p>
            <p class="mt-0.5 text-xs font-medium text-surface-500">Sedang Berjalan</p>
        </div>
        <div class="card card-pad text-center">
            <p class="font-display text-3xl font-bold text-emerald-600">{{ $stats['completed'] }}</p>
            <p class="mt-0.5 text-xs font-medium text-surface-500">Selesai</p>
        </div>
    </div>

    <div class="mt-8 space-y-4">
        @forelse($orders as $order)
            <a href="{{ route('tracking.number', $order->order_number) }}"
                class="card card-pad block transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-primary/10">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="font-mono font-semibold text-primary-700">{{ $order->order_number }}</span>
                        <span class="text-xs text-surface-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="badge {{ $statusBadges[$order->status] ?? 'badge-pending' }}">{{ ucfirst($order->status) }}</span>
                        <span class="font-display font-bold text-surface-800">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-surface-100 pt-3 text-sm">
                    @foreach($order->items as $item)
                        <span class="rounded-lg bg-surface-100/80 px-2.5 py-1 text-surface-600">
                            {{ $item->product_name }} <span class="font-semibold text-surface-800">× {{ $item->quantity }}</span>
                        </span>
                    @endforeach
                    <span class="ml-auto inline-flex items-center gap-1 text-xs font-semibold text-primary-700">
                        Lihat riwayat <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                    </span>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-state-icon"><x-icon name="cake" class="h-8 w-8" /></div>
                <p class="empty-state-title">Belum ada pesanan</p>
                <p class="empty-state-text">Yuk mulai pesan kue favoritmu sekarang!</p>
                <a href="{{ route('products.index') }}" class="btn-primary mt-2">Belanja Sekarang</a>
            </div>
        @endforelse

        @if($orders->hasPages())
            <div class="mt-6">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
@endsection