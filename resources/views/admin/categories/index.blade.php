@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="font-display text-2xl font-bold text-surface-800">Kategori Kue</h1>
            <p class="text-sm text-surface-500">Atur kategori untuk katalog produk.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <x-icon name="plus" class="h-4 w-4" /> Tambah Kategori
        </a>
    </div>

    <div class="table-shell">
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th class="text-center">Produk</th>
                    <th class="text-center">Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="group">
                        <td>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="flex items-center gap-3">
                                @if($category->image)
                                    <img src="{{ str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-10 w-10 rounded-lg object-cover ring-1 ring-surface-200" />
                                @else
                                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary-600">
                                        <x-icon name="cake" class="h-5 w-5" />
                                    </span>
                                @endif
                                <span class="font-medium text-surface-800 group-hover:text-primary-700">{{ $category->name }}</span>
                            </a>
                        </td>
                        <td class="font-mono text-surface-500">{{ $category->slug }}</td>
                        <td class="text-center text-surface-600">{{ $category->products_count }}</td>
                        <td class="text-center">
                            <span class="badge {{ $category->is_active ? 'badge-completed' : 'badge-unpaid' }}">
                                {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.categories.edit', $category) }}" title="Edit" aria-label="Edit kategori" class="icon-btn">
                                    <x-icon name="pencil" class="h-4 w-4" />
                                </a>
                                <x-confirm-dialog
                                    :action="route('admin.categories.destroy', $category)"
                                    title="Hapus kategori?"
                                    message="Kategori {{ $category->name }} akan dihapus permanen."
                                    confirm-text="Ya, Hapus">
                                    <span class="icon-btn icon-btn-danger" title="Hapus" aria-label="Hapus kategori">
                                        <x-icon name="trash" class="h-4 w-4" />
                                    </span>
                                </x-confirm-dialog>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-cell">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $categories->links() }}</div>
</div>
@endsection