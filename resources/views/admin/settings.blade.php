@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
@php
    $rows = collect($setting_rows ?? []);
    $groups = $rows->groupBy(fn ($s) => $s->group ?: 'general');
    $groupLabels = [
        'general' => ['title' => 'Umum', 'icon' => 'settings', 'desc' => 'Informasi dasar toko.'],
        'site' => ['title' => 'Situs', 'icon' => 'settings', 'desc' => 'Nama, logo, dan favicon situs.'],
        'contact' => ['title' => 'Kontak', 'icon' => 'phone', 'desc' => 'Nomor yang ditampilkan pelanggan.'],
        'social' => ['title' => 'Media Sosial', 'icon' => 'instagram', 'desc' => 'Tautan media sosial toko.'],
        'delivery' => ['title' => 'Pengiriman', 'icon' => 'location', 'desc' => 'Biaya dan minimum gratis ongkir.'],
        'shop' => ['title' => 'Toko', 'icon' => 'box', 'desc' => 'Ongkir & pengaturan belanja.'],
    ];
@endphp
<div class="space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Pengaturan Website</h1>
        <p class="text-sm text-surface-500">Atur informasi yang tampil di seluruh website.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf @method('PUT')

        @foreach($groups as $group => $items)
            @php($meta = $groupLabels[$group] ?? ['title' => ucfirst($group), 'icon' => 'settings', 'desc' => ''])
            <div class="card card-pad">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 items-center justify-center bg-ink text-paper">
                        <x-icon :name="$meta['icon']" class="h-5 w-5" />
                    </span>
                    <div>
                        <h2 class="font-display text-lg font-semibold text-surface-800">{{ $meta['title'] }}</h2>
                        @if($meta['desc'])<p class="text-xs text-surface-500">{{ $meta['desc'] }}</p>@endif
                    </div>
                </div>
                <div class="mt-5 space-y-4">
                    @foreach($items as $s)
                        <div class="grid grid-cols-1 gap-1.5 sm:grid-cols-3 sm:items-center">
                            <input type="hidden" name="groups[{{ $s->key }}]" value="{{ $s->group ?: 'general' }}" />
                            <label class="text-sm font-medium text-surface-700 sm:col-span-1">{{ $s->label ?: $s->key }}</label>
                            <div class="sm:col-span-2">
                                @php($isBool = $s->type === 'boolean')
                                @if($isBool)
                                    <label class="inline-flex cursor-pointer items-center gap-2 text-sm text-surface-600">
                                        <input type="checkbox" name="settings[{{ $s->key }}]" value="1" {{ (bool)$s->value ? 'checked' : '' }} class="h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500" />
                                        Aktif
                                    </label>
                                @else
                                    <input type="{{ $s->type === 'number' ? 'number' : ($s->type === 'email' ? 'email' : 'text') }}" name="settings[{{ $s->key }}]"
                                        value="{{ $s->value }}" class="input" />
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="h-4 w-4" /> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
