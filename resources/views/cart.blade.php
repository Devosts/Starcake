@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="mx-auto max-w-5xl px-5 py-12 sm:px-6 lg:px-8" x-data="cartPage()">
    @php
        $cart = session('cart', []);
        $subtotal = 0;
        $itemCount = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }
    @endphp

    @if(empty($cart))
        <div class="empty-state mx-auto max-w-md py-24">
            <div class="empty-state-icon">
                <x-icon name="cart" class="h-8 w-8" />
            </div>
            <p class="empty-state-title">Keranjang belanjamu masih kosong</p>
            <p class="empty-state-text">Yuk, isi dengan kue favoritmu untuk momen spesialmu!</p>
            <a href="{{ route('products.index') }}" class="btn-primary mt-3">
                <x-icon name="shopping-cart" class="h-4 w-4" />
                Lihat Menu
            </a>
        </div>
    @else
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-display text-3xl font-bold tracking-tight text-surface-800">Keranjang Belanja</h1>
                <p class="mt-1 text-sm text-surface-500">{{ $itemCount }} item di keranjangmu</p>
            </div>
        </div>

        <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <form id="update-form" method="POST" action="{{ route('cart.update') }}">
                    @csrf @method('PATCH')
                    <div class="card divide-y divide-surface-100">
                        @foreach($cart as $key => $item)
                            @php $product = \App\Models\Product::find($item['product_id']); @endphp
                            <div class="flex flex-wrap items-center gap-4 p-4 sm:flex-nowrap sm:p-5"
                                 x-data="cartItem({{ $item['quantity'] }}, {{ $item['price'] }}, {{ $product ? $product->stock : 99 }})">
                                <!-- Image -->
                                <a href="{{ $product ? route('product.show', $product->slug) : route('products.index') }}" class="shrink-0">
                                    <img src="{{ $product ? $product->image_url : asset('images/placeholder-product.svg') }}" alt="{{ $item['name'] }}"
                                        class="h-20 w-20 rounded-xl object-cover transition-transform duration-300 hover:scale-105" loading="lazy" />
                                </a>

                                <!-- Info -->
                                <div class="min-w-0 flex-1">
                                    <a href="{{ $product ? route('product.show', $product->slug) : '#' }}"
                                        class="font-semibold text-surface-800 transition-colors hover:text-primary-700">
                                        {{ $item['name'] }}
                                    </a>
                                    <p class="mt-0.5 text-sm text-surface-500">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </p>
                                    @if($item['note'])
                                        <p class="mt-1 text-xs text-surface-400 italic">"{{ $item['note'] }}"</p>
                                    @endif
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center">
                                    <div class="qty-control">
                                        <button type="button" @click="dec()" class="qty-btn" aria-label="Kurangi jumlah">
                                            <x-icon name="minus" class="h-4 w-4" />
                                        </button>
                                        <input x-ref="qtyInput" type="number" name="quantities[{{ $key }}]"
                                            :value="qty" min="1" max="{{ $product ? $product->stock : 99 }}"
                                            class="sr-only" />
                                        <span class="qty-value" x-text="qty"></span>
                                        <button type="button" @click="inc()" class="qty-btn" aria-label="Tambah jumlah">
                                            <x-icon name="plus" class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>

                                <!-- Line Total -->
                                <span class="w-28 shrink-0 text-right font-semibold text-primary-700">
                                    Rp <span x-text="formatPrice(qty * {{ $item['price'] }})"></span>
                                </span>

                                <!-- Delete -->
                                <button type="submit" form="remove-{{ $key }}"
                                    onclick="return confirm('Hapus {{ $item['name'] }} dari keranjang?')"
                                    aria-label="Hapus {{ $item['name'] }}"
                                    class="icon-btn icon-btn-danger shrink-0" title="Hapus item">
                                    <x-icon name="trash" class="h-4 w-4" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                </form>

                @foreach($cart as $key => $item)
                    <form id="remove-{{ $key }}" method="POST" action="{{ route('cart.remove', $key) }}" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                @endforeach

                <!-- Actions -->
                <div class="mt-4 flex items-center justify-between">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary-700 transition-colors hover:text-primary-800">
                        <x-icon name="arrow-left" class="h-4 w-4" />
                        Lanjut belanja
                    </a>
                    <form id="clear-form" method="POST" action="{{ route('cart.clear') }}">
                        @csrf @method('DELETE')
                        <button type="button" onclick="if(confirm('Kosongkan seluruh keranjang?')) this.form.requestSubmit();"
                            class="text-sm font-medium text-rose-500 transition-colors hover:text-rose-600">
                            Kosongkan Keranjang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Summary (Desktop) -->
            <div class="hidden lg:block">
                <div class="card card-pad lg:sticky lg:top-24">
                    <h2 class="font-display text-lg font-semibold text-surface-800">Ringkasan</h2>
                    <div class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between text-surface-600">
                            <span>Subtotal ({{ $itemCount }} item)</span>
                            <span class="font-medium text-surface-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-surface-600">
                            <span>Ongkir</span>
                            <span class="text-surface-400">Dihitung saat checkout</span>
                        </div>
                        <div class="flex justify-between border-t border-surface-100 pt-3 text-base font-bold text-surface-800">
                            <span>Total</span>
                            <span class="text-primary-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout') }}" class="btn-primary mt-5 w-full justify-center">
                        Lanjutkan ke Checkout
                        <x-icon name="chevron-right" class="h-4 w-4" />
                    </a>
                    <p class="mt-3 text-center text-xs text-surface-400">
                        <x-icon name="shield-check" class="mb-0.5 inline h-3.5 w-3.5" />
                        Pembayaran aman â€” konfirmasi via WhatsApp
                    </p>
                </div>
            </div>
        </div>

        <!-- Sticky Mobile Summary -->
        <div class="fixed bottom-0 left-0 right-0 z-30 border-t border-surface-200 bg-white/95 px-5 py-4 shadow-elevated lg:hidden">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs text-surface-500">Total</p>
                    <p class="text-lg font-bold text-primary-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                </div>
                <a href="{{ route('checkout') }}" class="btn-primary flex-1 justify-center sm:flex-none">
                    Checkout
                    <x-icon name="chevron-right" class="h-4 w-4" />
                </a>
            </div>
        </div>

        <!-- Spacer for mobile sticky bar -->
        <div class="h-20 lg:hidden"></div>
    @endif
</div>

@push('head')
<script>
function cartPage() {
    return {
        formatPrice(num) {
            return Number(num).toLocaleString('id-ID');
        }
    };
}

function cartItem(initialQty, price, maxStock) {
    return {
        qty: initialQty,
        price: price,
        max: maxStock,
        inc() {
            if (this.qty < this.max) {
                this.qty++;
                this.autoSubmit();
            }
        },
        dec() {
            if (this.qty > 1) {
                this.qty--;
                this.autoSubmit();
            }
        },
        autoSubmit() {
            this.$refs.qtyInput.value = this.qty;
            clearTimeout(this._timer);
            this._timer = setTimeout(() => {
                document.getElementById('update-form').requestSubmit();
            }, 600);
        }
    };
}
</script>
@endpush
@endsection
