<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SubOrder;
use Illuminate\Support\Facades.Auth;

class OrderController extends Controller
{
    protected function sellerSubOrdersQuery(?string $status = null)
    {
        $seller = Auth::user()->seller;
        abort_unless($seller, 403, 'Seller profile not found.');

        $query = SubOrder::with(['product', 'order.user'])
            ->where('seller_id', $seller->id)
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'Неподтверждено');
            })
            ->orderByDesc('created_at');

        if ($status) {
            $query->where('status', $status);
        }

        return $query;
    }

    public function orders()
    {
        $orders = $this->sellerSubOrdersQuery()
            ->paginate(36)
            ->withQueryString();

        return view('seller.pages.orders', compact('orders'));
    }

    public function orderscancelled()
    {
        $orders = $this->sellerSubOrdersQuery('Отменено')
            ->paginate(36)
            ->withQueryString();

        return view('seller.pages.orders', compact('orders'));
    }

    public function ordersconfirmed()
    {
        $orders = $this->sellerSubOrdersQuery('Подтверждено')
            ->paginate(36)
            ->withQueryString();

        return view('seller.pages.orders', compact('orders'));
    }

    public function orderspeending()
    {
        $orders = $this->sellerSubOrdersQuery('Ожидание')
            ->paginate(36)
            ->withQueryString();

        return view('seller.pages.orders', compact('orders'));
    }

    public function ordersdelivered()
    {
        $orders = $this->sellerSubOrdersQuery('Доставлен')
            ->paginate(36)
            ->withQueryString();

        return view('seller.pages.orders', compact('orders'));
    }

    public function orderdetails($id)
    {
        $seller = Auth::user()->seller;
        abort_unless($seller, 403, 'Seller profile not found.');

        $order = Order::with([
            'user',
            'suborders' => function ($query) use ($seller) {
                $query->where('seller_id', $seller->id)
                    ->with('product');
            },
        ])
            ->whereHas('suborders', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->findOrFail($id);

        return view('seller.pages.order-details', compact('order'));
    }
}
