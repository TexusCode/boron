<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SubOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function sellerdashboard()
    {
        $seller = Auth::user()->seller;

        abort_if(!$seller, 404);

        $totalProducts = $seller->products()->count();
        $activeProducts = $seller->products()->where('status', true)->count();
        $lowStockProducts = $seller->products()
            ->whereNotNull('stock')
            ->where('stock', '<=', 5)
            ->count();

        $totalOrders = SubOrder::where('seller_id', $seller->id)->count();
        $pendingOrders = SubOrder::where('seller_id', $seller->id)->where('status', 'Ожидание')->count();
        $confirmedOrders = SubOrder::where('seller_id', $seller->id)->where('status', 'Подтверждено')->count();
        $deliveredOrders = SubOrder::where('seller_id', $seller->id)->where('status', 'Доставлен')->count();
        $cancelledOrders = SubOrder::where('seller_id', $seller->id)->where('status', 'Отменено')->count();

        $completedStatuses = ['Подтверждено', 'Доставлен'];

        $totalRevenue = SubOrder::where('seller_id', $seller->id)
            ->whereIn('status', $completedStatuses)
            ->selectRaw('COALESCE(SUM((price - COALESCE(discount,0)) * count), 0) as revenue')
            ->value('revenue') ?? 0;

        $currentMonthRevenue = SubOrder::where('seller_id', $seller->id)
            ->whereIn('status', $completedStatuses)
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->selectRaw('COALESCE(SUM((price - COALESCE(discount,0)) * count), 0) as revenue')
            ->value('revenue') ?? 0;

        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        $monthsWindowStart = Carbon::now()->subMonths(5)->startOfMonth();

        $monthlyRaw = SubOrder::where('seller_id', $seller->id)
            ->where('created_at', '>=', $monthsWindowStart)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period')
            ->selectRaw('SUM((price - COALESCE(discount,0)) * count) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->groupBy('period')
            ->orderBy('period')
            ->get()
            ->keyBy('period');

        $monthlyRevenueLabels = [];
        $monthlyRevenueData = [];
        $monthlyOrderData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $label = $date->locale('ru')->translatedFormat('M Y');

            $monthlyRevenueLabels[] = $label;
            $monthlyRevenueData[] = (float) ($monthlyRaw[$key]->revenue ?? 0);
            $monthlyOrderData[] = (int) ($monthlyRaw[$key]->orders ?? 0);
        }

        $topProducts = SubOrder::select('product_id')
            ->selectRaw('SUM(count) as total_count')
            ->selectRaw('SUM((price - COALESCE(discount,0)) * count) as total_revenue')
            ->where('seller_id', $seller->id)
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->with(['product:id,name,miniature'])
            ->take(5)
            ->get();

        $recentOrders = SubOrder::with(['product:id,name,miniature', 'order:id,created_at'])
            ->where('seller_id', $seller->id)
            ->latest()
            ->take(6)
            ->get();

        return view('seller.pages.dashboard', [
            'seller' => $seller,
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'lowStockProducts' => $lowStockProducts,
            'totalOrders' => $totalOrders,
            'pendingOrders' => $pendingOrders,
            'confirmedOrders' => $confirmedOrders,
            'deliveredOrders' => $deliveredOrders,
            'cancelledOrders' => $cancelledOrders,
            'totalRevenue' => $totalRevenue,
            'currentMonthRevenue' => $currentMonthRevenue,
            'averageOrderValue' => $averageOrderValue,
            'monthlyRevenueLabels' => $monthlyRevenueLabels,
            'monthlyRevenueData' => $monthlyRevenueData,
            'monthlyOrderData' => $monthlyOrderData,
            'topProducts' => $topProducts,
            'recentOrders' => $recentOrders,
        ]);
    }
}
