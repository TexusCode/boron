@extends('manager.layouts.app')

@section('content')
@php
    $statusBadge = [
        'Ожидание' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'Подтверждено' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'Передан курьеру' => 'bg-sky-50 text-sky-700 ring-sky-200',
        'Отправлен' => 'bg-blue-50 text-blue-700 ring-blue-200',
        'Доставлен' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'Отменено' => 'bg-rose-50 text-rose-700 ring-rose-200',
    ];
    $statusOptions = array_keys($statusBadge);
    $placeholderImage = asset('images/placeholders/product-empty.svg');
@endphp

<section class="space-y-6">
    @if (session('success'))
        <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Заказ #{{ $order->id }}</p>
            <h1 class="text-3xl font-semibold text-gray-900">Детали заказа</h1>
            <p class="text-sm text-gray-500">Полная информация о заказе, клиентах, статусах и товарах.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge[$order->status] ?? 'bg-gray-50 text-gray-600 ring-gray-200' }}">
                <span class="text-base">●</span>{{ $order->status }}
            </span>
            <a href="{{ route('manager.orders', ['status' => request('status')]) }}"
                class="inline-flex items-center rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                ← Назад к списку
            </a>
        </div>
    </div>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Сумма заказа</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ number_format($order->total, 2, '.', ' ') }} c</p>
            <p class="text-sm text-gray-500">Включая доставку и налоги</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Товаров</p>
            <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $totals['items'] }}</p>
            <p class="text-sm text-gray-500">Количество позиций</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Дата создания</p>
            <p class="mt-2 text-xl font-semibold text-gray-900">{{ optional($order->created_at)->format('d.m.Y') }}</p>
            <p class="text-sm text-gray-500">{{ optional($order->created_at)->format('H:i') }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-gray-400">Оплата</p>
            <p class="mt-2 text-xl font-semibold text-gray-900">{{ $order->payment ?? '—' }}</p>
            <p class="text-sm text-gray-500">Способ оплаты</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-6 lg:col-span-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Сводка</p>
                        <h2 class="text-xl font-semibold text-gray-900">Информация о заказе</h2>
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        @if ($order->delivery_type)
                            <p>Тип доставки: <span class="font-semibold text-gray-900">{{ $order->delivery_type }}</span>
                            </p>
                        @endif
                        @if ($order->coupone_code)
                            <p>Купон: <span class="font-semibold text-indigo-600">{{ $order->coupone_code }}</span></p>
                        @endif
                    </div>
                </div>
                <dl class="mt-6 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <dt class="text-xs uppercase text-gray-500">Подытог</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($order->subtotal ?? 0, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <dt class="text-xs uppercase text-gray-500">Доставка</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($order->delivery_price ?? 0, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <dt class="text-xs uppercase text-gray-500">Налог</dt>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($order->tax ?? 0, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-4">
                        <dt class="text-xs uppercase text-gray-500">Скидка</dt>
                        <dd class="text-lg font-semibold text-rose-600">-{{ number_format($order->discount ?? 0, 2, '.', ' ') }} c</dd>
                    </div>
                </dl>
                @if ($order->note)
                    <div class="mt-6 rounded-2xl border border-dashed border-indigo-200 bg-indigo-50/50 p-4">
                        <p class="text-xs uppercase text-indigo-500">Заметка клиента</p>
                        <p class="mt-2 text-sm text-indigo-900">{{ $order->note }}</p>
                    </div>
                @endif
                @if ($order->status === 'Отменено' && $order->cancellation_reason)
                    <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 p-4">
                        <p class="text-xs uppercase text-rose-500">Причина отмены</p>
                        <p class="mt-2 text-sm font-semibold text-rose-900">{{ $order->cancellation_reason }}</p>
                    </div>
                @endif
            </div>

            <div class="rounded-3xl bg-white p-0 shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Товары</p>
                    <h2 class="text-xl font-semibold text-gray-900">Состав заказа</h2>
                </div>
                <ul class="divide-y divide-gray-100">
                    @foreach ($order->suborders as $suborder)
                        @php
                            $product = $suborder->product;
                            $imagePath = $product && $product->miniature
                                ? (\Illuminate\Support\Str::startsWith($product->miniature, ['http://', 'https://'])
                                    ? $product->miniature
                                    : asset('storage/' . $product->miniature))
                                : $placeholderImage;
                        @endphp
                        <li class="flex flex-wrap gap-4 px-6 py-5">
                            <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl border border-gray-100 bg-gray-50">
                                <img src="{{ $imagePath }}" alt="{{ $product->name ?? 'Товар' }}"
                                    class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="text-base font-semibold text-gray-900">{{ $product->name ?? 'Товар удалён' }}</p>
                                        <p class="text-sm text-gray-500">Продавец: {{ $product->seller->store_name ?? '—' }}</p>
                                    </div>
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge[$suborder->status] ?? 'bg-gray-50 text-gray-600 ring-gray-200' }}">
                                        {{ $suborder->status }}
                                    </span>
                                </div>
                                <div class="mt-3 grid gap-4 text-sm text-gray-600 sm:grid-cols-3">
                                    <p>Цена: <span class="font-semibold text-gray-900">{{ number_format($suborder->price, 2, '.', ' ') }} c</span></p>
                                    <p>Количество: <span class="font-semibold text-gray-900">{{ $suborder->count }} шт.</span></p>
                                    <p>Сумма: <span class="font-semibold text-gray-900">{{ number_format($suborder->price * $suborder->count, 2, '.', ' ') }} c</span></p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Управление</p>
                <h2 class="text-xl font-semibold text-gray-900">Статус и доставка</h2>
                <div class="mt-4 space-y-5">
                    <form method="POST" action="{{ route('manager.orders.update-status', $order) }}" class="space-y-3">
                        @csrf
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Статус заказа</label>
                        <select name="status"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm text-gray-800 focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach ($statusOptions as $status)
                                <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="w-full rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Обновить
                            статус</button>
                    </form>
                    <form method="POST" action="{{ route('manager.orders.assign-deliver', $order) }}" class="space-y-3">
                        @csrf
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">Назначить курьера</label>
                        <select name="deliver_boy_id"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm text-gray-800 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Не назначен</option>
                            @foreach ($couriers as $courier)
                                <option value="{{ $courier->id }}" @selected($order->deliver_boy_id === $courier->id)>
                                    {{ $courier->name }} — +992 {{ $courier->phone }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="w-full rounded-2xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-500">Сохранить
                            курьера</button>
                        <p class="text-xs text-gray-400">
                            @if ($order->delivery_type === 'Доставка курьером')
                                Заказ отмечен как курьерская доставка.
                            @else
                                Курьер не обязателен для этого типа доставки, но вы можете назначить ответственного.
                            @endif
                        </p>
                    </form>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Клиент</p>
                <h2 class="text-xl font-semibold text-gray-900">Информация о клиенте</h2>
                <dl class="mt-4 space-y-3 text-sm text-gray-600">
                    <div>
                        <dt class="text-xs uppercase text-gray-400">Имя</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $order->user->name ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-gray-400">Телефон</dt>
                        <dd class="text-base font-semibold text-gray-900">+992 {{ $order->user->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-gray-400">Email</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $order->user->email ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Доставка</p>
                <h2 class="text-xl font-semibold text-gray-900">Адрес и контакты</h2>
                <dl class="mt-4 space-y-3 text-sm text-gray-600">
                    <div>
                        <dt class="text-xs uppercase text-gray-400">Город</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $order->city ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-gray-400">Адрес</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $order->location ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-gray-400">Комментарий курьеру</dt>
                        <dd class="text-base font-semibold text-gray-900">{{ $order->delivery_note ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Статусы</p>
                <h2 class="text-xl font-semibold text-gray-900">История</h2>
                <ul class="mt-4 space-y-4">
                    <li class="flex items-start gap-3 text-sm">
                        <div class="h-10 w-10 flex items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $order->status }}</p>
                            <p class="text-gray-500">{{ optional($order->updated_at)->format('d.m.Y H:i') }}</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 text-sm">
                        <div class="h-10 w-10 flex items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v12m6-6H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">Создан</p>
                            <p class="text-gray-500">{{ optional($order->created_at)->format('d.m.Y H:i') }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
