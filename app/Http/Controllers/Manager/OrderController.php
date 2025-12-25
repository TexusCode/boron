<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\SmsController;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function orders(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            $query->where('status', '!=', 'Неподтверждено');
        }

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('id', $term)
                    ->orWhereHas('user', function ($userQuery) use ($term) {
                        $userQuery->where('phone', 'like', '%' . $term . '%')
                            ->orWhere('name', 'like', '%' . $term . '%');
                    });
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->with('user')->orderByDesc('created_at')->paginate(25)->withQueryString();

        return view('manager.pages.orders', [
            'orders' => $orders,
            'filters' => $request->only(['status', 'search', 'date_from', 'date_to']),
            'activeStatus' => $request->input('status', 'all'),
        ]);
    }

    public function orderspeending(Request $request)
    {
        $request->merge(['status' => 'Ожидание']);
        return $this->orders($request);
    }

    public function ordersconfirmed(Request $request)
    {
        $request->merge(['status' => 'Подтверждено']);
        return $this->orders($request);
    }

    public function orderssended(Request $request)
    {
        $request->merge(['status' => 'Отправлен']);
        return $this->orders($request);
    }

    public function ordersdelivered(Request $request)
    {
        $request->merge(['status' => 'Доставлен']);
        return $this->orders($request);
    }

    public function orderscancelled(Request $request)
    {
        $request->merge(['status' => 'Отменено']);
        return $this->orders($request);
    }

    public function orderdetails($id)
    {
        $order = Order::with(['user', 'suborders.product', 'courier'])->findOrFail($id);

        $totals = [
            'items' => $order->suborders->sum('count'),
            'discount' => $order->suborders->sum('discount'),
        ];

        $couriers = User::whereIn('role', ['deliver', 'courier'])
            ->orderBy('name')
            ->get();

        return view('manager.pages.order-details', compact('order', 'totals', 'couriers'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $order->status = $request->status;
        $order->save();

        $this->notifyClientStatus($order);

        return back()->with('success', 'Статус заказа обновлён.');
    }

    public function assignDeliver(Request $request, Order $order)
    {
        $request->validate([
            'deliver_boy_id' => 'nullable|exists:users,id',
        ]);

        $courier = null;
        if ($request->filled('deliver_boy_id')) {
            $courier = User::whereIn('role', ['deliver', 'courier'])->find($request->deliver_boy_id);
            if (!$courier) {
                return back()->with('error', 'Выбранный сотрудник не является курьером.');
            }
        }

        $previousCourierId = $order->deliver_boy_id;
        $order->deliver_boy_id = $courier?->id;
        if ($courier && !in_array($order->status, ['Доставлен', 'Отменено'], true)) {
            $order->status = 'Передан курьеру';
        }
        $order->save();

        if ($courier && $courier->phone && $previousCourierId !== $courier->id) {
            $order->loadMissing(['user', 'suborders.product']);
            $sms = new SmsController();
            $sms->sendSms($courier->phone, $this->buildCourierMessage($order));
        }

        return back()->with('success', 'Информация о доставке обновлена.');
    }

    private function buildCourierMessage(Order $order): string
    {
        $lines = [
            "Новый заказ #{$order->id}",
            "Клиент: " . ($order->user->name ?? '—'),
            "Телефон: +992 " . ($order->user->phone ?? '—'),
            "Адрес: " . trim(($order->city ?? '') . ' ' . ($order->location ?? '')),
            "Оплата: " . ($order->payment ?? '—'),
            "Сумма: " . number_format($order->total ?? 0, 2, '.', ' ') . ' c',
        ];

        return implode(PHP_EOL, $lines);
    }

    private function notifyClientStatus(Order $order): void
    {
        $phone = $order->user->phone ?? null;
        if (!$phone) {
            return;
        }

        $message = match ($order->status) {
            'Подтверждено' => "Ваш заказ №{$order->id} подтвержден.",
            'Отправлен' => "Ваш заказ №{$order->id} отправлен.",
            'Передан курьеру' => "Ваш заказ №{$order->id} передан курьеру.",
            'Доставлен' => $this->buildDeliveredMessage($order),
            'Отменено' => "Ваш заказ №{$order->id} отменен.",
            default => "Статус заказа №{$order->id} обновлен: {$order->status}.",
        };

        $sms = new SmsController();
        $sms->sendSms($phone, $message);
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

    public function destroy(Order $order)
    {
        $order->suborders()->delete();
        $order->delete();

        return redirect()->route('manager.orders')->with('success', 'Заказ успешно удалён.');
    }
}
