@extends('manager.layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    $placeholder = asset('images/placeholders/product-empty.svg');
    $formatMoney = function ($value) {
        return number_format((float) $value, 2, '.', ' ');
    };
@endphp

<section class="space-y-8">
    <header class="rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-500 to-sky-500 px-6 py-8 text-white shadow-2xl">
        <p class="text-xs uppercase tracking-[0.4em] text-white/70">Менеджер</p>
        <h1 class="mt-2 text-3xl font-semibold">Панель заказов и товаров</h1>
        <p class="mt-2 text-sm text-white/80">Только ключевые показатели по заказам и товарам для быстрой работы.</p>
    </header>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-emerald-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Всего заказов</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $metrics['totalOrders'] }}</h3>
            <p class="text-sm text-gray-500">Средний чек: {{ $formatMoney($metrics['avgOrderValue']) }} c</p>
        </article>
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-emerald-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Общая выручка</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $formatMoney($metrics['totalRevenue']) }} c</h3>
            <p class="text-sm text-gray-500">Заказы за месяц: {{ $metrics['ordersMonth'] }}</p>
        </article>
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-emerald-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Товары в каталоге</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $metrics['productsTotal'] }}</h3>
            <p class="text-sm text-gray-500">Активные: {{ $metrics['productsActive'] }}</p>
        </article>
        <article class="rounded-3xl border border-white/60 bg-white/90 p-5 shadow-lg shadow-emerald-50">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Товары без склада</p>
            <h3 class="mt-3 text-3xl font-semibold text-gray-900">{{ $metrics['productsOutOfStock'] }}</h3>
            <p class="text-sm text-gray-500">На модерации: {{ $metrics['productsPending'] }}</p>
        </article>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-emerald-50 lg:col-span-2">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">Статистика заказов</p>
                    <h2 class="text-lg font-semibold text-gray-900">Ключевые периоды</h2>
                </div>
                <div class="text-right text-sm text-gray-500">
                    <p>Сегодня: {{ $metrics['ordersDay'] }}</p>
                    <p>Неделя: {{ $metrics['ordersWeek'] }}</p>
                </div>
            </div>
            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Сегодня</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $metrics['ordersDay'] }}</p>
                </div>
                <div class="rounded-2xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Неделя</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $metrics['ordersWeek'] }}</p>
                </div>
                <div class="rounded-2xl bg-gray-50 p-4">
                    <p class="text-xs uppercase text-gray-500">Месяц</p>
                    <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $metrics['ordersMonth'] }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-emerald-50">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Топ товары</h2>
                <a href="{{ route('manager.products') }}" class="text-xs font-semibold text-emerald-600">Все товары</a>
            </div>
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
                        <img src="{{ $imageUrl }}" alt="" class="h-12 w-12 rounded-xl object-cover">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">{{ $product->name ?? 'Удалённый товар' }}</p>
                            <p class="text-xs text-gray-500">{{ $productStat->total_count }} шт • {{ $formatMoney($productStat->total_revenue) }} c</p>
                        </div>
                    </div>
                @endforeach
                @if ($topProducts->isEmpty())
                    <p class="text-sm text-gray-500">Нет данных по продажам.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-emerald-50">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Последние заказы</h2>
            <a href="{{ route('manager.orders') }}" class="text-xs font-semibold text-emerald-600">Все заказы</a>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-700">
                <thead>
                    <tr class="text-xs uppercase text-gray-500">
                        <th class="px-4 py-2 text-left">Номер</th>
                        <th class="px-4 py-2 text-left">Клиент</th>
                        <th class="px-4 py-2 text-left">Статус</th>
                        <th class="px-4 py-2 text-left">Сумма</th>
                        <th class="px-4 py-2 text-left">Дата</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-gray-900">#{{ $order->id }}</td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-900">{{ $order->user->name ?? '—' }}</p>
                                <p class="text-xs text-gray-500">+992 {{ $order->user->phone ?? '—' }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-semibold text-gray-900">{{ $formatMoney($order->total) }} c</td>
                            <td class="px-4 py-3 text-gray-500">{{ optional($order->created_at)->format('d.m.Y') }}</td>
                        </tr>
                    @endforeach
                    @if ($recentOrders->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">Заказов пока нет.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
