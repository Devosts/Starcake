@extends('layouts.admin')

@section('title', $product->name)

@section('content')
@php($isActive = $product->is_active)
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-surface-500 transition-colors hover:text-primary-700">
                <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Produk
            </a>
            <h1 class="mt-1 font-display text-2xl font-bold text-surface-800">{{ $product->name }}</h1>
            <span class="mt-1 inline-block badge {{ $isActive ? 'badge-completed' : 'badge-unpaid' }}">{{ $isActive ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <div class="flex gap-2">
            <x-confirm-dialog
                :action="route('admin.products.destroy', $product)"
                title="Hapus produk?"
                message="Produk {{ $product->name }} akan dihapus permanen dari katalog."
                confirm-text="Ya, Hapus">
                <button type="button" class="btn-danger">
                    <x-icon name="trash" class="h-4 w-4" /> Hapus
                </button>
            </x-confirm-dialog>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn-primary">
                <x-icon name="pencil" class="h-4 w-4" /> Edit Produk
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <div class="card card-pad">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                    class="aspect-square w-full rounded-xl object-cover ring-1 ring-surface-200" />
                @if($product->gallery && is_array($product->gallery))
                    <div class="mt-3 flex gap-2 overflow-x-auto pb-1">
                        @foreach($product->gallery as $img)
                            <img src="{{ str_starts_with($img, 'http') ? $img : asset('storage/' . $img) }}"
                                alt="Galeri {{ $product->name }}" class="h-16 w-16 shrink-0 rounded-lg object-cover ring-1 ring-surface-200" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-5 lg:col-span-2">
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="card card-pad text-center">
                    <p class="font-display text-2xl font-bold text-surface-800">
                        {{ $product->sale_price && $product->is_sale ? 'Rp ' . number_format($product->sale_price, 0, ',', '.') : 'Rp ' . number_format($product->price, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-surface-500">Harga {{ $product->sale_price && $product->is_sale ? '(diskon)' : '' }}</p>
                    @if($product->sale_price && $product->is_sale)
                        <p class="text-xs text-surface-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @endif
                </div>
                <div class="card card-pad text-center">
                    <p class="font-display text-2xl font-bold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $product->stock }}</p>
                    <p class="text-xs text-surface-500">Stok ({{ $product->unit }})</p>
                </div>
                <div class="card card-pad text-center">
                    <p class="font-display text-2xl font-bold text-surface-800">{{ $product->reviews_count ?? $product->reviews()->count() }}</p>
                    <p class="text-xs text-surface-500">Ulasan</p>
                </div>
                <div class="card card-pad text-center">
                    <p class="font-display text-2xl font-bold text-secondary-500">{{ number_format($product->ratingAvg() ?? 0, 1) }}</p>
                    <p class="text-xs text-surface-500">Rating</p>
                </div>
            </div>

            <div class="card card-pad">
                <h2 class="font-display text-lg font-semibold text-surface-800">Detail Produk</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Kategori</dt>
                        <dd class="mt-0.5 text-surface-700">{{ $product->category->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">SKU</dt>
                        <dd class="mt-0.5 font-mono text-surface-700">{{ $product->sku ?: '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Badge</dt>
                        <dd class="mt-0.5 text-surface-700">{{ ucfirst($product->badge ?: '-') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Unggulan</dt>
                        <dd class="mt-0.5 text-surface-700">{{ $product->is_featured ? 'Ya' : 'Tidak' }}</dd>
                    </div>
                </dl>
                <div class="mt-4">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Deskripsi</dt>
                    <dd class="mt-1 whitespace-pre-line leading-relaxed text-surface-600">{{ $product->description ?: '-' }}</dd>
                </div>
            </div>

            @if($product->meta && count($product->meta))
                <div class="card card-pad">
                    <h2 class="font-display text-lg font-semibold text-surface-800">Informasi Tambahan</h2>
                    <dl class="mt-4 grid grid-cols-2 gap-4 text-sm sm:grid-cols-4">
                        @foreach(['weight' => 'Berat', 'dimensions' => 'Dimensi', 'calories' => 'Kalori', 'servings' => 'Porsi'] as $key => $label)
                            @if(! empty($product->meta[$key]))
                                <div>
                                    <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">{{ $label }}</dt>
                                    <dd class="mt-0.5 text-surface-700">{{ $product->meta[$key] }}</dd>
                                </div>
                            @endif
                        @endforeach
                    </dl>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection