@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan')

@section('content')
@php
    $order->loadMissing('items');
@endphp
<div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="animate-pop flex flex-col items-center text-center">
        <div class="flex h-20 w-20 items-center justify-center bg-ink text-paper">
            <x-icon name="check" class="h-10 w-10" />
        </div>
        <h1 class="mt-6 font-display text-3xl font-medium text-ink">Pesanan Berhasil Dibuat!</h1>
        <p class="mt-2 text-surface-600">Terima kasih, pesanan Anda sudah sampai ke kami.</p>

        <div class="mt-6 border-y border-ink px-8 py-5">
            <p class="text-label uppercase text-ink-70">Nomor Pesanan</p>
            <p class="mt-1.5 font-mono text-3xl font-medium tabular-nums text-ink">{{ $order->order_number }}</p>
        </div>

        <p class="mt-5 max-w-md text-sm text-surface-600">
            Simpan nomor pesanan di atas untuk melacak status pesanan. Kami akan menghubungi
            <span class="font-medium text-surface-800">{{ $order->customer_phone }}</span> untuk konfirmasi jadwal pengiriman.
        </p>

        <div class="mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('tracking.number', $order->order_number) }}" class="btn-primary">Lacak Pesanan</a>
            <a href="{{ route('home') }}" class="btn-outline">Kembali Beranda</a>
        </div>
    </div>

    <!-- What happens next -->
    <div class="mt-12">
        <h2 class="text-center font-display text-xl font-semibold text-surface-800">Apa yang terjadi selanjutnya?</h2>
        <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="card card-pad text-center">
                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary-600">
                    <span class="font-display text-lg font-bold">1</span>
                </div>
                <p class="mt-3 text-sm font-semibold text-surface-800">Pesanan diproses</p>
                <p class="mt-1 text-xs text-surface-500">Kami menyiapkan kue pesananmu.</p>
            </div>
            <div class="card card-pad text-center">
                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary-600">
                    <span class="font-display text-lg font-bold">2</span>
                </div>
                <p class="mt-3 text-sm font-semibold text-surface-800">Konfirmasi oleh admin</p>
                <p class="mt-1 text-xs text-surface-500">Admin mengonfirmasi jadwal pengiriman pesananmu.</p>
            </div>
            <div class="card card-pad text-center">
                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-primary/10 text-primary-600">
                    <span class="font-display text-lg font-bold">3</span>
                </div>
                <p class="mt-3 text-sm font-semibold text-surface-800">Kue sampai</p>
                <p class="mt-1 text-xs text-surface-500">Kue handmade siap diantar sesuai jadwal. Bayar tunai saat pesanan tiba.</p>
            </div>
        </div>
    </div>

    <!-- Order summary -->
    <div class="card card-pad mt-10">
        <h2 class="font-display text-lg font-semibold text-surface-800">Ringkasan Pesanan</h2>
        <div class="mt-4 divide-y divide-surface-100">
            @forelse($order->items as $item)
                <div class="flex items-center justify-between gap-4 py-3">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-surface-800">{{ $item->product_name }}</p>
                        <p class="text-xs text-surface-500">{{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <span class="shrink-0 text-sm font-semibold text-surface-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @empty
                <p class="py-3 text-sm text-surface-500">Tidak ada item.</p>
            @endforelse
        </div>
        <div class="mt-2 space-y-2 border-t border-surface-100 pt-4 text-sm">
            <div class="flex justify-between text-surface-600">
                <span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-surface-600">
                <span>Ongkir</span><span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
            </div>
            @if($order->tax > 0)
                <div class="flex justify-between text-surface-600">
                    <span>Pajak</span><span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex justify-between text-base font-bold text-surface-800">
                <span>Total</span><span class="text-primary-700">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="card card-pad mt-6">
        <h2 class="font-display text-lg font-semibold text-surface-800">Info Pembayaran</h2>
        <div class="mt-3 space-y-2 text-sm">
            <p><span class="text-surface-600">Metode:</span> <strong class="text-surface-800">Bayar Tunai (COD)</strong></p>
            <p class="text-surface-600">
                Siapkan uang tunai sebesar <strong class="text-surface-800">Rp {{ number_format($order->total, 0, ',', '.') }}</strong>
                dan bayarkan saat pesanan diantar.
            </p>
        </div>
    </div>
</div>
@endsection