@props([
    'action',
    'method' => 'DELETE',
    'title' => 'Hapus data?',
    'message' => 'Tindakan ini tidak dapat dibatalkan. Yakin ingin melanjutkan?',
    'confirmText' => 'Ya, Hapus',
    'cancelText' => 'Batal',
])
@php($uid = 'confirm-' . \Illuminate\Support\Str::random(8))
<div x-data="{ open: false }" class="inline">
    <button type="button" @click="open = true" {{ $attributes->merge(['class' => '']) }}>
        {{ $slot }}
    </button>

    <div x-show="open" x-cloak x-transition.opacity
        @keydown.escape.window="open = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4" role="dialog" aria-modal="true" aria-labelledby="{{ $uid }}-title">
        <div x-show="open" x-transition.scale.origin.center x-cloak
            class="card w-full max-w-sm animate-pop" @click.outside="open = false">
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-rose-100 text-rose-600">
                    <x-icon name="trash" class="h-5 w-5" />
                </span>
                <div class="min-w-0">
                    <h3 id="{{ $uid }}-title" class="font-display text-lg font-semibold text-surface-800">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-surface-500">{{ $message }}</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" @click="open = false" class="btn-outline">{{ $cancelText }}</button>
                <form method="POST" action="{{ $action }}" @submit="open = false">
                    @csrf
                    @method($method)
                    <button type="submit" class="btn-danger">
                        <x-icon name="trash" class="h-4 w-4" /> {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>