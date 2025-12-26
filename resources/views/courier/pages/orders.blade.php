@extends('courier.layouts.app')

@section('content')
    <section class="space-y-6">
        <header class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Мои доставки</p>
                    <h2 class="mt-2 text-2xl font-semibold text-slate-900">Заказы на доставку</h2>
                    <p class="mt-2 text-sm text-slate-500">Здесь отображаются заказы, назначенные администратором.</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <a href="{{ route('courier.archive') }}"
                        class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-wide text-slate-600">
                        Архив
                    </a>
                    <a href="{{ route('courier.dashboard') }}"
                        class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white">
                        Дашборд
                    </a>
                </div>
            </div>
        </header>

        @if ($courier)
            @if (session('success'))
                <div
                    class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                    {{ session('error') }}
                </div>
            @endif
            <div class="grid gap-4">
                @forelse ($orders as $order)
                    <article
                        class="group relative overflow-hidden rounded-[2rem] border border-slate-100 bg-white/90 p-6 shadow-lg shadow-emerald-100 ring-1 ring-white/60">
                        <div
                            class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-emerald-200/30 blur-3xl">
                        </div>
                        <div
                            class="pointer-events-none absolute -left-12 bottom-0 h-36 w-36 rounded-full bg-sky-200/30 blur-3xl">
                        </div>
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Заказ #{{ $order->id }}</p>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $order->user->name ?? 'Клиент' }}</h3>
                                <p class="text-sm text-slate-500">+992 {{ $order->user->phone ?? '—' }}</p>
                            </div>
                            <span
                                class="inline-flex items-center rounded-full bg-slate-900/90 px-3 py-1 text-xs font-semibold text-white shadow">
                                {{ $order->status }}
                            </span>
                        </div>

                        <div class="mt-5 grid gap-3 text-sm text-slate-600 sm:grid-cols-2">
                            <div
                                class="rounded-2xl border border-slate-100 bg-gradient-to-br from-white to-emerald-50/60 p-4 shadow-sm">
                                <p class="text-xs uppercase text-slate-400">Адрес</p>
                                <p class="mt-1 font-semibold text-slate-900">{{ $order->city ?? '—' }}</p>
                                <p class="text-sm">{{ $order->location ?? '—' }}</p>
                            </div>
                            <div
                                class="rounded-2xl border border-slate-100 bg-gradient-to-br from-white to-sky-50/60 p-4 shadow-sm">
                                <p class="text-xs uppercase text-slate-400">Оплата</p>
                                <p class="mt-1 font-semibold text-slate-900">{{ $order->payment ?? '—' }}</p>
                                <p class="text-sm">Сумма: {{ number_format($order->total, 2, '.', ' ') }} c</p>
                            </div>
                        </div>

                        <div class="mt-5 rounded-2xl border border-slate-100 bg-slate-50/80 p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Товары</p>
                                <span class="text-xs font-semibold text-slate-500">{{ $order->suborders->sum('count') }}
                                    шт</span>
                            </div>
                            <div class="mt-4 grid gap-3">
                                @foreach ($order->suborders as $suborder)
                                    <div
                                        class="flex items-center justify-between rounded-2xl bg-white/90 px-4 py-3 shadow-sm ring-1 ring-slate-100">
                                        <div class="min-w-0 max-w-[16rem] sm:max-w-[24rem]">
                                            <p class="truncate text-sm font-semibold text-slate-900">
                                                {{ $suborder->product->name ?? 'Товар' }}
                                            </p>
                                            <p class="mt-1 text-xs text-slate-400">Количество: {{ $suborder->count }} шт
                                            </p>
                                        </div>
                                        <div
                                            class="ml-4 shrink-0 rounded-2xl bg-slate-900 px-3 py-1 text-xs font-semibold text-white">
                                            {{ number_format($suborder->price, 2, '.', ' ') }} c
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                            <p class="text-xs text-slate-400">Создан:
                                {{ optional($order->created_at)->format('d.m.Y H:i') }}</p>
                            <div class="flex flex-wrap items-center gap-2">
                                @if (!in_array($order->status, ['Передан курьеру', 'Отправлен', 'Доставлен', 'Отменено'], true))
                                    <form method="POST" action="{{ route('courier.orders.received', $order) }}">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow">
                                            Получил заказ
                                        </button>
                                    </form>
                                @endif
                                @if (!in_array($order->status, ['Доставлен', 'Отменено'], true))
                                    <form method="POST" action="{{ route('courier.orders.delivered', $order) }}">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow shadow-emerald-200">
                                            Доставлено
                                        </button>
                                    </form>
                                    <button type="button" data-cancel-toggle="order-{{ $order->id }}"
                                        class="inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-rose-600">
                                        Отменить
                                    </button>
                                @endif
                                <a href="{{ route('courier.orders.show', $order) }}"
                                    class="inline-flex items-center rounded-full bg-gradient-to-r from-teal-600 to-sky-500 px-5 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow">
                                    Детали заказа
                                </a>
                            </div>
                        </div>

                        <div id="order-{{ $order->id }}"
                            class="mt-4 hidden rounded-2xl border border-rose-100 bg-rose-50/70 p-4">
                            <form method="POST" action="{{ route('courier.orders.cancel', $order) }}" class="space-y-3">
                                @csrf
                                <label class="text-xs font-semibold uppercase tracking-wide text-rose-500">Причина
                                    отмены</label>
                                <textarea name="cancellation_reason" rows="3" required
                                    class="w-full rounded-2xl border border-rose-200 bg-white/90 px-3 py-2 text-sm text-slate-700 focus:border-rose-400 focus:ring-rose-300"
                                    placeholder="Опишите, почему отменяете заказ..."></textarea>
                                <button type="submit"
                                    class="inline-flex items-center rounded-full bg-rose-600 px-5 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow">
                                    Подтвердить отмену
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div
                        class="rounded-3xl bg-white/90 p-6 text-center text-sm text-slate-500 shadow-sm ring-1 ring-white/60">
                        Заказы для вас еще не назначены.
                    </div>
                @endforelse
            </div>

            @if ($orders instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="rounded-3xl bg-white/90 px-5 py-3 shadow-sm ring-1 ring-white/60">
                    {{ $orders->links('pagination::simple-tailwind') }}
                </div>
            @endif
        @endif
    </section>
@endsection

@section('scripts')
    <script>
        document.querySelectorAll('[data-cancel-toggle]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-cancel-toggle');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.toggle('hidden');
                }
            });
        });
    </script>
@endsection
