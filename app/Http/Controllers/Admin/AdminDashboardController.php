<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'customers' => User::count(),
            'admins' => Admin::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
        ];

        $recentOrders = Order::with('items')->latest()->limit(6)->get();

        $salesByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')->pluck('count', 'status')->toArray();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'salesByStatus'));
    }
}
