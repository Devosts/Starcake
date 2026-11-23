<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-2xl font-bold text-surface-800">Buat Akun</h2>
        <p class="mt-1 text-sm text-surface-500">Bergabung untuk berbelanja &amp; melacak pesananmu.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <input id="name" class="input mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama kamu" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="input mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
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

        <div class="flex items-center justify-between pt-1">
            <a href="{{ route('login') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800 hover:underline">Sudah punya akun?</a>
            <x-primary-button>
                Daftar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>