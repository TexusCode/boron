@extends('seller.layouts.app')

@section('content')
@php
    $formatCurrency = function ($value) {
        return number_format((float) $value, 2, '.', ' ');
    };

    $placeholderImage = 'https://via.placeholder.com/96x96?text=No+Image';

    $imageUrl = function ($path) use ($placeholderImage) {
        if (!$path) {
            return $placeholderImage;
        }

        $normalized = ltrim($path, '/');
        $thumbPath = 'thumbs/' . $normalized;
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        $assetPath = $disk->exists($thumbPath) ? $thumbPath : $normalized;

        return asset('storage/' . $assetPath);
    };
@endphp

<div class="space-y-8">
    <section
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 text-white shadow-lg">
        <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-white/70">Добро пожаловать обратно</p>
                <h1 class="mt-2 text-3xl font-bold sm:text-4xl">
                    {{ $seller->store_name ?? 'Ваш магазин' }}
                </h1>
                <p class="mt-4 max-w-2xl text-base text-white/80">
                    Следите за динамикой продаж, управляйте товарами и подтверждайте заказы — вся аналитика и статус
                    заказов собраны в одном месте специально для вас.
                </p>
            </div>
            <div class="flex flex-col gap-4 rounded-2xl bg-white/10 p-5 backdrop-blur lg:min-w-[280px]">
                <p class="text-xs uppercase tracking-[0.3em] text-white/70">Выручка за месяц</p>
                <p class="text-3xl font-semibold">
                    {{ $formatCurrency($currentMonthRevenue) }} <span class="text-lg font-normal">c</span>
                </p>
                <div class="text-sm text-white/80">
                    Средний чек: <span class="font-semibold text-white">{{ $formatCurrency($averageOrderValue) }} c</span>
                </div>
                <div class="flex items-center gap-2 text-sm text-white/80">
                    <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-300"></span>
                    <span>Ожидают подтверждения: {{ $pendingOrders }}</span>
                </div>
            </div>
        </div>
        <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-white/10 blur-3xl"></div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Общая выручка</p>
            <p class="mt-4 text-3xl font-semibold text-gray-900">
                {{ $formatCurrency($totalRevenue) }} <span class="text-lg font-normal text-gray-500">c</span>
            </p>
            <p class="mt-2 text-sm text-emerald-500">+ только подтвержденные/доставленные заказы</p>
        </article>
        <article class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Заказы</p>
            <div class="mt-4 flex items-baseline gap-2">
                <p class="text-3xl font-semibold text-gray-900">{{ $totalOrders }}</p>
                <span class="text-sm text-gray-400">всего</span>
            </div>
            <div class="mt-4 grid grid-cols-2 text-sm">
                <div>
                    <p class="font-semibold text-gray-900">{{ $confirmedOrders + $deliveredOrders }}</p>
                    <p class="text-gray-500">завершено</p>
                </div>
                <div>
                    <p class="font-semibold text-amber-500">{{ $pendingOrders }}</p>
                    <p class="text-gray-500">в ожидании</p>
                </div>
            </div>
        </article>
        <article class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Товары</p>
            <div class="mt-4 flex items-baseline gap-2">
                <p class="text-3xl font-semibold text-gray-900">{{ $totalProducts }}</p>
                <span class="text-sm text-gray-400">в каталоге</span>
            </div>
            <div class="mt-4 flex items-center justify-between text-sm">
                <span class="text-emerald-600">Активных: {{ $activeProducts }}</span>
                <span class="text-rose-500">Мало на складе: {{ $lowStockProducts }}</span>
            </div>
        </article>
        <article class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Статус заказов</p>
            <dl class="mt-4 space-y-2 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <dt class="flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-amber-400"></span>Ожидание
                    </dt>
                    <dd class="font-semibold text-gray-900">{{ $pendingOrders }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Подтверждено
                    </dt>
                    <dd class="font-semibold text-gray-900">{{ $confirmedOrders }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-blue-500"></span>Доставлено
                    </dt>
                    <dd class="font-semibold text-gray-900">{{ $deliveredOrders }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-rose-400"></span>Отменено
                    </dt>
                    <dd class="font-semibold text-gray-900">{{ $cancelledOrders }}</dd>
                </div>
            </dl>
        </article>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Динамика продаж</p>
                    <h3 class="text-xl font-semibold text-gray-900">Последние 6 месяцев</h3>
                </div>
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <span class="flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-blue-600"></span>Выручка
                    </span>
                    <span class="flex items-center gap-2">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>Заказы
                    </span>
                </div>
            </div>
            <div class="mt-6">
                <canvas id="salesChart" height="140"></canvas>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Статистика статусов</p>
                    <h3 class="text-xl font-semibold text-gray-900">Активные заказы</h3>
                </div>
            </div>
            <div class="mx-auto mt-6 w-56">
                <canvas id="statusChart"></canvas>
            </div>
            <div class="mt-6 space-y-3 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">В обработке</span>
                    <span class="font-semibold text-gray-900">{{ $pendingOrders + $confirmedOrders }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Завершено</span>
                    <span class="font-semibold text-gray-900">{{ $deliveredOrders }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Отменено</span>
                    <span class="font-semibold text-gray-900">{{ $cancelledOrders }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Лидеры продаж</p>
                    <h3 class="text-xl font-semibold text-gray-900">Топ товаров</h3>
                </div>
            </div>
            <div class="mt-6 overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs uppercase tracking-wide text-gray-500">
                            <th class="pb-3 pr-4 font-semibold">Товар</th>
                            <th class="pb-3 pr-4 font-semibold">Продано</th>
                            <th class="pb-3 pr-4 font-semibold">Выручка</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($topProducts as $item)
                            @php
                                $product = $item->product;
                                $image = $product ? $imageUrl($product->miniature) : $placeholderImage;
                            @endphp
                            <tr class="text-sm text-gray-700">
                                <td class="py-4 pr-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $image }}" alt=""
                                            class="h-12 w-12 rounded-lg object-cover">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $product->name ?? 'Товар удалён' }}</p>
                                            <p class="text-xs text-gray-500">ID: {{ $product->id ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 pr-4 font-semibold text-gray-900">
                                    {{ $item->total_count }} шт
                                </td>
                                <td class="py-4 pr-4 font-semibold text-gray-900">
                                    {{ $formatCurrency($item->total_revenue) }} c
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-sm text-gray-500">
                                    Продажи ещё не зафиксированы.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Недавние заказы</p>
            <h3 class="text-xl font-semibold text-gray-900">Последние операции</h3>
            <div class="mt-6 space-y-5">
                @forelse($recentOrders as $order)
                    @php
                        $lineTotal = (($order->price ?? 0) - ($order->discount ?? 0)) * ($order->count ?? 1);
                    @endphp
                    <article class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 text-lg font-semibold text-gray-600">
                            #{{ $order->order_id ?? $order->id }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-900">{{ $order->product->name ?? 'Товар удалён' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ optional($order->created_at)->format('d.m.Y H:i') ?? '—' }}
                                • {{ $order->count }} шт
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">{{ $formatCurrency($lineTotal) }} c</p>
                            <p class="text-xs text-gray-500">{{ $order->status }}</p>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">Здесь появятся новые заказы, как только они поступят.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesChartLabels = [
            @foreach($monthlyRevenueLabels as $label)
                '{{ $label }}'@if(!$loop->last),@endif
            @endforeach
        ];
        const salesChartRevenue = [
            @foreach($monthlyRevenueData as $value)
                {{ (float) $value }}@if(!$loop->last),@endif
            @endforeach
        ];
        const salesChartOrders = [
            @foreach($monthlyOrderData as $value)
                {{ (int) $value }}@if(!$loop->last),@endif
            @endforeach
        ];

        const statusChartLabels = ['Ожидание', 'Подтверждено', 'Доставлен', 'Отменено'];
        const statusChartData = [
            {{ (int) $pendingOrders }},
            {{ (int) $confirmedOrders }},
            {{ (int) $deliveredOrders }},
            {{ (int) $cancelledOrders }}
        ];

        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesChartLabels,
                    datasets: [{
                            label: 'Выручка',
                            data: salesChartRevenue,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37, 99, 235, 0.15)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Заказы',
                            data: salesChartOrders,
                            borderColor: '#34d399',
                            backgroundColor: 'rgba(52, 211, 153, 0.25)',
                            fill: false,
                            tension: 0.4,
                            borderWidth: 3,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            type: 'linear',
                            position: 'left',
                            ticks: {
                                callback: (value) => `${value} c`
                            },
                            grid: {
                                drawBorder: false
                            }
                        },
                        y1: {
                            type: 'linear',
                            position: 'right',
                            grid: {
                                drawOnChartArea: false,
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        const statusCtx = document.getElementById('statusChart');
        if (statusCtx) {
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusChartLabels,
                    datasets: [{
                        data: statusChartData,
                        backgroundColor: ['#fbbf24', '#34d399', '#3b82f6', '#f87171'],
                        borderWidth: 0,
                    }]
                },
                options: {
                    cutout: '65%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    </script>
@endsection
