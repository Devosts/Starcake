<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-2xl font-bold text-surface-800">Masuk</h2>
        <p class="mt-1 text-sm text-surface-500">Selamat datang kembali di Star Cake 🍰</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="input mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-primary-700 hover:text-primary-800 hover:underline" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative mt-1">
                <input id="password" class="input block w-full pr-10" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                    <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                    <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2 text-sm text-surface-600">
            <input id="remember_me" type="checkbox" name="remember" class="input h-4 w-4 rounded border-surface-300 text-primary-600 focus:ring-primary-500">
            Ingat saya
        </label>

        <div class="flex items-center justify-between pt-1">
            <a href="{{ route('register') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800 hover:underline">Daftar akun baru</a>
            <x-primary-button>
                Masuk
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>