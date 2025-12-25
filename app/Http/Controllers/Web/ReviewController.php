<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ReviewController extends Controller
{
    public function show(Request $request, string $token)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $order = Order::where('review_token', $token)->firstOrFail();
        $review = $order->review;
        $submitUrl = URL::temporarySignedRoute(
            'order-review.store',
            now()->addDays(7),
            ['token' => $token]
        );

        return view('web.pages.order-review', [
            'order' => $order,
            'review' => $review,
            'submitUrl' => $submitUrl,
        ]);
    }

    public function store(Request $request, string $token)
    {
        if (!$request->hasValidSignature()) {
            abort(403);
        }

        $order = Order::where('review_token', $token)->firstOrFail();
        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($order->review) {
            return redirect()->back()->with('success', 'Отзыв уже был отправлен.');
        }

        OrderReview::create([
            'order_id' => $order->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Спасибо за ваш отзыв!');
    }
}
