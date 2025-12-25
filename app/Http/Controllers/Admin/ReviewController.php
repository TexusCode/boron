<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReview;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = OrderReview::with(['order.user'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.pages.reviews', compact('reviews'));
    }

    public function show(OrderReview $review)
    {
        $review->loadMissing(['order.user']);

        return view('admin.pages.review-details', compact('review'));
    }
}
