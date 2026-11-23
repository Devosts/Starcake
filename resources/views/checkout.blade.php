@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
@php
    $freeThreshold = (float) ($settings['free_delivery_min'] ?? 150000);
    $tax = $tax ?? 0;
    $total = $cartTotal + $deliveryFee + $tax;
    $timeSlots = ['09.00-12.00', '13.00-16.00', '16.00-19.00'];
@endphp

@if(empty($cart))
    <div class="empty-state mx-auto my-20 max-w-md py-24">
        <div class="empty-state-icon"><x-icon name="cart" class="h-8 w-8" /></div>
        <p class="empty-state-title">Keranjangmu kosong</p>
        <p class="empty-state-text">Tambahkan kue dulu sebelum checkout ya.</p>
        <a href="{{ route('products.index') }}" class="btn-primary mt-3">
            <x-icon name="shopping-cart" class="h-4 w-4" />
            Belanja Sekarang
        </a>
    </div>
@else
<div class="mx-auto max-w-6xl px-5 py-10 sm:px-6 lg:px-8"
    x-data="{ submitting: false }"
    x-on:pageshow.window="submitting = false">

    <!-- Header -->
    <h1 class="font-display text-3xl font-bold tracking-tight text-surface-800">Checkout</h1>
    <p class="mt-1 text-sm text-surface-500">Lengkapi data pengiriman. Pembayaran dilakukan tunai saat pesanan diantar.</p>

    <!-- Step Progress -->
    <div class="mt-8 mb-10 hidden sm:block">
        <div class="flex items-center">
            <div class="step-item flex-1">
                <div class="step-circle done"><x-icon name="check" class="h-5 w-5" /></div>
                <span class="step-label done">Keranjang</span>
            </div>
            <div class="step-line done"></div>
            <div class="step-item flex-1">
                <div class="step-circle active">2</div>
                <span class="step-label active">Checkout</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item flex-1">
                <div class="step-circle">3</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 p-4">
            <x-icon name="shield-check" class="mt-0.5 h-5 w-5 shrink-0 text-rose-500" />
            <div>
                <p class="text-sm font-semibold text-rose-800">Ada yang perlu diperbaiki:</p>
                <ul class="mt-1.5 list-inside list-disc space-y-0.5 text-sm text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Form -->
        <div class="lg:col-span-2">
            <form id="checkout-form" method="POST" action="{{ route('checkout') }}" class="space-y-5"
                @submit="submitting = true">
                @csrf

                <!-- Customer Details -->
                <div class="card overflow-hidden" x-data="{ open: true }">
                    <button type="button" @click="open = !open"
                        class="flex w-full items-center justify-between px-5 py-4 sm:px-6 transition-colors hover:bg-surface-50">
                        <h2 class="flex items-center gap-3 font-display text-lg font-semibold text-surface-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary-600">
                                <x-icon name="user" class="h-4 w-4" />
                            </span>
                            Detail Pelanggan
                        </h2>
                        <span class="h-5 w-5 text-surface-400 transition-transform duration-300" x-bind:class="{ 'rotate-180': !open }"><x-icon name="chevron-down" /></span>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms>
                        <div class="border-t border-surface-100 px-5 py-5 sm:px-6">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="label" for="customer_name">Nama Lengkap *</label>
                                    <input id="customer_name" type="text" name="customer_name" required
                                        value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                                        class="input {{ $errors->has('customer_name') ? 'input-error' : '' }}" />
                                    @error('customer_name')<p class="field-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="label" for="customer_email">Email *</label>
                                    <input id="customer_email" type="email" name="customer_email" required
                                        value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                                        class="input {{ $errors->has('customer_email') ? 'input-error' : '' }}" />
                                    @error('customer_email')<p class="field-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="label" for="customer_phone">No. WhatsApp/Telepon *</label>
                                    <input id="customer_phone" type="tel" name="customer_phone" required
                                        value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                                        class="input {{ $errors->has('customer_phone') ? 'input-error' : '' }}" />
                                    @error('customer_phone')<p class="field-error">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="label" for="customer_address">Alamat Lengkap *</label>
                                    <textarea id="customer_address" name="customer_address" required rows="3"
                                        class="input resize-y {{ $errors->has('customer_address') ? 'input-error' : '' }}">{{ old('customer_address', auth()->user()->address ?? '') }}</textarea>
                                    @error('customer_address')<p class="field-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery -->
                <div class="card overflow-hidden" x-data="{ open: true }">
                    <button type="button" @click="open = !open"
                        class="flex w-full items-center justify-between px-5 py-4 sm:px-6 transition-colors hover:bg-surface-50">
                        <h2 class="flex items-center gap-3 font-display text-lg font-semibold text-surface-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary-600">
                                <x-icon name="location" class="h-4 w-4" />
                            </span>
                            Pengiriman
                        </h2>
                        <span class="h-5 w-5 text-surface-400 transition-transform duration-300" x-bind:class="{ 'rotate-180': !open }"><x-icon name="chevron-down" /></span>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms>
                        <div class="border-t border-surface-100 px-5 py-5 sm:px-6">
                            <div class="flex items-start gap-3 rounded-2xl border-2 border-primary-500 bg-primary-50/60 p-4 shadow-sm">
                                <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-primary-100 text-primary-700">
                                    <x-icon name="location" class="h-4 w-4" />
                                </span>
                                <span class="flex-1">
                                    <span class="flex items-center justify-between gap-2">
                                        <span class="font-semibold text-surface-800">Antar ke Tempat</span>
                                        <span class="text-sm font-bold {{ $deliveryFee > 0 ? 'text-primary-700' : 'text-emerald-600' }}">
                                            {{ $deliveryFee > 0 ? 'Rp ' . number_format($deliveryFee, 0, ',', '.') : 'Gratis' }}
                                        </span>
                                    </span>
                                    <span class="mt-0.5 block text-sm text-surface-500">
                                        @if($deliveryFee > 0)
                                            Khusus area Kota Bekasi. Ongkir dihitung dari total belanja. Gratis ongkir mulai Rp {{ number_format($freeThreshold, 0, ',', '.') }}.
                                        @else
                                            Gratis ongkir (khusus area Kota Bekasi) karena total belanja minimal Rp {{ number_format($freeThreshold, 0, ',', '.') }} tercapai.
                                        @endif
                                    </span>
                                </span>
                            </div>
                            <input type="hidden" name="delivery_type" value="delivery">
                        </div>
                    </div>
                </div>

                <!-- Schedule -->
                <div class="card overflow-hidden" x-data="{ open: true }">
                    <button type="button" @click="open = !open"
                        class="flex w-full items-center justify-between px-5 py-4 sm:px-6 transition-colors hover:bg-surface-50">
                        <h2 class="flex items-center gap-3 font-display text-lg font-semibold text-surface-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary-600">
                                <x-icon name="calendar" class="h-4 w-4" />
                            </span>
                            Jadwal Pengiriman
                        </h2>
                        <span class="h-5 w-5 text-surface-400 transition-transform duration-300" x-bind:class="{ 'rotate-180': !open }"><x-icon name="chevron-down" /></span>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms>
                        <div class="border-t border-surface-100 px-5 py-5 sm:px-6">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="label" for="scheduled_date">Tanggal *</label>
                                    <input id="scheduled_date" type="date" name="scheduled_date" required
                                        min="{{ date('Y-m-d') }}" value="{{ old('scheduled_date') }}" class="input" />
                                    @error('scheduled_date')<p class="field-error">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="label" for="scheduled_time_slot">Jam *</label>
                                    <select id="scheduled_time_slot" name="scheduled_time_slot" required class="input cursor-pointer">
                                        <option value="">Pilih jam</option>
                                        @foreach($timeSlots as $slot)
                                            <option value="{{ $slot }}" {{ old('scheduled_time_slot') == $slot ? 'selected' : '' }}>{{ $slot }}</option>
                                        @endforeach
                                    </select>
                                    @error('scheduled_time_slot')<p class="field-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment -->
                <div class="card overflow-hidden" x-data="{ open: true }">
                    <button type="button" @click="open = !open"
                        class="flex w-full items-center justify-between px-5 py-4 sm:px-6 transition-colors hover:bg-surface-50">
                        <h2 class="flex items-center gap-3 font-display text-lg font-semibold text-surface-800">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-primary-600">
                                <x-icon name="shield-check" class="h-4 w-4" />
                            </span>
                            Metode Pembayaran
                        </h2>
                        <span class="h-5 w-5 text-surface-400 transition-transform duration-300" x-bind:class="{ 'rotate-180': !open }"><x-icon name="chevron-down" /></span>
                    </button>
                    <div x-show="open" x-collapse.duration.300ms>
                        <div class="border-t border-surface-100 px-5 py-5 sm:px-6">
                            <p class="mb-3 text-sm text-surface-500">Saat ini kami hanya menerima pembayaran tunai.</p>
                            <label class="flex cursor-pointer items-start gap-3 rounded-2xl border-2 border-primary-500 bg-primary-50/60 p-4 shadow-sm">
                                <input type="radio" name="payment_method" value="cod" checked required
                                    class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 focus:ring-offset-0">
                                <span class="flex-1">
                                    <span class="flex items-center justify-between gap-2">
                                        <span class="font-semibold text-surface-800">Bayar Tunai (COD)</span>
                                        <x-icon name="check" class="h-5 w-5 text-primary-600" />
                                    </span>
                                    <span class="mt-0.5 block text-sm text-surface-500">
                                        Siapkan uang tunai sebesar total pesanan dan bayar saat pesanan diantar.
                                    </span>
                                </span>
                            </label>

                            <div class="mt-4">
                                <label class="label" for="notes">Catatan (opsional)</label>
                                <textarea id="notes" name="notes" rows="2"
                                    placeholder="Mis. Kue dikirimkan pukul 15.00, tanpa krim..."
                                    class="input resize-y">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="lg:sticky lg:top-24 lg:space-y-4">
                <div class="card card-pad">
                    <h3 class="font-display text-lg font-semibold text-surface-800">Ringkasan Pesanan</h3>
                    <ul class="mt-4 divide-y divide-surface-100 text-sm">
                        @foreach($cart as $item)
                            <li class="flex justify-between gap-3 py-2.5">
                                <span class="min-w-0 truncate text-surface-700">
                                    {{ $item['name'] }}
                                    <span class="text-surface-400">&times; {{ $item['quantity'] }}</span>
                                </span>
                                <span class="shrink-0 font-medium text-surface-800">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3 space-y-2 border-t border-surface-100 pt-3 text-sm">
                        <div class="flex justify-between text-surface-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-surface-800">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-surface-600">
                            <span>Ongkir</span>
                            <span class="font-medium {{ $deliveryFee <= 0 ? 'text-emerald-600' : 'text-surface-800' }}">
                                {{ $deliveryFee > 0 ? 'Rp ' . number_format($deliveryFee, 0, ',', '.') : 'Gratis' }}
                            </span>
                        </div>
                        @if($tax > 0)
                            <div class="flex justify-between text-surface-600">
                                <span>Pajak</span>
                                <span class="font-medium text-surface-800">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between border-t border-surface-100 pt-2 text-lg font-bold text-surface-800">
                            <span>Total</span>
                            <span class="text-primary-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <button type="submit" form="checkout-form"
                    class="btn-primary mt-4 w-full justify-center"
                    :class="{ 'btn-loading': submitting }"
                    :disabled="submitting">
                    <x-icon name="check" class="h-4 w-4" />
                    <span x-text="submitting ? 'Memproses...' : 'Buat Pesanan'"></span>
                </button>
                <p class="mt-3 text-center text-xs text-surface-400">
                    Dengan melanjutkan, kamu setuju dengan syarat kami.
                </p>
            </div>
        </div>
    </div>
</div>

@endif
@endsection
