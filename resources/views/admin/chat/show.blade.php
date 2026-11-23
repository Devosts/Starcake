@extends('layouts.admin')

@section('title', 'Chat — ' . ($conversation->user->name ?? 'Pelanggan'))

@section('content')
<div class="mx-auto max-w-3xl space-y-5">
    <div>
        <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-surface-500 transition-colors hover:text-primary-700">
            <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Live Chat
        </a>
        <h1 class="mt-1 font-display text-2xl font-bold text-surface-800">{{ $conversation->user->name ?? 'Pelanggan' }}</h1>
        <p class="text-sm text-surface-500">{{ $conversation->user->email ?? '' }}</p>
    </div>

    @php
        $seed = $messages->map->toBroadcastArray()->all();
    @endphp

    <x-chat-widget
        :channel="'conversation.' . $conversation->id"
        my-role="admin"
        :send-url="route('admin.chat.send', $conversation)"
        :read-url="route('admin.chat.read', $conversation)"
        :seed="$seed"
        title="{{ $conversation->user->name ?? 'Pelanggan' }}"
        hint="Belum ada pesan dari pelanggan ini."
    />
</div>
@endsection
