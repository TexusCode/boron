@extends($layout ?? 'cashier.layouts.app')

@php($routePrefix = $routePrefix ?? 'cashier.')

@section('content')
    <section class="space-y-6">
        <header class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Заказы</p>
                    <h1 class="mt-2 text-2xl font-semibold text-slate-900">Заказы кассы</h1>
                    <p class="mt-2 text-sm text-slate-500">Просмотр и управление заказами.</p>
                </div>
                <a href="{{ route($routePrefix . 'orders.create') }}"
                    class="rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase text-white">Новый заказ</a>
            </div>
        </header>

        <div class="overflow-hidden overflow-x-auto rounded-3xl border border-slate-100 bg-white shadow-sm">
            <table class="w-full divide-y divide-slate-100 text-sm text-slate-700 ">
                <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-6 py-3 text-left">Заказ</th>
                        <th class="px-6 py-3 text-left">Клиент</th>
                        <th class="px-6 py-3 text-left">Сумма</th>
                        <th class="px-6 py-3 text-left">Статус</th>
                        <th class="px-6 py-3 text-left">Дата</th>
                        <th class="px-6 py-3 text-left">Детали</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $order->user->name ?? '—' }}</p>
                                <p class="text-xs text-slate-500">+992 {{ $order->user->phone ?? '—' }}</p>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-900">
                                {{ number_format($order->total, 2, '.', ' ') }} c</td>
                            <td class="px-6 py-4">
                                <span
                                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">{{ $order->status }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ optional($order->created_at)->format('d.m.Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route($routePrefix . 'orders.show', $order) }}"
                                    class="rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Открыть</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">
                                Заказов пока нет.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="rounded-3xl border border-slate-100 bg-white px-6 py-4 shadow-sm">
            {{ $orders->links('pagination::simple-tailwind') }}
        </div>
    </section>
@endsection
