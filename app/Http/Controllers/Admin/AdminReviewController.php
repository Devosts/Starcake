<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class AdminReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['product', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Review $review)
    {
        $review->update(['is_approved' => ! $review->is_approved]);

        return back()->with('success', $review->is_approved
            ? 'Ulasan ditampilkan.'
            : 'Ulasan disembunyikan.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Ulasan dihapus.');
    }
}
