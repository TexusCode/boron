<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubOrder;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $ordersBase = Order::where('status', '!=', 'Неподтверждено');

        $totalRevenue = (clone $ordersBase)->sum('total');
        $totalOrders = (clone $ordersBase)->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $now = Carbon::now();
        $ordersDay = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfDay(), $now->copy()->endOfDay()])
            ->count();
        $ordersWeek = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
            ->count();
        $ordersMonth = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $productsTotal = Product::count();
        $productsActive = Product::where('status', true)->count();
        $productsPending = Product::where('status', false)->count();
        $productsOutOfStock = Product::where('stock', 0)->count();

        $recentOrders = (clone $ordersBase)
            ->with('user')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();

        $topProducts = SubOrder::select('product_id')
            ->selectRaw('SUM(count) as total_count')
            ->selectRaw('SUM((price - COALESCE(discount,0)) * count) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->with('product')
            ->take(6)
            ->get();

        return view('manager.pages.dashboard', [
            'metrics' => [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'avgOrderValue' => $avgOrderValue,
                'ordersDay' => $ordersDay,
                'ordersWeek' => $ordersWeek,
                'ordersMonth' => $ordersMonth,
                'productsTotal' => $productsTotal,
                'productsActive' => $productsActive,
                'productsPending' => $productsPending,
                'productsOutOfStock' => $productsOutOfStock,
            ],
            'recentOrders' => $recentOrders,
            'topProducts' => $topProducts,
        ]);
    }
}
