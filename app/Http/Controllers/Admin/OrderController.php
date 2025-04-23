<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        $orders = Order::whereNotIn('status', ['отменено', 'неподтверждено'])->orderBy('created_at', 'desc')->get();

        return view('admin.pages.orders', compact('orders'));
    }
    public function orderscancelled()
    {
        $orders = Order::where('status', 'Отменен')->orderBy('created_at', 'desc')->get();

        return view('admin.pages.orders', compact('orders'));
    }
    public function ordersconfirmed()
    {
        $orders = Order::where('status', 'Подтверждено')->orderBy('created_at', 'desc')->get();

        return view('admin.pages.orders', compact('orders'));
    }
    public function orderssended()
    {
        $orders = Order::where('status', 'Отправлен')->orderBy('created_at', 'desc')->get();

        return view('admin.pages.orders', compact('orders'));
    }
    public function orderspeending()
    {
        $orders = Order::where('status', 'Ожидание')->orderBy('created_at', 'desc')->get();

        return view('admin.pages.orders', compact('orders'));
    }
    public function ordersdelivered()
    {
        $orders = Order::where('status', 'Доставлен')->orderBy('created_at', 'desc')->get();

        return view('admin.pages.orders', compact('orders'));
    }
    public function orderdetails($id)
    {
        $order = Order::find($id);

        return view('admin.pages.order-details', compact('order'));
    }
}
