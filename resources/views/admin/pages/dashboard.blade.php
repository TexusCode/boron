@extends('admin.layouts.app')
@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    $placeholder = asset('images/placeholders/product-empty.svg');
    $formatMoney = function ($value) {
        return number_format((float) $value, 2, '.', ' ');
    };
@endphp

<section class="space-y-8">
    <header class="rounded-3xl bg-gradient-to-r from-indigo-700 via-purple-600 to-fuchsia-600 px-6 py-8 text-white shadow-2xl">
        <p class="text-xs uppercase tracking-[0.4em] text-white/70">Отчётность</p>
        <h1 class="mt-2 text-3xl font-semibold">Панель управления</h1>
        <p class="mt-2 text-sm text-white/80">Актуальные показатели продаж по дням, неделям и месяцам, лучшие продавцы и клиенты.</p>
    </header>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-indigo-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Выручка за день</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $formatMoney($metrics['revenueDay']) }} c</h3>
            <p class="text-sm text-gray-500">Заказы: {{ $metrics['ordersDay'] }}</p>
        </article>
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-indigo-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3ем] text-gray-400">Выручка за неделю</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $formatMoney($metrics['revenueWeek']) }} c</h3>
            <p class="text-sm text-gray-500">Заказы: {{ $metrics['ordersWeek'] }}</p>
        </article>
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-indigo-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Выручка за месяц</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $formatMoney($metrics['revenueMonth']) }} c</h3>
            <p class="text-sm text-gray-500">Заказы: {{ $metrics['ordersMonth'] }}</p>
        </article>
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-indigo-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Средний чек</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $formatMoney($metrics['avgOrderValue']) }} c</h3>
            <p class="text-sm text-gray-500">Всего заказов: {{ $metrics['totalOrders'] }}</p>
        </article>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50 lg:col-span-2">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Динамика продаж</p>
                    <h2 class="text-lg font-semibold text-gray-900">Последние 12 месяцев</h2>
                </div>
                <span class="text-sm text-gray-500">Всего: {{ $formatMoney($metrics['totalRevenue']) }} c</span>
            </div>
            <div class="mt-6 h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">7 дней</h2>
                <span class="text-xs uppercase tracking-[0.3em] text-gray-400">Дневной тренд</span>
            </div>
            <div class="mt-6 space-y-3">
                @foreach ($dailyTrend as $day)
                    <div>
                        <div class="flex items-center justify-between text-sm font-semibold text-gray-900">
                            <span>{{ $day['label'] }}</span>
                            <span>{{ $formatMoney($day['revenue']) }} c</span>
                        </div>
                        <div class="mt-1 h-2 rounded-full bg-gray-100">
                            @php
                                $scale = $dailyTrend ? max(array_column($dailyTrend, 'revenue')) : 0;
                                $percent = $scale > 0 ? ($day['revenue'] / $scale) * 100 : 0;
                            @endphp
                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-blue-500" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
            <h2 class="text-lg font-semibold text-gray-900">Топ товары</h2>
            <div class="mt-4 space-y-4">
                @foreach ($topProducts as $productStat)
                    @php
                        $product = $productStat->product;
                        $miniature = $product->miniature ?? null;
                        $thumbPath = $miniature ? 'thumbs/' . ltrim($miniature, '/') : null;
                        $imagePath = $miniature;
                        if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                            $imagePath = $thumbPath;
                        }
                        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                            $imageUrl = asset('storage/' . $imagePath);
                        } else {
                            $imageUrl = $placeholder;
                        }
                    @endphp
                    <div class="flex items-center gap-3 rounded-2xl border border-gray-100 p-3">
                        <img src="{{ $imageUrl }}" alt="" class="h-14 w-14 rounded-xl object-cover">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $product->name ?? 'Удалённый товар' }}</p>
                            <p class="text-xs text-gray-500">{{ $productStat->total_count }} шт • {{ $formatMoney($productStat->total_revenue) }} c</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
            <h2 class="text-lg font-semibold text-gray-900">Топ продавцы</h2>
            <div class="mt-4 space-y-4">
                @foreach ($topSellers as $sellerStat)
                    @php
                        $seller = $sellerStat->seller;
                        $storeName = $seller->store_name ?? 'Неизвестный продавец';
                    @endphp
                    <div class="flex items-center justify-between rounded-2xl border border-gray-100 px-4 py-3">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $storeName }}</p>
                            <p class="text-xs text-gray-500">Заказы: {{ $sellerStat->orders_count }}</p>
                        </div>
                        <span class="text-sm font-semibold text-indigo-600">{{ $formatMoney($sellerStat->total_revenue) }} c</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Лучшие клиенты</h2>
            <p class="text-xs text-gray-500">Количество клиентов: {{ $metrics['customerCount'] }}</p>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-700">
                <thead>
                    <tr class="text-xs uppercase text-gray-500">
                        <th class="px-4 py-2 text-left">Клиент</th>
                        <th class="px-4 py-2 text-left">Заказы</th>
                        <th class="px-4 py-2 text-left">Сумма</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($topCustomers as $customerStat)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $customerStat->user->name ?? 'Неизвестно' }}</p>
                                <p class="text-xs text-gray-500">+992 {{ $customerStat->user->phone ?? '—' }}</p>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $customerStat->orders_count }}</td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $formatMoney($customerStat->total_spent) }} c</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyLabels = @json($monthlyLabels);
        const monthlyRevenue = @json($monthlyRevenue);
        const monthlyOrders = @json($monthlyOrders);

        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [
                        {
                            label: 'Выручка',
                            data: monthlyRevenue,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79,70,229,0.15)',
                            tension: 0.4,
                            yAxisID: 'y',
                            borderWidth: 3,
                            fill: true
                        },
                        {
                            label: 'Заказы',
                            data: monthlyOrders,
                            borderColor: '#14b8a6',
                            backgroundColor: 'rgba(20,184,166,0.15)',
                            tension: 0.4,
                            yAxisID: 'y1',
                            borderWidth: 3,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            position: 'left',
                            ticks: {
                                callback: value => value + ' c'
                            },
                            grid: { drawBorder: false }
                        },
                        y1: {
                            position: 'right',
                            grid: { drawOnChartArea: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    </script>
@endsection
