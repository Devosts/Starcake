<x-guest-layout>
    <div class="flex flex-col items-center text-center">
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10">
            <x-icon name="mail" class="h-7 w-7 text-primary-600" />
        </div>
        <h2 class="mt-4 font-display text-2xl font-bold text-surface-800">Verifikasi Email</h2>
        <p class="mt-2 text-sm text-surface-500">
            Terima kasih sudah mendaftar! Sebelum mulai, verifikasi email kamu lewat link yang kami kirim. Belum terima? Kami kirim ulang.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            Link verifikasi baru telah dikirim ke email kamu.
        </div>
    @endif

    <div class="mt-6 flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-secondary-button type="submit">
                Keluar
            </x-secondary-button>
        </form>
    </div>
</x-guest-layout>