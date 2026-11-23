@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="mb-10 text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Star Cake" class="mx-auto h-20 w-auto drop-shadow-sm" />
        <h1 class="mt-4 font-display text-4xl font-bold text-surface-800">Tentang Star Cake</h1>
        <p class="mt-2 font-display text-xl text-primary-700">Kue Enak, Hati Senang</p>
    </div>

    <div class="grid grid-cols-1 items-center gap-10 md:grid-cols-2">
        <div class="group overflow-hidden rounded-3xl shadow-lg shadow-surface-300/40 ring-1 ring-surface-200">
            <img src="https://picsum.photos/seed/starcake-about/600/600" alt="Kue buatan Star Cake"
                class="aspect-square w-full object-cover transition-transform duration-500 group-hover:scale-105" />
        </div>
        <div class="space-y-5 leading-relaxed text-surface-600">
            <p>
                Star Cake lahir dari kecintaan pada kue tradisional dan inovasi rasa modern. Kami
                memakai bahan pilihan dengan proses yang telah teruji.
            </p>
            <p>
                Setiap kue kami dibikin segar setiap hari, dengan proses yang higienis dan penuh cinta.
                Kami bangga menyajikan kue untuk momen istimewa setiap klien kami.
            </p>
            <div class="flex items-center gap-3 rounded-2xl border border-primary-200 bg-primary-50/60 p-4">
                <x-icon name="heart" class="h-6 w-6 shrink-0 text-secondary-500" />
                <p class="font-medium text-primary-800">Bergabunglah bersama ribuan pelanggan bahagia kami!</p>
            </div>
        </div>
    </div>

    <div class="mt-14 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="card card-pad text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center bg-ink text-paper">
                <x-icon name="cake" class="h-7 w-7" />
            </div>
            <h3 class="mt-3 font-display text-2xl font-medium text-ink">10+ Tahun</h3>
            <p class="text-sm text-surface-500">Pengalaman</p>
        </div>
        <div class="card card-pad text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center bg-accent text-ink">
                <x-icon name="gift" class="h-7 w-7" />
            </div>
            <h3 class="mt-3 font-display text-2xl font-medium text-ink">1000+</h3>
            <p class="text-sm text-surface-500">Pesanan Selesai</p>
        </div>
        <div class="card card-pad text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center border border-ink text-ink">
                <x-icon name="heart" class="h-7 w-7" />
            </div>
            <h3 class="mt-3 font-display text-2xl font-medium text-ink">100%</h3>
            <p class="text-sm text-surface-500">Puas Pelanggan</p>
        </div>
    </div>

    <div class="mt-14 text-center">
        <h2 class="font-display text-2xl font-bold text-surface-800">Siap mencicipi kue kami?</h2>
        <p class="mt-2 text-surface-500">Pesan kue handmade premium untuk momen spesialmu.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('products.index') }}" class="btn-primary">Lihat Menu</a>
            <a href="{{ route('contact') }}" class="btn-outline">Hubungi Kami</a>
        </div>
    </div>
</div>
@endsection