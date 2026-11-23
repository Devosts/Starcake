<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $featured = Product::where('is_active', true)->where('is_featured', true)
            ->with('category')->orderBy('name')->limit(8)->get();
        $bestSellers = Product::where('is_active', true)->orderByDesc('id')->limit(6)->get();
        $newArrivals = Product::where('is_active', true)->latest()->limit(8)->get();
        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $about = [
            'title' => 'Tentang Star Cake',
            'subtitle' => 'Kue Enak, Hati Senang',
        ];

        return view('welcome', compact('featured', 'bestSellers', 'newArrivals', 'categories', 'about'));
    }

    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        $products = Product::with('category')
            ->where('is_active', true);

        if ($cat = $request->query('category')) {
            if ($category = Category::where('slug', $cat)->first()) {
                $products->where('category_id', $category->id);
            }
        }

        $products = $products->when($request->filled('search'), function ($q) use ($request) {
            $q->where('name', 'like', '%'.$request->input('search').'%');
        })
            ->when($request->filled('min_price'), fn ($q) => $q->where('price', '>=', $request->input('min_price')))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price', '<=', $request->input('max_price')))
            ->when($request->input('sort') === 'price_asc', fn ($q) => $q->orderBy('price', 'asc'))
            ->when($request->input('sort') === 'price_desc', fn ($q) => $q->orderBy('price', 'desc'))
            ->when($request->input('sort') === 'newest', fn ($q) => $q->orderBy('created_at', 'desc'))
            ->orderBy('name', 'asc')
            ->paginate(12)
            ->appends($request->query());

        return view('products.index', compact('products', 'categories'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $category->products()->where('is_active', true)
            ->orderBy('name')->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('products.index', compact('category', 'products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)
            ->with(['category', 'reviews' => fn ($q) => $q->where('is_approved', true)->latest()])
            ->firstOrFail();

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)->get();

        return view('products.show', compact('product', 'related'));
    }

    public function about()
    {
        return view('about');
    }

    public function dashboard()
    {
        $ordersQuery = Order::where('user_id', auth()->id());

        $stats = [
            'total' => (clone $ordersQuery)->count(),
            'active' => (clone $ordersQuery)->whereIn('status', ['pending', 'processing'])->count(),
            'completed' => (clone $ordersQuery)->where('status', 'completed')->count(),
        ];

        $orders = $ordersQuery
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('orders', 'stats'));
    }

    public function contact()
    {
        return view('contact');
    }
}
