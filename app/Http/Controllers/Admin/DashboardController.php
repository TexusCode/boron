<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Seller;
use App\Models\SubOrder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $ordersBase = Order::where('status', '!=', 'Неподтверждено');

        $totalRevenue = (clone $ordersBase)->sum('total');
        $totalOrders = (clone $ordersBase)->count();
        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $now = Carbon::now();

        $revenueDay = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfDay(), $now->copy()->endOfDay()])
            ->sum('total');
        $revenueWeek = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
            ->sum('total');
        $revenueMonth = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->sum('total');
        $revenueYear = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfYear(), $now->copy()->endOfYear()])
            ->sum('total');

        $ordersDay = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfDay(), $now->copy()->endOfDay()])
            ->count();
        $ordersWeek = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()])
            ->count();
        $ordersMonth = (clone $ordersBase)
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $monthlyWindow = Carbon::now()->subMonths(11)->startOfMonth();
        $monthlyRaw = (clone $ordersBase)
            ->where('created_at', '>=', $monthlyWindow)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period')
            ->selectRaw('SUM(total) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $monthlyLabels = [];
        $monthlyRevenue = [];
        $monthlyOrders = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $monthlyLabels[] = $date->translatedFormat('M Y');
            $monthlyRevenue[] = (float) ($monthlyRaw[$key]->revenue ?? 0);
            $monthlyOrders[] = (int) ($monthlyRaw[$key]->orders ?? 0);
        }

        $dailyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyRevenue = (clone $ordersBase)
                ->whereBetween('created_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()])
                ->sum('total');
            $dailyTrend[] = [
                'label' => $date->translatedFormat('d M'),
                'revenue' => (float) $dailyRevenue,
            ];
        }

        $topProducts = SubOrder::select('product_id')
            ->selectRaw('SUM(count) as total_count')
            ->selectRaw('SUM((price - COALESCE(discount,0)) * count) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->with('product')
            ->take(5)
            ->get();

        $topSellers = SubOrder::select('seller_id')
            ->selectRaw('SUM((price - COALESCE(discount,0)) * count) as total_revenue')
            ->selectRaw('COUNT(DISTINCT order_id) as orders_count')
            ->groupBy('seller_id')
            ->orderByDesc('total_revenue')
            ->with('seller.user')
            ->take(5)
            ->get();

        $topCustomers = (clone $ordersBase)
            ->select('user_id')
            ->selectRaw('SUM(total) as total_spent')
            ->selectRaw('COUNT(*) as orders_count')
            ->groupBy('user_id')
            ->orderByDesc('total_spent')
            ->with('user')
            ->take(5)
            ->get();

        $sellerCount = Seller::count();
        $customerCount = User::count();

        return view('admin.pages.dashboard', [
            'metrics' => [
                'totalRevenue' => $totalRevenue,
                'avgOrderValue' => $avgOrderValue,
                'totalOrders' => $totalOrders,
                'revenueDay' => $revenueDay,
                'revenueWeek' => $revenueWeek,
                'revenueMonth' => $revenueMonth,
                'revenueYear' => $revenueYear,
                'ordersDay' => $ordersDay,
                'ordersWeek' => $ordersWeek,
                'ordersMonth' => $ordersMonth,
                'sellerCount' => $sellerCount,
                'customerCount' => $customerCount,
            ],
            'monthlyLabels' => $monthlyLabels,
            'monthlyRevenue' => $monthlyRevenue,
            'monthlyOrders' => $monthlyOrders,
            'dailyTrend' => $dailyTrend,
            'topProducts' => $topProducts,
            'topSellers' => $topSellers,
            'topCustomers' => $topCustomers,
        ]);
    }
}
