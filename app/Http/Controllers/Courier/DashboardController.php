<?php

namespace App\Http\Controllers\Courier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $courier = Auth::user();

        $period = $request->input('period', 'month');
        $start = null;
        $end = null;

        if ($period === 'custom') {
            $start = $request->filled('date_from') ? Carbon::parse($request->date_from)->startOfDay() : null;
            $end = $request->filled('date_to') ? Carbon::parse($request->date_to)->endOfDay() : null;
        } elseif ($period === 'week') {
            $start = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
        } elseif ($period === 'year') {
            $start = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        } else {
            $start = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
        }

        $ordersQuery = Order::where('deliver_boy_id', $courier->id);
        $rangeQuery = clone $ordersQuery;

        if ($start && $end) {
            $rangeQuery->whereBetween('created_at', [$start, $end]);
        }

        $totalAssigned = (clone $rangeQuery)->count();
        $deliveredCount = (clone $rangeQuery)->where('status', 'Доставлен')->count();
        $cancelledCount = (clone $rangeQuery)->where('status', 'Отменено')->count();
        $deliveredRevenue = (clone $rangeQuery)->where('status', 'Доставлен')->sum('total');

        $recentDelivered = (clone $ordersQuery)
            ->where('status', 'Доставлен')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('courier.pages.dashboard', [
            'courier' => $courier,
            'period' => $period,
            'dateFrom' => $request->input('date_from'),
            'dateTo' => $request->input('date_to'),
            'metrics' => [
                'totalAssigned' => $totalAssigned,
                'deliveredCount' => $deliveredCount,
                'cancelledCount' => $cancelledCount,
                'deliveredRevenue' => $deliveredRevenue,
            ],
            'recentDelivered' => $recentDelivered,
        ]);
    }
}
