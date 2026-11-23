@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $statusColors = [
        'pending' => 'bg-amber-500',
        'processing' => 'bg-blue-500',
        'completed' => 'bg-emerald-500',
        'cancelled' => 'bg-rose-500',
    ];
    $statusLabels = ['pending' => 'Pending', 'processing' => 'Diproses', 'completed' => 'Selesai', 'cancelled' => 'Batal'];
    $maxCount = max(array_values($salesByStatus) + [1]);

    // Donut chart data
    $donutTotal = array_sum($salesByStatus) ?: 1;
    $donutSegments = [];
    $offset = 0;
    $circumference = 2 * pi() * 54;
    foreach($statusLabels as $key => $label) {
        $count = $salesByStatus[$key] ?? 0;
        $pct = $donutTotal ? ($count / $donutTotal) : 0;
        $donutSegments[$key] = [
            'label' => $label,
            'count' => $count,
            'pct' => $pct,
            'dasharray' => ($pct * $circumference) . ' ' . $circumference,
            'offset' => $offset,
        ];
        $offset += $pct * $circumference;
    }
@endphp
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold text-surface-800">Ringkasan Bisnis</h1>
            <p class="text-sm text-surface-500">Pantau performa toko kue kamu hari ini.</p>
        </div>
        <span class="badge badge-paid">Terima kasih sudah berjualan hari ini</span>
    </div>

    <!-- Stat Cards — Gradient -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5" x-data="{
        show: false,
        countProducts: 0, countCategories: 0, countOrders: 0, countCustomers: 0,
        targetProducts: {{ $stats['products'] }},
        targetCategories: {{ $stats['categories'] }},
        targetOrders: {{ $stats['orders'] }},
        targetCustomers: {{ $stats['customers'] }},
        animateCounter(target, prop) {
            let step = Math.max(1, Math.ceil(target / 30));
            let current = 0;
            let interval = setInterval(() => {
                current += step;
                if (current >= target) { this[prop] = target; clearInterval(interval); }
                else { this[prop] = current; }
            }, 30);
        },
        init() {
            this.show = true;
            this.animateCounter(this.targetProducts, 'countProducts');
            this.animateCounter(this.targetCategories, 'countCategories');
            this.animateCounter(this.targetOrders, 'countOrders');
            this.animateCounter(this.targetCustomers, 'countCustomers');
        }
    }">
        <!-- Produk -->
        <div class="admin-stat admin-stat-blue">
            <div class="admin-stat-title">
                <p class="admin-stat-label">Produk</p>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/20">
                    <x-icon name="box" class="h-5 w-5" />
                </span>
            </div>
            <p class="admin-stat-value mt-2" x-text="countProducts">0</p>
        </div>

        <!-- Kategori -->
        <div class="admin-stat admin-stat-purple">
            <div class="admin-stat-title">
                <p class="admin-stat-label">Kategori</p>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/20">
                    <x-icon name="cake" class="h-5 w-5" />
                </span>
            </div>
            <p class="admin-stat-value mt-2" x-text="countCategories">0</p>
        </div>

        <!-- Pesanan -->
        <div class="admin-stat admin-stat-amber">
            <div class="admin-stat-title">
                <p class="admin-stat-label">Pesanan</p>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/20">
                    <x-icon name="shopping-cart" class="h-5 w-5" />
                </span>
            </div>
            <p class="admin-stat-value mt-2" x-text="countOrders">0</p>
        </div>

        <!-- Pelanggan -->
        <div class="admin-stat admin-stat-emerald">
            <div class="admin-stat-title">
                <p class="admin-stat-label">Pelanggan</p>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/20">
                    <x-icon name="user" class="h-5 w-5" />
                </span>
            </div>
            <p class="admin-stat-value mt-2" x-text="countCustomers">0</p>
        </div>

        <!-- Pendapatan -->
        <div class="admin-stat admin-stat-primary xl:col-span-1">
            <div class="admin-stat-title">
                <p class="admin-stat-label">Pendapatan</p>
                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/20">
                    <x-icon name="shield-check" class="h-5 w-5" />
                </span>
            </div>
            <p class="mt-2 font-display text-2xl font-bold tabular-nums tracking-tight">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Donut Chart — Order Status -->
        <div class="card card-pad lg:col-span-1" x-data="{
            show: false,
            init() { setTimeout(() => this.show = true, 200); }
        }">
            <h2 class="font-display text-lg font-semibold text-surface-800">Status Pesanan</h2>

            <div class="mt-5 flex items-center justify-center">
                <div class="admin-donut" x-show="show" x-transition.duration.800ms>
                    <svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        @php($radius = 54)
                        @php($circum = 2 * pi() * $radius)
                        @php($donutOffset = 0)
                        @foreach($donutSegments as $key => $seg)
                            @php($color = match($key) { 'pending' => '#f59e0b', 'processing' => '#3b82f6', 'completed' => '#10b981', 'cancelled' => '#f43f5e', default => '#d1d5db' })
                            <circle cx="60" cy="60" r="{{ $radius }}"
                                stroke="{{ $color }}"
                                stroke-width="12"
                                stroke-dasharray="{{ $seg['dasharray'] }}"
                                stroke-dashoffset="-{{ $donutOffset }}"
                                stroke-linecap="round"
                                class="transition-all duration-1000"
                                style="transform-origin: center; transform: rotate(-90deg);" />
                            @php($donutOffset += $seg['pct'] * $circum)
                        @endforeach
                    </svg>
                    <div class="admin-donut-center">
                        <span class="font-display text-2xl font-bold text-surface-800">{{ $donutTotal }}</span>
                        <span class="text-[10px] font-medium text-surface-400">Total</span>
                    </div>
                </div>
            </div>

            <div class="mt-5 space-y-3">
                @foreach($statusLabels as $key => $label)
                    @php($count = $salesByStatus[$key] ?? 0)
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2 font-medium text-surface-700">
                            <span class="h-2.5 w-2.5 rounded-full {{ $statusColors[$key] }}"></span>{{ $label }}
                        </span>
                        <span class="font-bold text-surface-800">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="card card-pad lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-semibold text-surface-800">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-primary-700 transition-colors hover:text-primary-800">
                    Lihat semua <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                </a>
            </div>
            <div class="table-shell mt-4">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr>
                            <th>No. Pesanan</th>
                            <th>Pelanggan</th>
                            <th class="text-right">Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="font-mono font-medium text-surface-800">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary-700">{{ $order->order_number }}</a>
                                </td>
                                <td class="text-surface-600">{{ $order->customer_name }}</td>
                                <td class="text-right font-semibold text-surface-800">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-{{ $order->status }}">{{ $statusLabels[$order->status] ?? ucfirst($order->status) }}</span>
                                </td>
                                <td class="text-surface-500">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="empty-cell">Belum ada pesanan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
