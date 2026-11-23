@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
    $isSale = $product->is_sale && $product->sale_price;
    $mainImage = $product->imageUrl;
    $gallery = collect(is_array($product->gallery) ? $product->gallery : [])
        ->filter()
        ->unique()
        ->map(fn ($img) => str_starts_with($img, 'http') ? $img : asset('storage/' . $img))
        ->values()
        ->toArray();
    $allImages = array_merge([$mainImage], $gallery);
    $badge = match ($product->badge) {
        'new' => ['badge-new', 'Baru'],
        'best' => ['badge-best', 'Terlaris'],
        'sale' => ['badge-sale', 'Diskon'],
        default => null,
    };
    $approvedCount = $product->reviews()->where('is_approved', true)->count();
@endphp

<div class="mx-auto max-w-7xl px-5 py-8 sm:px-6 lg:px-8"
     x-data="productShow(@js($allImages))">

    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="mb-8 text-sm text-surface-500">
        <ol class="flex items-center flex-wrap gap-1.5">
            <li>
                <a href="{{ route('home') }}" class="transition-colors hover:text-primary-700">Beranda</a>
            </li>
            <li><x-icon name="chevron-right" class="h-3.5 w-3.5 text-surface-400" /></li>
            <li>
                <a href="{{ route('products.index') }}" class="transition-colors hover:text-primary-700">Menu</a>
            </li>
            <li><x-icon name="chevron-right" class="h-3.5 w-3.5 text-surface-400" /></li>
            <li class="font-medium text-surface-700">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Section -->
    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">

        <!-- Gallery -->
        <div class="reveal-left">
            <!-- Main Image -->
            <div class="group relative overflow-hidden rounded-2xl border border-surface-200 bg-surface-100 shadow-sm">
                <img :src="currentImg" alt="{{ $product->name }}"
                    x-transition:enter="transition-opacity duration-300 ease-out"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    class="aspect-[4/3] w-full object-cover object-center transition-transform duration-500 group-hover:scale-[1.02]" />

                <!-- Zoom Button -->
                <button type="button" @click="openLightbox()"
                    class="absolute bottom-3 right-3 flex h-10 w-10 items-center justify-center rounded-xl bg-white/90 text-surface-600 shadow-sm transition-all duration-200 hover:bg-white hover:text-primary-700 hover:shadow-md"
                    aria-label="Perbesar gambar">
                    <x-icon name="eye" class="h-5 w-5" />
                </button>

                <!-- Badge -->
                @if($badge)
                    <span class="absolute left-3 top-3 {{ $badge[0] }} rounded-full px-3 py-1 text-xs font-bold shadow-sm">
                        {{ $badge[1] }}
                    </span>
                @endif
            </div>

            <!-- Thumbnails -->
            @if(count($allImages) > 1)
                <div class="mt-3 flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
                    @foreach($allImages as $index => $img)
                        @php($src = str_starts_with($img, 'http') ? $img : asset('storage/' . $img))
                        <button type="button" @click="currentImg = @js($src); currentIndex = {{ $index }}"
                            :class="currentImg === @js($src) ? 'ring-2 ring-primary ring-offset-2 opacity-100' : 'opacity-60 hover:opacity-100'"
                            class="shrink-0 cursor-pointer rounded-xl border border-surface-200 transition-all duration-200">
                            <img src="{{ $src }}" alt="{{ $product->name }} - Foto {{ $index + 1 }}"
                                class="h-16 w-16 rounded-xl object-cover" loading="lazy" />
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Details -->
        <div class="flex flex-col reveal-right">
            <!-- Badges -->
            <div class="flex flex-wrap items-center gap-2">
                @if($badge)
                    <span class="{{ $badge[0] }} rounded-full px-3 py-1 text-xs font-bold shadow-sm">
                        {{ $badge[1] }}
                    </span>
                @endif
                @if($product->stock > 0)
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Stok Ada</span>
                @else
                    <span class="rounded-full bg-rose-100 px-3 py-1 text-xs font-semibold text-rose-700">Stok Habis</span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="mt-4 font-display text-2xl font-bold tracking-tight text-surface-800 sm:text-3xl">
                {{ $product->name }}
            </h1>

            <!-- Rating -->
            @if($product->ratingAvg())
                <div class="mt-2.5 flex items-center gap-2">
                    <div class="flex items-center gap-0.5" aria-label="Rating {{ round($product->ratingAvg()) }} dari 5">
                        @for($r = 1; $r <= 5; $r++)
                            @if($r <= round($product->ratingAvg()))
                                <x-icon name="star" solid="true" class="h-4 w-4 text-amber-400" />
                            @else
                                <x-icon name="star" class="h-4 w-4 text-surface-300" />
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-surface-500">{{ number_format($product->ratingAvg(), 1) }} ({{ $approvedCount }} ulasan)</span>
                </div>
            @endif

            <!-- Price -->
            <div class="mt-5 flex flex-wrap items-baseline gap-3">
                @if($isSale)
                    <span class="font-display text-3xl font-bold tracking-tight text-primary-700">
                        Rp {{ number_format($product->sale_price, 0, ',', '.') }}
                    </span>
                    <span class="text-lg text-surface-400 line-through">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <span class="rounded-full bg-rose-100 px-2.5 py-0.5 text-xs font-bold text-rose-700">
                        -{{ round((1 - $product->sale_price / $product->price) * 100) }}%
                    </span>
                @else
                    <span class="font-display text-3xl font-bold tracking-tight text-primary-700">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
                <span class="text-sm text-surface-500">/{{ $product->unit }}</span>
            </div>

            <!-- Description Preview -->
            @if($product->description)
                <p class="mt-4 text-sm leading-relaxed text-surface-600 line-clamp-3">
                    {{ $product->description }}
                </p>
            @endif

            <!-- Add to Cart Form -->
            @if($product->stock > 0)
                <div class="mt-8" x-data="{ qty: 1 }">
                    <div class="flex items-center gap-4">
                        <!-- Quantity -->
                        <div class="qty-control">
                            <button type="button" @click="qty = Math.max(1, qty - 1)" class="qty-btn" aria-label="Kurangi jumlah">
                                <x-icon name="minus" class="h-4 w-4" />
                            </button>
                            <span class="qty-value" x-text="qty"></span>
                            <button type="button" @click="qty = Math.min({{ $product->stock }}, qty + 1)" class="qty-btn" aria-label="Tambah jumlah">
                                <x-icon name="plus" class="h-4 w-4" />
                            </button>
                        </div>

                        <!-- Stock info -->
                        <span class="text-xs text-surface-400">
                            {{ $product->stock }} {{ $product->unit }} tersedia
                        </span>
                    </div>

                    <!-- Add to Cart Button -->
                    <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-4">
                        @csrf
                        <input type="hidden" name="quantity" :value="qty" />
                        <button type="submit" class="btn-primary-lg w-full justify-center">
                            <x-icon name="cart" class="h-5 w-5" />
                            Masukkan Keranjang
                        </button>
                    </form>
                </div>
            @else
                <button disabled class="btn-primary-lg mt-8 w-full cursor-not-allowed justify-center opacity-50">
                    Stok Habis
                </button>
            @endif

            <!-- Trust Badges -->
            <div class="mt-6 grid grid-cols-2 gap-3">
                <div class="flex items-center gap-2 rounded-xl bg-surface-50 p-3 text-xs text-surface-600">
                    <x-icon name="shield-check" class="h-4 w-4 shrink-0 text-emerald-500" />
                    <span>100% Fresh handmade</span>
                </div>
                <div class="flex items-center gap-2 rounded-xl bg-surface-50 p-3 text-xs text-surface-600">
                    <x-icon name="check" class="h-4 w-4 shrink-0 text-emerald-500" />
                    <span>Gratis antar Kota Bekasi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs: Deskripsi & Ulasan -->
    <div class="mt-16 reveal">
        <div x-data="{ tab: 'desc' }">
            <div class="flex gap-6 border-b border-surface-200" role="tablist">
                <button @click="tab='desc'" role="tab" :aria-selected="tab==='desc'"
                    :class="tab==='desc' ? 'border-primary-600 text-primary-700' : 'border-transparent text-surface-500 hover:text-surface-700'"
                    class="-mb-px border-b-2 pb-3.5 text-sm font-semibold transition-colors duration-200">
                    Deskripsi
                </button>
                <button @click="tab='reviews'" role="tab" :aria-selected="tab==='reviews'"
                    :class="tab==='reviews' ? 'border-primary-600 text-primary-700' : 'border-transparent text-surface-500 hover:text-surface-700'"
                    class="-mb-px border-b-2 pb-3.5 text-sm font-semibold transition-colors duration-200">
                    Ulasan
                    @if($approvedCount > 0)
                        <span class="ml-1.5 rounded-full bg-primary-50 px-2 py-0.5 text-xs font-bold text-primary-700">
                            {{ $approvedCount }}
                        </span>
                    @endif
                </button>
            </div>

            <div class="pt-8">
                <!-- Description Tab -->
                <div x-show="tab==='desc'" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                    class="max-w-3xl text-sm leading-relaxed text-surface-700 prose prose-sm">
                    {!! nl2br(e($product->description ?: 'Produk premium dari Star Cake.')) !!}
                </div>

                <!-- Reviews Tab -->
                <div x-show="tab==='reviews'" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                    @include('partials.reviews', ['product' => $product])
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox -->
    <div x-show="lightboxOpen" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4 sm:p-8"
        @click.self="closeLightbox()"
        @keydown.escape.window="closeLightbox()"
        @keydown.left.window="prevImage()"
        @keydown.right.window="nextImage()">

        <!-- Close -->
        <button @click="closeLightbox()"
            class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20 z-10">
            <x-icon name="x" class="h-5 w-5" />
        </button>

        <!-- Prev -->
        <button @click="prevImage()"
            class="absolute left-4 top-1/2 -translate-y-1/2 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20">
            <x-icon name="chevron-left" class="h-6 w-6" />
        </button>

        <!-- Image -->
        <img :src="currentImg" alt="{{ $product->name }}"
            x-transition:enter="transition-opacity duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="max-h-[85vh] max-w-full rounded-lg object-contain shadow-2xl" />

        <!-- Next -->
        <button @click="nextImage()"
            class="absolute right-4 top-1/2 -translate-y-1/2 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-white/20">
            <x-icon name="chevron-right" class="h-6 w-6" />
        </button>

        <!-- Counter -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-white">
            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
        </div>
    </div>

    <!-- Sticky Add to Cart (Mobile) -->
    @if($product->stock > 0)
        <div class="fixed bottom-0 left-0 right-0 z-30 border-t border-surface-200 bg-white/95 px-5 py-3 shadow-elevated lg:hidden"
            x-data="{ qty: 1 }"
            x-show="!lightboxOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-y-full"
            x-transition:enter-end="translate-y-0">
            <form method="POST" action="{{ route('cart.add', $product) }}" class="flex items-center gap-3">
                @csrf
                <div class="qty-control shrink-0">
                    <button type="button" @click="qty = Math.max(1, qty - 1)" class="qty-btn">
                        <x-icon name="minus" class="h-4 w-4" />
                    </button>
                    <span class="qty-value" x-text="qty"></span>
                    <button type="button" @click="qty = Math.min({{ $product->stock }}, qty + 1)" class="qty-btn">
                        <x-icon name="plus" class="h-4 w-4" />
                    </button>
                </div>
                <input type="hidden" name="quantity" :value="qty" />
                <button type="submit" class="btn-primary flex-1 justify-center">
                    <x-icon name="cart" class="h-4 w-4" />
                    Masukkan Keranjang
                </button>
            </form>
        </div>
        <!-- Spacer -->
        <div class="h-20 lg:hidden"></div>
    @endif
</div>

@push('head')
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@push('head')
<script>
function productShow(images) {
    return {
        images: images,
        currentImg: images[0] || '',
        currentIndex: 0,
        lightboxOpen: false,

        openLightbox() {
            this.lightboxOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closeLightbox() {
            this.lightboxOpen = false;
            document.body.style.overflow = '';
        },

        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
            this.currentImg = this.images[this.currentIndex];
        },

        prevImage() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
            this.currentImg = this.images[this.currentIndex];
        }
    };
}
</script>
@endpush
@endsection
