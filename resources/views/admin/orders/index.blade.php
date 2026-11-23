@extends('layouts.admin')

@section('title', 'Pesanan')

@section('content')
@php
    $filters = [
        '' => ['label' => 'Semua', 'active' => !request('status')],
        'pending' => ['label' => 'Pending', 'active' => request('status') == 'pending'],
        'processing' => ['label' => 'Diproses', 'active' => request('status') == 'processing'],
        'completed' => ['label' => 'Selesai', 'active' => request('status') == 'completed'],
        'cancelled' => ['label' => 'Dibatalkan', 'active' => request('status') == 'cancelled'],
    ];
    $statusBadges = [
        'pending' => 'badge-pending', 'processing' => 'badge-processing',
        'completed' => 'badge-completed', 'cancelled' => 'badge-cancelled',
    ];
    $statusLabels = [
        'pending' => 'Pending', 'processing' => 'Diproses',
        'completed' => 'Selesai', 'cancelled' => 'Dibatalkan',
    ];
@endphp
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold text-surface-800">Pesanan</h1>
            <p class="text-sm text-surface-500">Kelola semua pesanan pelanggan.</p>
        </div>
        <span class="badge badge-paid">{{ $orders->total() }} pesanan</span>
    </div>

    <div class="flex flex-wrap gap-2">
        @foreach($filters as $value => $f)
            <a href="{{ $value ? route('admin.orders.index', ['status' => $value]) : route('admin.orders.index') }}"
                class="chip {{ $f['active'] ? 'chip-active' : '' }}">{{ $f['label'] }}</a>
        @endforeach
    </div>

    <div class="table-shell">
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Pelanggan</th>
                    <th class="text-right">Total</th>
                    <th>Status</th>
                    <th>Pembayaran</th>
                    <th>Tanggal</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="group">
                        <td class="font-mono font-medium text-surface-800">
                            <a href="{{ route('admin.orders.show', $order) }}" class="hover:text-primary-700">{{ $order->order_number }}</a>
                        </td>
                        <td class="text-surface-600">{{ $order->customer_name }}</td>
                        <td class="text-right font-semibold text-surface-800">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $statusBadges[$order->status] ?? 'badge-pending' }}">{{ $statusLabels[$order->status] ?? ucfirst($order->status) }}</span>
                        </td>
                        <td class="text-surface-600">{{ $order->payment_method === 'cod' ? 'Bayar Tunai (COD)' : ucfirst(str_replace('_', ' ', $order->payment_method)) }}</td>
                        <td class="text-surface-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.orders.show', $order) }}" title="Detail" aria-label="Detail pesanan"
                                    class="icon-btn">
                                    <x-icon name="eye" class="h-4 w-4" />
                                </a>
                                <x-confirm-dialog
                                    :action="route('admin.orders.destroy', $order)"
                                    title="Hapus pesanan?"
                                    message="Pesanan {{ $order->order_number }} beserta riwayatnya akan dihapus permanen."
                                    confirm-text="Ya, Hapus">
                                    <span class="icon-btn icon-btn-danger" title="Hapus" aria-label="Hapus pesanan">
                                        <x-icon name="trash" class="h-4 w-4" />
                                    </span>
                                </x-confirm-dialog>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty-cell">Tidak ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $orders->links() }}</div>
</div>
@endsection