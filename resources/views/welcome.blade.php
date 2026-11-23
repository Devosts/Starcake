@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero -->
    <section class="hero-section">
        <div class="relative h-[580px] sm:h-[620px] md:h-[680px]">
            <img src="{{ asset('images/hero-bakery.svg') }}" alt="Toko bakery Star Cake"
                class="h-full w-full object-cover object-center" fetchpriority="high" />
            <div class="hero-overlay"></div>
            <div class="hero-mesh"></div>

            <div class="absolute inset-0 flex flex-col items-center justify-center px-4 text-center text-white">
                <span class="animate-fade-in rounded-full border border-white/20 bg-white/10 px-5 py-2 text-xs font-medium uppercase tracking-[0.2em] text-white/90">
                    Handmade Premium
                </span>
                <h1 class="animate-slide-up mt-6 max-w-3xl font-display text-5xl font-medium leading-[1.05] tracking-tight sm:text-6xl md:text-7xl">
                    Kue Enak,<br class="hidden sm:block" />
                    <span class="text-accent">Hati Senang</span>
                </h1>
                <p class="animate-slide-up mt-5 max-w-xl text-base leading-relaxed text-white/85 drop-shadow sm:text-lg" style="animation-delay: 100ms">
                    Star Cake menyajikan kue handmade premium untuk setiap momen spesial Anda.
                    Gratis antar khusus area Kota Bekasi.
                </p>
                <div class="animate-slide-up mt-8 flex flex-wrap justify-center gap-4" style="animation-delay: 200ms">
                    <a href="{{ route('products.index') }}" class="btn-primary-lg">
                        Pesan Sekarang
                        <x-icon name="chevron-right" class="h-5 w-5 transition-transform group-hover:translate-x-1" />
                    </a>
                    <a href="{{ route('about') }}" class="inline-flex items-center justify-center gap-2 rounded-button border border-white/30 bg-white/10 px-8 py-3.5 text-base font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:border-white/50 hover:bg-white/20 hover:shadow-lg">
                        Tentang Kami
                    </a>
                </div>

                <!-- Trust Badges -->
                <div class="animate-fade-in mt-14 flex flex-wrap items-center justify-center gap-3" style="animation-delay: 300ms">
                    <span class="flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium text-white/90">
                        <x-icon name="check" class="h-4 w-4 text-amber-300" /> Gratis antar Kota Bekasi
                    </span>
                    <span class="flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium text-white/90">
                        <x-icon name="check" class="h-4 w-4 text-amber-300" /> 100% Fresh handmade
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="section-title reveal">Kategori Kue</h2>
                    <p class="section-subtitle reveal reveal-delay-1">Temukan kue favoritmu berdasarkan kategori.</p>
                </div>
                <a href="{{ route('products.index') }}" class="reveal reveal-delay-2 text-sm font-semibold text-primary-700 transition-colors hover:text-primary-800">
                    Lihat Semua â†’
                </a>
            </div>

            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5">
                @forelse($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="reveal group flex flex-col items-center rounded-2xl bg-white p-6 text-center shadow-sm ring-1 ring-surface-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-primary/10 hover:ring-primary/30">
                        <div class="mb-4 flex h-24 w-24 items-center justify-center overflow-hidden transition-transform duration-300 group-hover:scale-105">
                            @if($category->image)
                                <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}"
                                    alt="{{ $category->name }}" class="h-full w-full object-contain" loading="lazy" />
                            @else
                                <x-icon name="cake" class="h-8 w-8 border border-primary-200 p-2 text-primary-700" />
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-surface-800 transition-colors group-hover:text-primary-700">{{ $category->name }}</span>
                        @if($category->products_count ?? null)
                            <span class="mt-1 text-xs text-surface-400">{{ $category->products_count }} produk</span>
                        @endif
                    </a>
                @empty
                    <div class="empty-state col-span-full">
                        <div class="empty-state-icon"><x-icon name="cake" class="h-7 w-7" /></div>
                        <p class="empty-state-title">Belum ada kategori</p>
                        <p class="empty-state-text">Kategori akan segera hadir.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured -->
    <section class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="section-title reveal">Pilihan Star Cake</h2>
                <p class="section-subtitle reveal reveal-delay-1">Kue terbaik kami, siap untuk momenmu.</p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($featured as $product)
                    <div class="reveal">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="empty-state col-span-full">
                        <div class="empty-state-icon"><x-icon name="gift" class="h-7 w-7" /></div>
                        <p class="empty-state-title">Belum ada produk unggulan</p>
                        <a href="{{ route('products.index') }}" class="btn-primary mt-2">Lihat Semua Produk</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Best sellers / New -->
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">
                <!-- Best Sellers -->
                <div>
                    <h2 class="section-title !text-xl sm:!text-2xl reveal">Terlaris</h2>
                    <ul class="mt-6 space-y-3">
                        @forelse($bestSellers as $index => $product)
                            <li class="reveal" style="transition-delay: {{ $index * 80 }}ms">
                                <a href="{{ route('product.show', $product->slug) }}"
                                    class="group flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-surface-200/60 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-primary/30">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                                        class="h-16 w-16 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105" />
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-semibold text-surface-800 transition-colors group-hover:text-primary-700">{{ $product->name }}</p>
                                        <p class="mt-0.5 text-sm font-medium text-primary-700">Rp {{ number_format($product->effectivePrice, 0, ',', '.') }}</p>
                                    </div>
                                    <x-icon name="chevron-right" class="h-5 w-5 shrink-0 text-surface-300 transition-all duration-300 group-hover:translate-x-1 group-hover:text-primary-600" />
                                </a>
                            </li>
                        @empty
                            <li class="empty-state">
                                <div class="empty-state-icon"><x-icon name="gift" class="h-6 w-6" /></div>
                                <p class="empty-state-title">Belum ada data</p>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- New Arrivals -->
                <div>
                    <h2 class="section-title !text-xl sm:!text-2xl reveal">Baru Tiba</h2>
                    <ul class="mt-6 space-y-3">
                        @forelse($newArrivals as $index => $product)
                            <li class="reveal" style="transition-delay: {{ $index * 80 }}ms">
                                <a href="{{ route('product.show', $product->slug) }}"
                                    class="group flex items-center gap-4 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-surface-200/60 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-primary/30">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
                                        class="h-16 w-16 shrink-0 rounded-xl object-cover transition-transform duration-300 group-hover:scale-105" />
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate font-semibold text-surface-800 transition-colors group-hover:text-primary-700">{{ $product->name }}</p>
                                        <p class="mt-0.5 text-sm font-medium text-primary-700">Rp {{ number_format($product->effectivePrice, 0, ',', '.') }}</p>
                                    </div>
                                    <x-icon name="chevron-right" class="h-5 w-5 shrink-0 text-surface-300 transition-all duration-300 group-hover:translate-x-1 group-hover:text-primary-600" />
                                </a>
                            </li>
                        @empty
                            <li class="empty-state">
                                <div class="empty-state-icon"><x-icon name="gift" class="h-6 w-6" /></div>
                                <p class="empty-state-title">Belum ada produk baru</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Delivery CTA -->
    <section class="relative overflow-hidden py-20">
        <div class="absolute inset-0 bg-ink"></div>

        <div class="relative mx-auto max-w-4xl px-5 text-center sm:px-6">
            <h2 class="reveal font-display text-3xl font-bold text-white sm:text-4xl">Gratis Antar Kota Bekasi</h2>
            <p class="reveal reveal-delay-1 mx-auto mt-4 max-w-2xl text-lg text-white/90">
                Kue Enak, <strong class="text-amber-200">Hati Senang</strong>.
            </p>
            <div class="reveal reveal-delay-2 mt-8 flex justify-center gap-4">
                <a href="{{ route('products.index') }}" class="btn-white">
                    Belanja Sekarang
                    <x-icon name="shopping-cart" class="h-5 w-5" />
                </a>
            </div>
        </div>
    </section>
@endsection
