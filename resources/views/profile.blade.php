@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="font-display text-3xl font-bold text-surface-800">Profil Saya</h1>
    <p class="mt-1 text-sm text-surface-500">Perbarui data akun dan password kamu.</p>

    @if(session('success'))
        <div class="mt-6 flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            <x-icon name="check" class="h-4 w-4 shrink-0" /> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mt-6 rounded-xl border border-rose-200 bg-rose-50 p-4">
            <p class="text-sm font-semibold text-rose-800">Ada yang perlu diperbaiki:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-rose-700">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf @method('PATCH')

        <div class="card card-pad">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center bg-ink font-mono text-lg font-medium text-paper">
                    {{ mb_substr($user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="font-display text-lg font-semibold text-surface-800">Data Akun</h2>
                    <p class="text-xs text-surface-500">Informasi dasar kamu.</p>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="label" for="name">Nama Lengkap *</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="input {{ $errors->has('name') ? 'input-error' : '' }}" />
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="email">Email *</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="input {{ $errors->has('email') ? 'input-error' : '' }}" />
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="phone">No. WhatsApp / Telepon</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="input" />
                </div>
                <div class="sm:col-span-2">
                    <label class="label" for="address">Alamat Lengkap</label>
                    <textarea id="address" name="address" rows="3" class="input resize-y">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>
        </div>

        <div class="card card-pad">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-secondary-500/10 text-secondary-500">
                    <x-icon name="lock" class="h-6 w-6" />
                </div>
                <div>
                    <h2 class="font-display text-lg font-semibold text-surface-800">Ganti Password <span class="text-xs font-normal text-surface-400">(opsional)</span></h2>
                    <p class="text-xs text-surface-500">Kosongkan jika tidak ingin mengganti.</p>
                </div>
            </div>
            <div class="mt-5 grid grid-cols-1 gap-4">
                <div x-data="{ show: false }">
                    <label class="label" for="current_password">Password Saat Ini</label>
                    <div class="relative">
                        <input id="current_password" :type="show ? 'text' : 'password'" name="current_password" autocomplete="current-password" class="input pr-11 {{ $errors->has('current_password') ? 'input-error' : '' }}" />
                        <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                            <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                            <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                        </button>
                    </div>
                    @error('current_password')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div x-data="{ show: false }">
                        <label class="label" for="password">Password Baru</label>
                        <div class="relative">
                            <input id="password" :type="show ? 'text' : 'password'" name="password" autocomplete="new-password" class="input pr-11" />
                            <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                                <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                                <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                            </button>
                        </div>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="input" />
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-surface-500 transition-colors hover:text-primary-700">
                <x-icon name="arrow-left" class="h-4 w-4" /> Kembali ke Dashboard
            </a>
            <button type="submit" class="btn-primary">
                <x-icon name="save" class="h-4 w-4" /> Simpan Profil
            </button>
        </div>
    </form>
</div>
@endsection