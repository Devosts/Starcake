@extends('layouts.admin')

@section('title', 'Produk')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold text-surface-800">Produk</h1>
            <p class="text-sm text-surface-500">Kelola menu kue kamu.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Produk
        </a>
    </div>

    <form method="GET" action="{{ route('admin.products.index') }}" class="flex max-w-md gap-2">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-surface-400" />
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="input pl-9" aria-label="Cari produk" />
        </div>
        <button type="submit" class="btn-outline">Cari</button>
    </form>

    <div class="table-shell">
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th class="text-right">Harga</th>
                    <th class="text-center">Stok</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="group">
                        <td>
                            <a href="{{ route('admin.products.show', $product) }}" class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="h-10 w-10 shrink-0 rounded-lg object-cover ring-1 ring-surface-200" />
                                <span class="font-medium text-surface-800 group-hover:text-primary-700">{{ $product->name }}</span>
                            </a>
                        </td>
                        <td class="text-surface-600">{{ $product->category->name ?? '-' }}</td>
                        <td class="text-right">
                            @if($product->sale_price && $product->is_sale)
                                <span class="font-semibold text-primary-700">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                <span class="block text-xs text-surface-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @else
                                <span class="font-semibold text-surface-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $product->stock > 0 ? 'badge-paid' : 'badge-cancelled' }}">
                                {{ $product->stock > 0 ? $product->stock . ' ' . $product->unit : 'Habis' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $product->is_active ? 'badge-completed' : 'badge-unpaid' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.products.show', $product) }}" title="Lihat" aria-label="Lihat produk" class="icon-btn">
                                    <x-icon name="eye" class="h-4 w-4" />
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" title="Edit" aria-label="Edit produk" class="icon-btn">
                                    <x-icon name="pencil" class="h-4 w-4" />
                                </a>
                                <x-confirm-dialog
                                    :action="route('admin.products.destroy', $product)"
                                    title="Hapus produk?"
                                    message="Produk {{ $product->name }} akan dihapus permanen dari katalog."
                                    confirm-text="Ya, Hapus">
                                    <span class="icon-btn icon-btn-danger" title="Hapus" aria-label="Hapus produk">
                                        <x-icon name="trash" class="h-4 w-4" />
                                    </span>
                                </x-confirm-dialog>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-cell">Belum ada produk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $products->links() }}</div>
</div>
@endsection