<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-2xl font-bold text-surface-800">Reset Password</h2>
        <p class="mt-1 text-sm text-surface-500">Buat password baru untuk akunmu.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="input mt-1 block w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password Baru')" />
            <div class="relative mt-1">
                <input id="password" class="input block w-full pr-10" :type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                    <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                    <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <div class="relative mt-1">
                <input id="password_confirmation" class="input block w-full pr-10" :type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password" />
                <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                    <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                    <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            Reset Password
        </x-primary-button>
    </form>
</x-guest-layout>