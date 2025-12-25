<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SmsController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $courier = $this->resolveCourier();

        if (!$courier) {
            return view('courier.pages.orders', [
                'orders' => collect(),
                'courier' => null,
            ]);
        }

        $orders = Order::where('deliver_boy_id', $courier->id)
            ->whereNotIn('status', ['Доставлен', 'Отменено'])
            ->with(['user', 'suborders.product'])
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('courier.pages.orders', [
            'orders' => $orders,
            'courier' => $courier,
        ]);
    }

    public function archive()
    {
        $courier = $this->resolveCourier();
        if (!$courier) {
            abort(403);
        }

        $orders = Order::where('deliver_boy_id', $courier->id)
            ->whereIn('status', ['Доставлен', 'Отменено'])
            ->with(['user', 'suborders.product'])
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('courier.pages.archive', [
            'orders' => $orders,
            'courier' => $courier,
        ]);
    }

    public function show(Order $order)
    {
        $courier = $this->resolveCourier();
        if (!$courier || $order->deliver_boy_id !== $courier->id) {
            abort(403);
        }

        $order->load(['user', 'suborders.product', 'courier']);

        $totals = [
            'items' => $order->suborders->sum('count'),
            'discount' => $order->suborders->sum('discount'),
        ];

        return view('courier.pages.order-details', compact('order', 'courier', 'totals'));
    }

    public function markDelivered(Request $request, Order $order)
    {
        $courier = $this->resolveCourier();
        if (!$courier || $order->deliver_boy_id !== $courier->id) {
            abort(403);
        }

        if ($order->status === 'Отменено') {
            return back()->with('error', 'Заказ уже отменен.');
        }

        if ($order->status !== 'Доставлен') {
            $order->status = 'Доставлен';
            $order->save();

            $phone = $order->user->phone ?? null;
            if ($phone) {
                $smsController = new SmsController();
                $smsController->sendSms($phone, $this->buildDeliveredMessage($order));
            }
        }

        return back()->with('success', 'Статус заказа обновлён.');
    }

    public function cancel(Request $request, Order $order)
    {
        $courier = $this->resolveCourier();
        if (!$courier || $order->deliver_boy_id !== $courier->id) {
            abort(403);
        }

        if ($order->status === 'Доставлен') {
            return back()->with('error', 'Нельзя отменить доставленный заказ.');
        }

        $data = $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:500'],
        ]);

        $order->status = 'Отменено';
        $order->cancellation_reason = $data['cancellation_reason'];
        $order->save();

        return back()->with('success', 'Заказ отменен.');
    }

    private function resolveCourier()
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        return $user;
    }

    private function buildDeliveredMessage(Order $order): string
    {
        if (!$order->review_token) {
            $order->review_token = Str::random(40);
            $order->save();
        }

        $link = URL::temporarySignedRoute(
            'order-review.show',
            now()->addDays(7),
            ['token' => $order->review_token]
        );

        return "Ваш заказ №{$order->id} успешно доставлен. Оставьте отзыв: {$link}";
    }
}
