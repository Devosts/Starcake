@php
    $settings = $settings ?? [];
    $wa = $settings['whatsapp_number'] ?? '6281234567890';
    $instagram = $settings['instagram_url'] ?? '#';
    $facebook = $settings['facebook_url'] ?? '#';
    $waLink = 'https://wa.me/' . preg_replace('/^0/', '62', $wa);
@endphp

{{-- Colophon: ink ground, paper type, hairline rules. No cards. --}}
<footer class="mt-24 border-t-2 border-accent bg-ink text-paper">
    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 lg:px-8">

        {{-- Nameplate + tagline --}}
        <div class="grid grid-cols-1 gap-x-10 gap-y-12 lg:grid-cols-12">
            <div class="lg:col-span-4">
                <p class="font-display text-4xl font-medium leading-none tracking-tight">
                    {{ config('app.name', 'Star Cake') }}
                </p>
                <p class="mt-4 max-w-sm text-lede text-paper/70">
                    Kue Enak, Hati Senang. Kue handmade yang dibuat segar setiap hari
                    dengan bahan pilihan.
                </p>
                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn-white mt-7">
                    <x-icon name="phone" class="h-4 w-4" />
                    Pesan via WhatsApp
                </a>
            </div>

            {{-- Index --}}
            <div class="lg:col-span-2">
                <h3 class="colophon-heading border-b border-paper/20 pb-3">Halaman</h3>
                <ul class="mt-4 space-y-1">
                    <li><a href="{{ route('home') }}" class="colophon-link text-paper/70 hover:text-accent">Beranda</a></li>
                    <li><a href="{{ route('products.index') }}" class="colophon-link text-paper/70 hover:text-accent">Menu</a></li>
                    <li><a href="{{ route('about') }}" class="colophon-link text-paper/70 hover:text-accent">Tentang</a></li>
                    <li><a href="{{ route('tracking') }}" class="colophon-link text-paper/70 hover:text-accent">Lacak Pesanan</a></li>
                    <li><a href="{{ route('contact') }}" class="colophon-link text-paper/70 hover:text-accent">Kontak</a></li>
                </ul>
            </div>

            {{-- Toko --}}
            <div class="lg:col-span-3">
                <h3 class="colophon-heading border-b border-paper/20 pb-3">Toko</h3>
                <ul class="mt-4 space-y-3 font-mono text-data text-paper/70">
                    <li class="flex items-start gap-2.5">
                        <x-icon name="location" class="mt-0.5 h-4 w-4 shrink-0 text-accent" />
                        <span>{{ $settings['address'] ?? 'Jl. Kue Indah No. 1, Jakarta' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-icon name="clock" class="mt-0.5 h-4 w-4 shrink-0 text-accent" />
                        <span>{{ $settings['operating_hours'] ?? '08.00 - 20.00' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-icon name="phone" class="mt-0.5 h-4 w-4 shrink-0 text-accent" />
                        <span>{{ $settings['phone'] ?? '' }}</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <x-icon name="mail" class="mt-0.5 h-4 w-4 shrink-0 text-accent" />
                        <span class="break-all">{{ $settings['email'] ?? 'info@starcake.com' }}</span>
                    </li>
                </ul>
            </div>

            {{-- Newsletter + socials --}}
            <div class="lg:col-span-3">
                <h3 class="colophon-heading border-b border-paper/20 pb-3">Newsletter</h3>
                <p class="mt-4 text-body text-paper/70">Dapatkan info diskon &amp; menu baru.</p>
                <form method="POST" action="#" class="mt-4 flex">
                    <input type="email" name="email" required placeholder="email@contoh.com"
                        class="input !border-paper/30 !bg-transparent !text-paper placeholder:!text-paper/40 focus:!border-accent" />
                    <button type="submit" class="btn-white shrink-0 !border-l-0 !px-4">Kirim</button>
                </form>
                <div class="mt-6 flex gap-2">
                    <a href="{{ $instagram }}" target="_blank" rel="noopener" aria-label="Instagram"
                        class="flex h-10 w-10 items-center justify-center border border-paper/25 text-paper/70 transition-colors hover:border-accent hover:bg-accent hover:text-ink">
                        <x-icon name="instagram" class="h-4 w-4" />
                    </a>
                    <a href="{{ $facebook }}" target="_blank" rel="noopener" aria-label="Facebook"
                        class="flex h-10 w-10 items-center justify-center border border-paper/25 text-paper/70 transition-colors hover:border-accent hover:bg-accent hover:text-ink">
                        <x-icon name="facebook" class="h-4 w-4" />
                    </a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" aria-label="WhatsApp"
                        class="flex h-10 w-10 items-center justify-center border border-paper/25 text-paper/70 transition-colors hover:border-accent hover:bg-accent hover:text-ink">
                        <x-icon name="phone" class="h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>

        {{-- Imprint --}}
        <div class="mt-16 flex flex-col gap-3 border-t border-paper/20 pt-6 sm:flex-row sm:items-center sm:justify-between">
            <p class="font-mono text-label uppercase tracking-[0.14em] text-paper/50">
                &copy; {{ date('Y') }} {{ config('app.name', 'Star Cake') }} — Jakarta
            </p>
            <p class="font-mono text-label uppercase tracking-[0.14em] text-paper/50">
                Kue Handmade - Dirumah
            </p>
        </div>
    </div>
</footer>
