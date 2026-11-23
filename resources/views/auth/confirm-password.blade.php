<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-2xl font-bold text-surface-800">Area Terproteksi</h2>
        <p class="mt-1 text-sm text-surface-500">Konfirmasi password untuk melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div x-data="{ show: false }">
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-1">
                <input id="password" class="input block w-full pr-10" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Password kamu" />
                <button type="button" @click="show = !show" :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-surface-400 transition-colors hover:text-primary-700">
                    <x-icon name="eye" x-show="!show" class="h-4 w-4" />
                    <x-icon name="eye-off" x-show="show" class="h-4 w-4" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            Konfirmasi
        </x-primary-button>
    </form>
</x-guest-layout>