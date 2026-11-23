@extends('layouts.app')

@section('title', 'Menu')

@section('content')
<div class="mx-auto max-w-7xl px-5 py-10 sm:px-6 lg:px-8" x-data="{ filtersOpen: false }">
    <!-- Header -->
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold tracking-tight text-surface-800">
                @isset($category) {{ $category->name }} @else Menu Kue Star Cake @endisset
            </h1>
            <p class="mt-1 text-sm text-surface-500">{{ $products->total() }} produk tersedia</p>
        </div>
        <button type="button" @click="filtersOpen = true"
            class="btn-outline lg:hidden">
            <x-icon name="menu" class="h-4 w-4" />
            Filter
        </button>
    </div>

    <!-- Active Filter Tags -->
    @if(request()->hasAny(['search', 'category', 'sort']) || isset($category))
        <div class="mt-6 flex flex-wrap items-center gap-2">
            <span class="text-xs font-medium text-surface-500">Filter aktif:</span>
            @if(request('search'))
                <span class="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-3 py-1 text-xs font-medium text-primary-700 ring-1 ring-primary-200">
                    "{{ request('search') }}"
                    <a href="{{ route('products.index', request()->except('search')) }}" class="hover:text-primary-900 transition-colors">&times;</a>
                </span>
            @endif
            @if(isset($category))
                <span class="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-3 py-1 text-xs font-medium text-primary-700 ring-1 ring-primary-200">
                    {{ $category->name }}
                    <a href="{{ route('products.index') }}" class="hover:text-primary-900 transition-colors">&times;</a>
                </span>
            @elseif(request('category'))
                <span class="inline-flex items-center gap-1.5 rounded-full bg-primary-50 px-3 py-1 text-xs font-medium text-primary-700 ring-1 ring-primary-200">
                    {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                    <a href="{{ route('products.index', request()->except('category')) }}" class="hover:text-primary-900 transition-colors">&times;</a>
                </span>
            @endif
            @if(request('sort') && request('sort') !== 'newest')
                <span class="inline-flex items-center gap-1.5 rounded-full bg-surface-100 px-3 py-1 text-xs font-medium text-surface-600 ring-1 ring-surface-200">
                    Urut: {{ request('sort') === 'price_asc' ? 'Harga Terendah' : 'Harga Tertinggi' }}
                    <a href="{{ route('products.index', request()->except('sort')) }}" class="hover:text-surface-900 transition-colors">&times;</a>
                </span>
            @endif
            <a href="{{ route('products.index') }}" class="text-xs font-medium text-rose-500 transition-colors hover:text-rose-700 ml-1">
                Hapus semua
            </a>
        </div>
    @endif

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-4 lg:gap-10">
        <!-- Desktop Filters -->
        <aside class="hidden lg:block">
            <form id="filter-form" method="GET" action="{{ route('products.index') }}" class="sticky top-24 space-y-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-surface-200/60">
                <!-- Search -->
                <div>
                    <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-surface-500">Cari</h3>
                    <div class="relative">
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari kue..."
                            class="input !pl-9" />
                        <x-icon name="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-surface-400" />
                    </div>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-surface-500">Kategori</h3>
                    <ul class="space-y-1.5">
                        <li>
                            <a href="{{ route('products.index') }}"
                                class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium transition-all duration-200
                                {{ !request('category') && !isset($category)
                                    ? 'bg-primary-50 text-primary-700 ring-1 ring-primary-200'
                                    : 'text-surface-600 hover:bg-surface-100 hover:text-surface-800' }}">
                                <x-icon name="cake" class="h-4 w-4" />
                                Semua Kue
                            </a>
                        </li>
                        @foreach($categories as $c)
                            <li>
                                <a href="{{ route('products.index', ['category' => $c->slug]) }}"
                                    class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-medium transition-all duration-200
                                    {{ request('category') == $c->slug
                                        ? 'bg-primary-50 text-primary-700 ring-1 ring-primary-200'
                                        : 'text-surface-600 hover:bg-surface-100 hover:text-surface-800' }}">
                                    <x-icon name="cake" class="h-4 w-4" />
                                    {{ $c->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Sort -->
                <div>
                    <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-surface-500">Urutkan</h3>
                    <select name="sort" onchange="this.form.submit()" class="input cursor-pointer">
                        <option value="newest" {{ request('sort','newest')=='newest'?'selected':'' }}>Terbaru</option>
                        <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Harga Terendah</option>
                        <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Harga Tertinggi</option>
                    </select>
                </div>

                <!-- Apply / Reset -->
                <button type="submit" class="btn-primary w-full justify-center">Terapkan Filter</button>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('products.index') }}" class="btn-ghost w-full justify-center text-sm">Reset Filter</a>
                @endif
            </form>
        </aside>

        <!-- Mobile Filter Drawer -->
        <div x-show="filtersOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 lg:hidden">
            <div class="absolute inset-0 bg-surface-900/50" @click="filtersOpen = false"></div>
            <div class="absolute inset-y-0 left-0 w-full max-w-sm bg-white shadow-2xl"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between border-b border-surface-200 px-5 py-4">
                    <h2 class="font-display text-lg font-semibold text-surface-800">Filter &amp; Urutkan</h2>
                    <button type="button" @click="filtersOpen = false" aria-label="Tutup filter"
                        class="icon-btn">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>
                <!-- Drawer Content -->
                <div class="overflow-y-auto p-5">
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                        <div>
                            <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-surface-500">Cari</h3>
                            <div class="relative">
                                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari kue..." class="input !pl-9" />
                                <x-icon name="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-surface-400" />
                            </div>
                        </div>
                        <div>
                            <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-surface-500">Kategori</h3>
                            <ul class="space-y-1.5">
                                <li>
                                    <a href="{{ route('products.index') }}" @click="filtersOpen = false"
                                        class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium transition-all
                                        {{ !request('category') ? 'bg-primary-50 text-primary-700' : 'text-surface-600 hover:bg-surface-100' }}">
                                        <x-icon name="cake" class="h-4 w-4" />
                                        Semua Kue
                                    </a>
                                </li>
                                @foreach($categories as $c)
                                    <li>
                                        <a href="{{ route('products.index', ['category' => $c->slug]) }}" @click="filtersOpen = false"
                                            class="flex items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium transition-all
                                            {{ request('category') == $c->slug ? 'bg-primary-50 text-primary-700' : 'text-surface-600 hover:bg-surface-100' }}">
                                            <x-icon name="cake" class="h-4 w-4" />
                                            {{ $c->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-surface-500">Urutkan</h3>
                            <select name="sort" class="input cursor-pointer">
                                <option value="newest" {{ request('sort','newest')=='newest'?'selected':'' }}>Terbaru</option>
                                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Harga Terendah</option>
                                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Harga Tertinggi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary w-full justify-center">Terapkan Filter</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                @forelse($products as $product)
                    <div class="reveal">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="empty-state col-span-full py-16">
                        <div class="empty-state-icon">
                            <x-icon name="search" class="h-7 w-7" />
                        </div>
                        <p class="empty-state-title">Produk tidak ditemukan</p>
                        <p class="empty-state-text">Coba ubah kata kunci atau hapus filter yang kamu pilih.</p>
                        <a href="{{ route('products.index') }}" class="btn-primary mt-3">
                            Reset Filter
                        </a>
                    </div>
                @endforelse
            </div>

            @if($products->hasPages())
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
