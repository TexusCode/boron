@extends('courier.layouts.app')

@section('content')
<section class="space-y-6">
    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Заказ #{{ $order->id }}</p>
                <h2 class="mt-2 text-2xl font-semibold text-slate-900">Детали доставки</h2>
                <p class="mt-1 text-sm text-slate-500">Проверьте адрес и состав заказа перед доставкой.</p>
            </div>
            <a href="{{ route('courier.orders') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-slate-700">
                ← Назад к списку
            </a>
        </div>

        <div class="mt-5 grid gap-4 sm:grid-cols-2">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Клиент</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $order->user->name ?? '—' }}</p>
                <p class="text-sm text-slate-500">+992 {{ $order->user->phone ?? '—' }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Статус</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $order->status }}</p>
                <p class="text-sm text-slate-500">Оплата: {{ $order->payment ?? '—' }}</p>
            </div>
        </div>

        <div class="mt-4 rounded-2xl bg-slate-50 p-4">
            <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Адрес</p>
            <p class="mt-2 text-lg font-semibold text-slate-900">{{ $order->city ?? '—' }}</p>
            <p class="text-sm text-slate-500">{{ $order->location ?? '—' }}</p>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Сумма</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ number_format($order->total, 2, '.', ' ') }} c</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Товаров</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ $totals['items'] }}</p>
            </div>
            <div class="rounded-2xl bg-slate-50 p-4">
                <p class="text-xs uppercase text-slate-400">Дата</p>
                <p class="mt-2 text-lg font-semibold text-slate-900">{{ optional($order->created_at)->format('d.m.Y') }}</p>
                <p class="text-sm text-slate-500">{{ optional($order->created_at)->format('H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-900">Состав заказа</h3>
            <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Товары</span>
        </div>
        <div class="mt-4 space-y-3">
            @foreach ($order->suborders as $suborder)
                <div class="flex flex-wrap items-center justify-between gap-2 rounded-2xl bg-slate-50 px-4 py-3">
                    <div>
                        <p class="font-semibold text-slate-900">{{ $suborder->product->name ?? 'Товар' }}</p>
                        <p class="text-xs text-slate-500">Код: {{ $suborder->product->code ?? '—' }}</p>
                    </div>
                    <div class="text-sm text-slate-500">
                        {{ $suborder->count }} шт • {{ number_format($suborder->price, 2, '.', ' ') }} c
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="rounded-3xl bg-white/90 p-6 shadow-sm ring-1 ring-white/60">
        <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Действия</p>
        <div class="mt-3 flex flex-wrap items-center gap-3">
            <form method="POST" action="{{ route('courier.orders.delivered', $order) }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-emerald-600 to-teal-500 px-6 py-3 text-xs font-semibold uppercase tracking-widest text-white shadow-lg {{ $order->status === 'Доставлен' ? 'opacity-60 cursor-not-allowed' : '' }}"
                    {{ $order->status === 'Доставлен' ? 'disabled' : '' }}>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Доставлено
                </button>
            </form>
            @if (!in_array($order->status, ['Доставлен', 'Отменено'], true))
                <button type="button" data-cancel-toggle="order-cancel"
                    class="inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-rose-600">
                    Отменить
                </button>
            @endif
            <span class="text-xs text-slate-400">После нажатия клиенту отправится SMS.</span>
        </div>

        <div id="order-cancel" class="mt-4 hidden rounded-2xl border border-rose-100 bg-rose-50/70 p-4">
            <form method="POST" action="{{ route('courier.orders.cancel', $order) }}" class="space-y-3">
                @csrf
                <label class="text-xs font-semibold uppercase tracking-wide text-rose-500">Причина отмены</label>
                <textarea name="cancellation_reason" rows="3" required
                    class="w-full rounded-2xl border border-rose-200 bg-white/90 px-3 py-2 text-sm text-slate-700 focus:border-rose-400 focus:ring-rose-300"
                    placeholder="Опишите, почему отменяете заказ..."></textarea>
                <button type="submit"
                    class="inline-flex items-center rounded-full bg-rose-600 px-5 py-2 text-xs font-semibold uppercase tracking-wide text-white shadow">
                    Подтвердить отмену
                </button>
            </form>
        </div>
    </div>

    @if ($order->status === 'Отменено' && $order->cancellation_reason)
        <div class="rounded-3xl border border-rose-200 bg-rose-50/70 p-6 text-sm text-rose-900 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Причина отмены</p>
            <p class="mt-2 font-semibold">{{ $order->cancellation_reason }}</p>
        </div>
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
