@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
@php($admin = auth('admin')->user())
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-surface-800">Profil Admin</h1>
        <p class="text-sm text-surface-500">Perbarui data akun admin kamu.</p>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6">
        @csrf @method('PUT')

        <!-- Account Info -->
        <div class="card card-pad">
            <div class="flex items-center gap-5">
                <span class="flex h-20 w-20 items-center justify-center bg-ink font-mono text-3xl font-medium text-paper">
                    {{ mb_substr($admin->name, 0, 1) }}
                </span>
                <div>
                    <h2 class="font-display text-lg font-semibold text-surface-800">Data Akun</h2>
                    <p class="text-xs text-surface-500">Nama dan email admin.</p>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="label" for="admin_name">Nama</label>
                    <input id="admin_name" type="text" name="name" value="{{ old('name', $admin->name) }}" required class="input {{ $errors->has('name') ? 'input-error' : '' }}" />
                    @error('name')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="admin_email">Email</label>
                    <input id="admin_email" type="email" name="email" value="{{ old('email', $admin->email) }}" required class="input {{ $errors->has('email') ? 'input-error' : '' }}" />
                    @error('email')<p class="field-error">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="card card-pad" x-data="{ show: false }">
            <div class="flex items-center gap-4">
                <span class="flex h-12 w-12 items-center justify-center border border-ink text-ink">
                    <x-icon name="lock" class="h-6 w-6" />
                </span>
                <div>
                    <h2 class="font-display text-lg font-semibold text-surface-800">Ganti Password <span class="text-xs font-normal text-surface-400">(opsional)</span></h2>
                    <p class="text-xs text-surface-500">Kosongkan jika tidak ingin mengganti.</p>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="label" for="admin_current_password">Password Saat Ini</label>
                    <input id="admin_current_password" type="password" name="current_password" autocomplete="current-password" placeholder="Wajib diisi jika mengganti password" class="input {{ $errors->has('current_password') ? 'input-error' : '' }}" />
                    @error('current_password')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="admin_password">Password Baru</label>
                    <div class="relative">
                        <input id="admin_password" :type="show ? 'text' : 'password'" name="password" autocomplete="new-password" placeholder="Kosongkan jika tidak ganti" class="input pr-11" />
                        <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                            <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                            <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                        </button>
                    </div>
                    @error('password')<p class="field-error">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="admin_password_confirmation">Konfirmasi Password</label>
                    <input id="admin_password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="input" />
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                <x-icon name="check" class="h-4 w-4" /> Perbarui Profil
            </button>
        </div>
    </form>
</div>
@endsection
