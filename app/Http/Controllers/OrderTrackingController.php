<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function __invoke(Request $request)
    {
        $order = null;
        $error = null;

        if ($request->filled('order_number') || $request->route('order')) {
            $number = $request->input('order_number') ?: $request->route('order');
            $order = Order::where('order_number', $number)
                ->with(['items', 'histories'])->first();
            if (! $order) {
                $error = 'Nomor pesanan tidak ditemukan. Pastikan nomor pesanan benar.';
            }
        }

        return view('tracking', compact('order', 'error'));
    }
}
