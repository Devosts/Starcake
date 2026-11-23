@extends('layouts.admin')

@section('title', $category->name)

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-surface-500 transition-colors hover:text-primary-700">
                <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Kategori
            </a>
            <h1 class="mt-1 font-display text-2xl font-bold text-surface-800">{{ $category->name }}</h1>
            <span class="mt-1 inline-block badge {{ $category->is_active ? 'badge-completed' : 'badge-unpaid' }}">{{ $category->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-primary">
            <x-icon name="pencil" class="h-4 w-4" /> Edit Kategori
        </a>
    </div>

    <div class="card card-pad">
        <dl class="grid grid-cols-1 gap-4 text-sm sm:grid-cols-3">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Slug</dt>
                <dd class="mt-0.5 font-mono text-surface-700">{{ $category->slug }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Jumlah Produk</dt>
                <dd class="mt-0.5 font-semibold text-surface-800">{{ $category->products()->count() }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Urutan</dt>
                <dd class="mt-0.5 text-surface-700">{{ $category->sort_order ?? 0 }}</dd>
            </div>
            @if($category->description)
                <div class="sm:col-span-3">
                    <dt class="text-xs font-semibold uppercase tracking-wide text-surface-400">Deskripsi</dt>
                    <dd class="mt-0.5 leading-relaxed text-surface-600">{{ $category->description }}</dd>
                </div>
            @endif
        </dl>
    </div>

    <div class="card card-pad">
        <h2 class="font-display text-lg font-semibold text-surface-800">Produk dalam kategori ini</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($category->products as $p)
                <a href="{{ route('admin.products.show', $p) }}"
                    class="group overflow-hidden rounded-2xl border border-surface-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-primary/20">
                    <img src="{{ $p->image_url }}" alt="{{ $p->name }}" class="h-32 w-full object-cover" />
                    <div class="p-3">
                        <p class="font-medium text-surface-800 group-hover:text-primary-700">{{ $p->name }}</p>
                        <p class="text-sm font-semibold text-primary-700">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @empty
                <div class="empty-state sm:col-span-3">
                    <div class="empty-state-icon"><x-icon name="box" class="h-6 w-6" /></div>
                    <p class="empty-state-title">Belum ada produk</p>
                    <p class="empty-state-text">Tambahkan produk ke kategori ini untuk tampil di katalog.</p>
                    <a href="{{ route('admin.products.create') }}" class="btn-primary mt-1">Tambah Produk</a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection