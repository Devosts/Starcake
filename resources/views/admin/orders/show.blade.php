@extends('layouts.admin')

@section('title', $order->order_number)

@section('content')
@php
    $statusBadges = [
        'pending' => 'badge-pending', 'processing' => 'badge-processing',
        'completed' => 'badge-completed', 'cancelled' => 'badge-cancelled',
    ];
    $statusList = [
        'pending' => ['label' => 'Pending', 'desc' => 'Menunggu diproses'],
        'processing' => ['label' => 'Diproses', 'desc' => 'Kue sedang dibuat'],
        'completed' => ['label' => 'Selesai', 'desc' => 'Pesanan selesai'],
        'cancelled' => ['label' => 'Dibatalkan', 'desc' => 'Pesanan dibatalkan'],
    ];
@endphp
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-surface-500 transition-colors hover:text-primary-700">
                <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Pesanan
            </a>
            <h1 class="mt-1 font-mono font-display text-2xl font-bold text-surface-800">{{ $order->order_number }}</h1>
            <span class="mt-1 inline-block badge {{ $statusBadges[$order->status] ?? 'badge-pending' }}">{{ $statusList[$order->status]['label'] ?? ucfirst($order->status) }}</span>
        </div>
        <span class="text-sm text-surface-400">Dibuat {{ $order->created_at->format('d M Y, H:i') }}</span>
    </div>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            <!-- Customer -->
            <div class="card card-pad">
                <h2 class="flex items-center gap-2 font-display text-lg font-semibold text-surface-800">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary/10 text-primary-600"><x-icon name="user" class="h-4 w-4" /></span>
                    Pelanggan
                </h2>
                <dl class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Nama</dt>
                        <dd class="mt-0.5 font-semibold text-surface-800">{{ $order->customer_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Kontak</dt>
                        <dd class="mt-0.5 text-surface-700">
                            <a href="mailto:{{ $order->customer_email }}" class="hover:text-primary-700">{{ $order->customer_email }}</a><br>
                            {{ $order->customer_phone }}
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Alamat</dt>
                        <dd class="mt-0.5 text-surface-700">{{ $order->customer_address }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Items -->
            <div class="card card-pad">
                <h2 class="flex items-center gap-2 font-display text-lg font-semibold text-surface-800">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary/10 text-primary-600"><x-icon name="box" class="h-4 w-4" /></span>
                    Item Pesanan
                </h2>
                <div class="table-shell mt-4">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="font-medium text-surface-800">
                                        {{ $item->product_name }}
                                        @if($item->notes)
                                            <p class="mt-1 text-xs font-normal italic text-surface-500">"{{ $item->notes }}"</p>
                                        @endif
                                    </td>
                                    <td class="text-center text-surface-600">× {{ $item->quantity }}</td>
                                    <td class="text-right text-surface-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-right font-semibold text-surface-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-semibold text-surface-800">Total</td>
                                <td class="text-right font-display text-lg font-bold text-primary-700">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- History -->
            <div class="card card-pad">
                <h2 class="flex items-center gap-2 font-display text-lg font-semibold text-surface-800">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-primary/10 text-primary-600"><x-icon name="clock" class="h-4 w-4" /></span>
                    Riwayat Status
                </h2>
                <ul class="mt-4 space-y-5">
                    @forelse($order->histories as $i => $h)
                        @php($isLatest = $i === 0)
                        <li class="relative flex gap-4">
                            <div class="flex flex-col items-center">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center {{ $isLatest ? 'bg-ink text-paper' : 'border border-rule text-ink-40' }}">
                                    <x-icon name="check" class="h-4 w-4" />
                                </span>
                                @if(! $loop->last)
                                    <span class="w-0.5 flex-1 bg-surface-200"></span>
                                @endif
                            </div>
                            <div class="pb-5">
                                <p class="font-semibold text-surface-800">{{ $h->title }}</p>
                                <p class="text-xs text-surface-500">{{ \Carbon\Carbon::parse($h->created_at)->format('d M Y, H:i') }} · oleh {{ $h->created_by ?? '-' }}</p>
                                @if($h->note)
                                    <p class="mt-1 rounded-lg bg-surface-100/70 px-3 py-1.5 text-xs text-surface-600">{{ $h->note }}</p>
                                @endif
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-surface-500">Belum ada riwayat.</p>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-5">
            <div class="card card-pad">
                <h2 class="font-display text-lg font-semibold text-surface-800">Ubah Status</h2>
                <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" class="mt-4">
                    @csrf @method('PATCH')
                    <div class="space-y-2">
                        @foreach($statusList as $value => $meta)
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border-2 border-surface-200 p-3 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50/60">
                                <input type="radio" name="status" value="{{ $value }}" {{ $order->status == $value ? 'checked' : '' }} class="mt-0.5 h-4 w-4 text-primary-600 focus:ring-primary-500">
                                <span>
                                    <span class="block text-sm font-semibold text-surface-800">{{ $meta['label'] }}</span>
                                    <span class="block text-xs text-surface-500">{{ $meta['desc'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <label class="label mt-4" for="status_note">Catatan (opsional)</label>
                    <textarea id="status_note" name="note" rows="2" placeholder="cth: Kurir dalam perjalanan..." class="input resize-y"></textarea>
                    <button type="submit" class="btn-primary mt-4 w-full">
                        <x-icon name="refresh" class="h-4 w-4" /> Perbarui Status
                    </button>
                </form>
            </div>

            <div class="card card-pad text-sm">
                <h2 class="font-display text-lg font-semibold text-surface-800">Info Pengiriman</h2>
                <dl class="mt-3 space-y-3">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Pembayaran</dt>
                        <dd><span class="badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">{{ ucfirst($order->payment_status) }}</span></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Metode</dt>
                        <dd class="mt-0.5 text-surface-700">{{ $order->payment_method === 'cod' ? 'Bayar Tunai (COD)' : ucfirst(str_replace('_', ' ', $order->payment_method)) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Pengiriman</dt>
                        <dd class="mt-0.5 text-surface-700">{{ $order->delivery_type === 'pickup' ? 'Ambil di Toko' : 'Antar ke Tempat' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Jadwal</dt>
                        <dd class="mt-0.5 text-surface-700">{{ $order->scheduled_date ? $order->scheduled_date->translatedFormat('d M Y') : '-' }} ({{ $order->scheduled_time_slot ?? '-' }})</dd>
                    </div>
                    @if($order->notes)
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Catatan Pelanggan</dt>
                            <dd class="mt-0.5 rounded-lg bg-surface-100/70 px-3 py-2 text-surface-600">{{ $order->notes }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection