@extends('layouts.admin')

@section('title', 'Ulasan')

@section('content')
<div class="space-y-5">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Ulasan Pelanggan</h1>
        <p class="text-sm text-surface-500">Kelola ulasan yang tampil di halaman produk.</p>
    </div>

    <div class="table-shell">
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Pelanggan</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Status</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr class="group align-top">
                        <td>
                            <div class="flex items-center gap-2">
                                @if($review->product)
                                    <img src="{{ $review->product->image_url }}" alt="" class="h-8 w-8 rounded-lg object-cover ring-1 ring-surface-200" />
                                    <span class="font-medium text-surface-800">{{ $review->product->name }}</span>
                                @else
                                    <span class="text-surface-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-surface-600">{{ $review->user?->name ?? 'Pengunjung' }}</td>
                        <td>
                            <span class="inline-flex items-center gap-1 font-semibold text-amber-500">
                                <x-icon :name="'star'" class="h-4 w-4" />
                                {{ number_format($review->rating, 1) }}
                            </span>
                        </td>
                        <td class="max-w-[280px] whitespace-normal text-surface-500">{{ $review->comment }}</td>
                        <td>
                            <span class="badge {{ $review->is_approved ? 'badge-completed' : 'badge-pending' }}">
                                {{ $review->is_approved ? 'Tampil' : 'Menunggu' }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <form method="POST" action="{{ route('admin.reviews.update-status', $review) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="{{ $review->is_approved ? 'Sembunyikan' : 'Tampilkan' }}"
                                        aria-label="{{ $review->is_approved ? 'Sembunyikan ulasan' : 'Tampilkan ulasan' }}"
                                        class="icon-btn {{ $review->is_approved ? 'text-emerald-600' : 'text-surface-500' }}">
                                        <x-icon :name="'eye'" class="h-4 w-4" />
                                    </button>
                                </form>
                                <x-confirm-dialog
                                    :action="route('admin.reviews.destroy', $review)"
                                    title="Hapus ulasan?"
                                    message="Ulasan ini akan dihapus permanen."
                                    confirm-text="Ya, Hapus">
                                    <span class="icon-btn icon-btn-danger" title="Hapus" aria-label="Hapus ulasan">
                                        <x-icon name="trash" class="h-4 w-4" />
                                    </span>
                                </x-confirm-dialog>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="empty-cell">Belum ada ulasan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reviews->hasPages())
        <div>{{ $reviews->links() }}</div>
    @endif
</div>
@endsection