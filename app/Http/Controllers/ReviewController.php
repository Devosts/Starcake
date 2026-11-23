<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        if (Auth::check()) {
            $existingReview = Review::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingReview) {
                return back()->with('error', 'Anda sudah memberikan review untuk produk ini.');
            }

            $data['user_id'] = Auth::id();
        }

        $data['product_id'] = $product->id;
        $data['is_approved'] = false;

        Review::create($data);

        return back()->with('success', 'Terima kasih! Review Anda akan ditinjau terlebih dahulu.');
    }
}
