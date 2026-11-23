@props(['product'])

@php
    $isSale = $product->is_sale && $product->sale_price;
    $badge = match ($product->badge) {
        'new' => ['badge-new', 'Baru'],
        'best' => ['badge-best', 'Terlaris'],
        'sale' => ['badge-sale', 'Diskon'],
        default => null,
    };
    $outOfStock = (int) $product->stock <= 0;
    $categoryName = $product->category->name ?? null;
@endphp

<div class="product-card">
    <!-- Image Section -->
    <div class="card-image">
        <a href="{{ route('product.show', $product->slug) }}" aria-label="{{ $product->name }}">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                class="aspect-[4/3] w-full object-cover object-center" />
        </a>

        <!-- Badge -->
        @if($badge)
            <span class="absolute left-0 top-0 z-10 {{ $badge[0] }} px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.14em]">
                {{ $badge[1] }}
            </span>
        @endif

        <!-- Out of Stock Overlay -->
        @if($outOfStock)
            <div class="absolute inset-0 z-10 flex items-center justify-center bg-paper/85">
                <span class="border border-ink px-4 py-1.5 text-label uppercase text-ink">Stok Habis</span>
            </div>
        @endif
    </div>

    <!-- Content Section -->
    <div class="mt-4 flex flex-1 flex-col">
        <!-- Category -->
        @if($categoryName)
            <span class="text-label text-ink-40">{{ $categoryName }}</span>
        @endif

        <!-- Title -->
        <a href="{{ route('product.show', $product->slug) }}">
            <h3 class="mt-1 line-clamp-1 font-display text-lg font-medium leading-snug text-ink transition-colors duration-150 hover:text-accent">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Rating -->
        @if($product->ratingAvg())
            <div class="mt-2 flex items-center gap-1.5">
                <div class="flex items-center gap-0.5">
                    @for($r = 1; $r <= 5; $r++)
                        @if($r <= round($product->ratingAvg()))
                            <x-icon name="star" solid="true" class="h-3 w-3 text-accent" />
                        @else
                            <x-icon name="star" class="h-3 w-3 text-ink-40" />
                        @endif
                    @endfor
                </div>
                <span class="font-mono text-label tabular-nums text-ink-40">({{ $product->reviews()->where('is_approved', true)->count() }})</span>
            </div>
        @endif

        <!-- Price -->
        <div class="mt-3 flex flex-wrap items-baseline gap-2">
            @if($isSale)
                <span class="price-tag text-accent">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                <span class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @else
                <span class="price-tag text-ink">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @endif
        </div>

        <!-- Actions -->
        <div class="mt-4 flex gap-2 pt-auto">
            <a href="{{ route('product.show', $product->slug) }}" class="btn-outline-sm flex-1 justify-center">
                Detail
            </a>
            @if(! $outOfStock)
                <form method="POST" action="{{ route('cart.add', $product) }}" class="flex-1">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="sr-only" />
                    <button type="submit" class="btn-primary-sm w-full justify-center">
                        <x-icon name="cart" class="h-3.5 w-3.5" />
                        Keranjang
                    </button>
                </form>
            @else
                <span class="flex flex-1 items-center justify-center border border-rule px-3 py-2 text-label uppercase text-ink-40">
                    Habis
                </span>
            @endif
        </div>
    </div>
</div>
