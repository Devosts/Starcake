<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status');

        $orders = Order::with('items')
            ->when($filter && $filter !== 'all', fn ($q) => $q->where('status', $filter))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());

        $statusCounts = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('admin.orders.index', compact('orders', 'statusCounts', 'filter'));
    }

    public function show(Order $order, Request $request)
    {
        $order->load(['items.product', 'user', 'histories']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,completed,cancelled'],
            'note' => ['nullable', 'string'],
        ]);

        $newStatus = $validated['status'];
        $previous = $order->status;

        try {
            DB::transaction(function () use ($order, $validated, $newStatus, $previous) {
                if ($previous !== $newStatus) {
                    if ($newStatus === 'cancelled') {
                        $this->adjustStock($order, 1);
                    } elseif ($previous === 'cancelled') {
                        $this->adjustStock($order, -1);
                    }
                }

                $order->update([
                    'status' => $newStatus,
                    'payment_status' => $newStatus === 'completed' && $order->payment_status === 'unpaid'
                        ? 'paid' : $order->payment_status,
                ]);

                if ($previous !== $order->status) {
                    $titles = [
                        'pending' => 'Pesanan Diterima',
                        'processing' => 'Sedang Diproses',
                        'completed' => 'Pesanan Selesai',
                        'cancelled' => 'Pesanan Dibatalkan',
                    ];

                    OrderHistory::create([
                        'order_id' => $order->id,
                        'status' => $order->status,
                        'title' => $titles[$order->status] ?? ucfirst($order->status),
                        'note' => $validated['note'] ?? null,
                        'created_by' => Auth::guard('admin')->user()->name ?? 'Admin',
                    ]);
                }
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            if ($order->status !== 'cancelled') {
                $this->adjustStock($order, 1);
            }

            $order->delete();
        });

        return redirect()->route('admin.orders.index')
            ->with('success', 'Pesanan dihapus.');
    }

    /**
     * Adjust product stock for an order.
     * $direction = 1 restores stock, -1 re-deducts stock.
     */
    private function adjustStock(Order $order, int $direction): void
    {
        foreach ($order->items()->get() as $item) {
            if (! $item->product_id) {
                continue;
            }

            $product = Product::whereKey($item->product_id)->lockForUpdate()->first();

            if (! $product) {
                continue;
            }

            if ($direction > 0) {
                $product->increment('stock', $item->quantity);

                continue;
            }

            if ($product->stock < $item->quantity) {
                throw new \RuntimeException(
                    'Stok '.$product->name.' tidak mencukupi untuk mengaktifkan kembali pesanan ini.'
                );
            }

            $product->decrement('stock', $item->quantity);
        }
    }
}
