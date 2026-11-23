<x-guest-layout>
    <div class="mb-6">
        <h2 class="font-display text-2xl font-bold text-surface-800">Lupa Password</h2>
        <p class="mt-1 text-sm text-surface-500">Tenang saja! Masukkan email kamu, kami kirim link reset password.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <input id="email" class="input mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="w-full">
            Kirim Link Reset
        </x-primary-button>

        <p class="text-center">
            <a href="{{ route('login') }}" class="text-sm font-medium text-primary-700 hover:text-primary-800 hover:underline">← Kembali ke halaman masuk</a>
        </p>
    </form>
</x-guest-layout>