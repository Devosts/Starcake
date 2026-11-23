<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $cart = $this->recalculateCart(session()->get('cart', []));

        if (empty($cart)) {
            session()->forget('cart');

            return redirect()->route('cart');
        }

        session()->put('cart', $cart);

        if ($request->isMethod('GET')) {
            $subtotal = $this->cartTotal($cart);
            $deliveryFee = $this->calculateDeliveryFee($subtotal);
            $taxRate = (float) Setting::get('tax_rate', 0);
            $tax = round($subtotal * $taxRate / 100, 2);

            return view('checkout', [
                'cart' => $cart,
                'cartTotal' => $subtotal,
                'deliveryFee' => $deliveryFee,
                'tax' => $tax,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'customer_address' => ['required', 'string'],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time_slot' => ['required', 'string'],
            'payment_method' => ['required', 'in:cod'],
            'delivery_type' => ['required', 'in:delivery'],
            'notes' => ['nullable', 'string'],
        ]);

        $validator->after(function ($validator) use ($cart) {
            foreach ($cart as $item) {
                $product = Product::where('id', $item['product_id'])->where('is_active', true)->first();
                if (! $product || $product->stock < $item['quantity']) {
                    $validator->errors()->add(
                        'quantity',
                        'Stok tidak tersedia untuk '.($product ? $product->name : 'sebuah produk').'. Silakan perbarui keranjang.'
                    );
                }
            }
        });

        $validated = $validator->validate();

        $subtotal = $this->cartTotal($cart);
        $deliveryFee = $this->calculateDeliveryFee($subtotal);
        $taxRate = (float) Setting::get('tax_rate', 0);
        $tax = round($subtotal * $taxRate / 100, 2);
        $total = $subtotal + $deliveryFee + $tax;

        $order = DB::transaction(function () use ($validated, $cart, $subtotal, $deliveryFee, $tax, $total) {
            $order = Order::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'order_number' => 'TEMP-'.Str::random(10),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'delivery_type' => $validated['delivery_type'],
                'delivery_fee' => $deliveryFee,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => 0,
                'total' => $total,
                'scheduled_date' => $validated['scheduled_date'],
                'scheduled_time_slot' => $validated['scheduled_time_slot'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Generate proper order number using the actual ID
            $orderNumber = 'STR-'.now()->format('ymd').'-'.str_pad((string) $order->id, 4, '0', STR_PAD_LEFT);
            $order->update(['order_number' => $orderNumber]);

            foreach ($cart as $item) {
                $product = Product::where('id', $item['product_id'])->where('is_active', true)->lockForUpdate()->first();

                if (! $product || $product->stock < $item['quantity']) {
                    throw new \Exception('Stok tidak tersedia untuk '.($product ? $product->name : 'sebuah produk').'. Silakan perbarui keranjang.');
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'notes' => $item['note'] ?? null,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            OrderHistory::create([
                'order_id' => $order->id,
                'status' => 'pending',
                'title' => 'Pesanan Diterima',
                'note' => 'Pesanan baru saja diterima.',
                'created_by' => $order->user_id ? 'customer' : 'guest',
            ]);

            return $order;
        });

        session()->forget('cart');
        session()->put('completed_order_id', $order->id);

        return redirect()->route('checkout.confirmation', $order->order_number);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')->firstOrFail();

        $isOwner = Auth::check() && $order->user_id === Auth::id();
        $isRecentCheckout = session('completed_order_id') === $order->id;

        abort_unless($isOwner || $isRecentCheckout, 404);

        return view('checkout-confirmation', compact('order'));
    }

    private function cartTotal(array $cart): float
    {
        return collect($cart)->reduce(fn ($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
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
            $item['name'] = $product->name;
            $item['image'] = $product->image;
            $item['quantity'] = max(1, min((int) $item['quantity'], $product->stock));
        }

        return $cart;
    }

    private function calculateDeliveryFee(float $subtotal): float
    {
        $freeThreshold = (float) Setting::get('free_delivery_min', 150000);
        $baseFee = (float) Setting::get('delivery_fee', 15000);

        return $subtotal >= $freeThreshold ? 0 : $baseFee;
    }
}
