<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SubOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orders()
    {
        $user = Auth::user();
        $orders = SubOrder::where('seller_id', $user->seller->id)
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'Неподтверждено');
            })->orderby('created_at','desc')->paginate(36);


        return view('seller.pages.orders', compact('orders'));
    }
    public function orderscancelled()
    {
        $user = Auth::user();
        $orders = SubOrder::where('status', 'Отменено')->where('seller_id', $user->seller->id)
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'Неподтверждено');
            })
            ->paginate(36);

        return view('seller.pages.orders', compact('orders'));
    }
    public function ordersconfirmed()
    {
        $user = Auth::user();
        $orders = SubOrder::where('status', 'Подтверждено')->where('seller_id', $user->seller->id)
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'Неподтверждено');
            })
            ->paginate(36);
        return view('seller.pages.orders', compact('orders'));
    }
    public function orderspeending()
    {
        $user = Auth::user();
        $orders = SubOrder::where('status', 'Ожидание')->where('seller_id', $user->seller->id)
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'Неподтверждено');
            })
            ->paginate(36);
        return view('seller.pages.orders', compact('orders'));
    }
    public function ordersdelivered()
    {
        $user = Auth::user();
        $orders = SubOrder::where('status', 'Доставлен')->where('seller_id', $user->seller->id)
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'Неподтверждено');
            })
            ->paginate(36);

        return view('seller.pages.orders', compact('orders'));
    }
    public function orderdetails($id)
    {
        $order = Order::find($id);

        return view('admin.pages.order-details', compact('order'));
    }
}
