@extends('layouts.admin')

@section('title', 'Live Chat')

@section('content')
<div class="space-y-5">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Live Chat</h1>
        <p class="text-sm text-surface-500">Percakapan langsung dengan pelanggan Star Cake.</p>
    </div>

    <div class="table-shell">
        <table class="w-full text-left text-sm">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Pesan Terakhir</th>
                    <th class="text-center">Belum Dibaca</th>
                    <th>Waktu</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($conversations as $conversation)
                    <tr class="{{ $conversation->admin_unread_count ? 'bg-primary-50/50 font-medium' : '' }}">
                        <td class="text-surface-800">
                            {{ $conversation->user->name ?? 'Pelanggan' }}
                            <span class="block text-xs text-surface-400">{{ $conversation->user->email ?? '' }}</span>
                        </td>
                        <td class="max-w-[260px] truncate text-surface-500">
                            {{ $conversation->latestMessage->body ?? '—' }}
                        </td>
                        <td class="text-center">
                            @if ($conversation->admin_unread_count)
                                <span class="badge badge-pending">{{ $conversation->admin_unread_count }}</span>
                            @else
                                <span class="text-surface-300">—</span>
                            @endif
                        </td>
                        <td class="text-surface-500">
                            {{ optional($conversation->last_message_at)->format('d M Y, H:i') ?? '—' }}
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.chat.show', $conversation) }}" title="Buka" aria-label="Buka percakapan" class="icon-btn">
                                    <x-icon name="eye" class="h-4 w-4" />
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="empty-cell">Belum ada percakapan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $conversations->links() }}</div>
</div>
@endsection
