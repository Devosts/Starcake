<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->recalculateCart($this->getCart());
        $this->saveCart($cart);

        return view('cart', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        if (! $product->is_active) {
            return back()->with('error', 'Produk tidak tersedia.');
        }

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        if ($product->stock < $request->input('quantity')) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = $this->getCart();
        $key = 'product_'.$product->id;

        if (isset($cart[$key])) {
            $newQuantity = $cart[$key]['quantity'] + $request->input('quantity');
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $cart[$key]['quantity'] = $newQuantity;
            $cart[$key]['note'] = $request->input('note');
            $cart[$key]['price'] = (float) $product->effectivePrice;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => (float) $product->effectivePrice,
                'quantity' => $request->input('quantity'),
                'note' => $request->input('note'),
            ];
        }

        $this->saveCart($cart);

        return back()->with('success', $product->name.' ditambahkan ke keranjang.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantities' => ['required', 'array'],
        ]);

        $cart = $this->getCart();
        foreach ((array) $request->input('quantities') as $key => $qty) {
            if (isset($cart[$key])) {
                $qty = max(1, (int) $qty);
                $product = Product::where('id', $cart[$key]['product_id'])->where('is_active', true)->first();
                if (! $product) {
                    unset($cart[$key]);

                    continue;
                }
                if ($product->stock < $qty) {
                    return back()->with('error', 'Stok untuk '.$product->name.' tidak mencukupi.');
                }
                $cart[$key]['quantity'] = $qty;
                $cart[$key]['price'] = (float) $product->effectivePrice;
                $cart[$key]['name'] = $product->name;
                $cart[$key]['image'] = $product->image;
            }
        }
        $this->saveCart($cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request, string $key)
    {
        $cart = $this->getCart();
        unset($cart[$key]);
        $this->saveCart($cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang dikosongkan.');
    }

    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    private function recalculateCart(array $cart): array
    {
        $productIds = collect($cart)->pluck('product_id')->unique()->filter()->values()->all();
        $products = Product::whereIn('id', $productIds)->where('is_active', true)->get()->keyBy('id');

        foreach ($cart as $key => &$item) {
            $product = $products->get($item['product_id']);
            if (! $product || $product->stock < 1) {
                unset($cart[$key]);

                continue;
            }
            $item['price'] = (float) $product->effectivePrice;
            $item['image'] = $product->image;
            $item['name'] = $product->name;
            if ($item['quantity'] > $product->stock) {
                $item['quantity'] = $product->stock;
            }
        }

        return $cart;
    }

    public function count()
    {
        $count = collect(session()->get('cart', []))
            ->reduce(fn ($carry, $item) => $carry + $item['quantity'], 0);

        return response()->json(['count' => $count]);
    }
}
