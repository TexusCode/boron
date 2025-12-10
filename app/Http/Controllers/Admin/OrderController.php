<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deliver;
use App\Models\Order;
use Illuminate\Http\Request;

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

        return view('admin.pages.orders', [
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
        $order = Order::with(['user', 'suborders.product', 'deliver'])->findOrFail($id);

        $totals = [
            'items' => $order->suborders->sum('count'),
            'discount' => $order->suborders->sum('discount'),
        ];

        $delivers = Deliver::orderBy('name')->get();

        return view('admin.pages.order-details', compact('order', 'totals', 'delivers'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Статус заказа обновлён.');
    }

    public function assignDeliver(Request $request, Order $order)
    {
        $request->validate([
            'deliver_boy_id' => 'nullable|exists:delivers,id',
        ]);

        $order->deliver_boy_id = $request->deliver_boy_id;
        $order->save();

        return back()->with('success', 'Информация о доставке обновлена.');
    }

    public function destroy(Order $order)
    {
        $order->suborders()->delete();
        $order->delete();

        return redirect()->route('orders')->with('success', 'Заказ успешно удалён.');
    }
}
