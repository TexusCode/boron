@extends($layout ?? 'cashier.layouts.app')

@php($routePrefix = $routePrefix ?? 'cashier.')

@section('content')
<section class="space-y-6">
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Заказ #{{ $order->id }}</p>
                <h1 class="mt-2 text-2xl font-semibold text-slate-900">Детали заказа</h1>
                <p class="mt-2 text-sm text-slate-500">Управляйте статусом и отправкой SMS.</p>
            </div>
            <a href="{{ route($routePrefix . 'orders.index') }}"
                class="rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold uppercase text-slate-600">Назад</a>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Клиент</p>
                <h2 class="mt-2 text-lg font-semibold text-slate-900">{{ $order->user->name ?? '—' }}</h2>
                <p class="text-sm text-slate-500">+992 {{ $order->user->phone ?? '—' }}</p>
                <p class="mt-3 text-sm text-slate-600">Адрес: {{ $order->city ?? '—' }} {{ $order->location ?? '' }}</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Товары</p>
                <div class="mt-4 space-y-3">
                    @foreach ($order->suborders as $suborder)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 text-sm">
                            <span class="font-semibold text-slate-900">{{ $suborder->product->name ?? 'Товар' }}</span>
                            <span class="text-slate-600">{{ $suborder->count }} шт • {{ number_format($suborder->price, 2, '.', ' ') }} c</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Сводка</p>
                <p class="mt-2 text-sm text-slate-600">Сумма: <span class="font-semibold text-slate-900">{{ number_format($order->total, 2, '.', ' ') }} c</span></p>
                <p class="text-sm text-slate-600">Статус: <span class="font-semibold text-slate-900">{{ $order->status }}</span></p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Статус заказа</p>
                <form method="POST" action="{{ route($routePrefix . 'orders.status', $order) }}" class="mt-4 space-y-3">
                    @csrf
                    <select name="status" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        @foreach (['Ожидание','Подтверждено','Передан курьеру','Отправлен','Доставлен','Отменено'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="w-full rounded-2xl bg-slate-900 px-4 py-2 text-xs font-semibold uppercase text-white">Сохранить</button>
                </form>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">SMS клиенту</p>
                <form method="POST" action="{{ route($routePrefix . 'orders.sms', $order) }}" class="mt-4 space-y-3">
                    @csrf
                    <select name="template_id" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm">
                        <option value="">Выберите шаблон</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->title }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-400">Доступные переменные: {order_id}, {client_name}, {total}, {status}</p>
                    <button type="submit"
                        class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase text-white">Отправить SMS</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
