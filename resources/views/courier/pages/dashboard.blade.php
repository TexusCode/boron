@extends('courier.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Статистика</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Дашборд курьера</h2>
                <p class="mt-2 text-sm text-slate-500">Смотрите свою доставку по выбранному периоду.</p>
            </div>
            <a href="{{ route('courier.orders') }}"
                class="inline-flex items-center rounded-full bg-gradient-to-r from-teal-600 to-sky-500 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow">
                Мои заказы
            </a>
        </div>
    </header>

    <form class="grid gap-3 rounded-3xl bg-white/90 p-4 shadow-sm ring-1 ring-white/60 sm:grid-cols-4" method="GET">
        <div class="sm:col-span-2">
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">Период</label>
            <select name="period"
                class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                <option value="week" @selected($period === 'week')>Неделя</option>
                <option value="month" @selected($period === 'month')>Месяц</option>
                <option value="year" @selected($period === 'year')>Год</option>
                <option value="custom" @selected($period === 'custom')>Свой период</option>
            </select>
        </div>
        <div>
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">От</label>
            <input type="date" name="date_from" value="{{ $dateFrom }}"
                class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
        </div>
        <div>
            <label class="text-xs font-semibold uppercase tracking-wide text-slate-400">До</label>
            <input type="date" name="date_to" value="{{ $dateTo }}"
                class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
        </div>
        <div class="sm:col-span-4">
            <button type="submit"
                class="w-full rounded-full bg-slate-900 px-5 py-2 text-xs font-semibold uppercase tracking-widest text-white">
                Показать статистику
            </button>
        </div>
    </form>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-3xl bg-white/90 p-5 shadow-sm ring-1 ring-white/60">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Всего назначено</p>
            <h3 class="mt-3 text-3xl font-semibold text-slate-900">{{ $metrics['totalAssigned'] }}</h3>
        </article>
        <article class="rounded-3xl bg-white/90 p-5 shadow-sm ring-1 ring-white/60">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Доставлено</p>
            <h3 class="mt-3 text-3xl font-semibold text-slate-900">{{ $metrics['deliveredCount'] }}</h3>
        </article>
        <article class="rounded-3xl bg-white/90 p-5 shadow-sm ring-1 ring-white/60">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Отменено</p>
            <h3 class="mt-3 text-3xl font-semibold text-slate-900">{{ $metrics['cancelledCount'] }}</h3>
        </article>
        <article class="rounded-3xl bg-white/90 p-5 shadow-sm ring-1 ring-white/60">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Сумма доставок</p>
            <h3 class="mt-3 text-3xl font-semibold text-slate-900">{{ number_format($metrics['deliveredRevenue'], 2, '.', ' ') }} c</h3>
        </article>
    </div>

    <div class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Последние доставленные</h3>
            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">История</span>
        </div>
        <div class="mt-4 space-y-3">
            @forelse ($recentDelivered as $order)
                <div class="flex flex-wrap items-center justify-between gap-2 rounded-2xl bg-slate-50 px-4 py-3">
                    <div>
                        <p class="font-semibold text-slate-900">Заказ #{{ $order->id }}</p>
                        <p class="text-xs text-slate-500">{{ $order->user->name ?? 'Клиент' }} • {{ optional($order->created_at)->format('d.m.Y') }}</p>
                    </div>
                    <span class="text-sm font-semibold text-slate-700">{{ number_format($order->total, 2, '.', ' ') }} c</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Доставленных заказов пока нет.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
