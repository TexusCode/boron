@extends('seller.layouts.app')

@section('content')
@php
    $statusMap = [
        'Ожидание' => ['badge' => 'bg-amber-50 text-amber-700 ring-amber-200', 'label' => 'Ожидает обработки'],
        'Подтверждено' => ['badge' => 'bg-emerald-50 text-emerald-700 ring-emerald-200', 'label' => 'Подтверждено'],
        'Доставлен' => ['badge' => 'bg-blue-50 text-blue-700 ring-blue-200', 'label' => 'Доставлен клиенту'],
        'Отменено' => ['badge' => 'bg-rose-50 text-rose-700 ring-rose-200', 'label' => 'Отменен'],
    ];
    $orderStatus = $statusMap[$order->status] ?? ['badge' => 'bg-gray-50 text-gray-600 ring-gray-200', 'label' => $order->status];
@endphp

<section class="space-y-8">
    <header class="rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-fuchsia-600 px-8 py-10 text-white shadow-2xl">
        <div class="flex flex-wrap items-start justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-white/70">Заказ №{{ $order->id }}</p>
                <h1 class="mt-2 text-3xl font-semibold">Детали заказа</h1>
                <p class="mt-2 text-sm text-white/80">Расширенная информация о товарах, клиенте и оплате.</p>
            </div>
            <div class="flex flex-col items-end gap-3">
                <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-semibold ring-1 {{ $orderStatus['badge'] }}">
                    <span>●</span> {{ $orderStatus['label'] }}
                </span>
                <a href="{{ url()->previous() ?? route('orders-seller') }}"
                   class="text-sm font-semibold underline-offset-4 hover:underline">← Назад к заказам</a>
            </div>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-5 lg:col-span-2">
            @forelse ($order->suborders as $suborder)
                @php
                    $product = $suborder->product;
                    $lineTotal = $suborder->price * $suborder->count - ($suborder->discount ?? 0);
                    $miniature = $product->miniature ?? null;
                    $thumbPath = $miniature ? 'thumbs/' . ltrim($miniature, '/') : null;
                    $imagePath = $miniature;
                    if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                        $imagePath = $thumbPath;
                    }
                    $imageState = 'placeholder';
                    $imageUrl = asset('images/placeholders/product-empty.svg');

                    if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                        $imageUrl = asset('storage/' . $imagePath);
                        $imageState = 'normal';
                    } elseif ($miniature) {
                        $imageState = 'missing';
                    }

                    $subStatus = $statusMap[$suborder->status] ?? ['badge' => 'bg-gray-50 text-gray-600 ring-gray-200', 'label' => $suborder->status];
                @endphp
                <article class="flex flex-col gap-4 rounded-3xl border border-gray-100 bg-white p-5 shadow-lg shadow-indigo-50">
                    <div class="flex items-center gap-4">
                        <div class="relative h-20 w-20 overflow-hidden rounded-2xl border
                            @class([
                                'border-rose-200 bg-rose-50' => $imageState === 'missing',
                                'border-gray-100 bg-gray-50' => $imageState !== 'missing',
                            ])">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Плейсхолдер' }}"
                                 class="h-full w-full object-cover @if($imageState !== 'normal') object-contain p-3 @endif">
                            @if($imageState === 'missing')
                                <span class="absolute inset-x-0 bottom-2 text-center text-[10px] font-semibold text-rose-500">Удалён</span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <p class="text-base font-semibold text-gray-900">{{ $product->name ?? 'Товар удалён' }}</p>
                                    <p class="text-xs text-gray-500">Артикул: {{ $product->code ?? '—' }}</p>
                                </div>
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $subStatus['badge'] }}">
                                    <span>●</span>{{ $subStatus['label'] }}
                                </span>
                            </div>
                            <div class="mt-4 grid gap-4 text-sm text-gray-600 sm:grid-cols-3">
                                <div>Количество: <span class="font-semibold text-gray-900">{{ $suborder->count }}</span></div>
                                <div>Цена за шт: <span class="font-semibold text-gray-900">{{ number_format($suborder->price, 2, '.', ' ') }} c</span></div>
                                <div>Сумма: <span class="font-semibold text-gray-900">{{ number_format($lineTotal, 2, '.', ' ') }} c</span></div>
                            </div>
                            @if ($suborder->discount)
                                <p class="mt-2 text-xs text-rose-600">Скидка: {{ number_format($suborder->discount, 2, '.', ' ') }} c</p>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-3xl border border-dashed border-gray-200 bg-white p-12 text-center text-sm text-gray-500">
                    Нет товаров для отображения.
                </div>
            @endforelse
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
                <h2 class="text-lg font-semibold text-gray-900">Информация о заказе</h2>
                <dl class="mt-4 space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <dt>Создан</dt>
                        <dd>{{ optional($order->created_at)->format('d.m.Y H:i') ?? '—' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Подытог</dt>
                        <dd>{{ number_format($order->subtotal, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Доставка</dt>
                        <dd>{{ number_format($order->delivery_price, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Налог</dt>
                        <dd>{{ number_format($order->tax, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt>Скидка</dt>
                        <dd>{{ number_format($order->discount, 2, '.', ' ') }} c</dd>
                    </div>
                    <div class="flex justify-between text-base font-semibold text-gray-900">
                        <dt>Итого</dt>
                        <dd>{{ number_format($order->total, 2, '.', ' ') }} c</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-indigo-50">
                <h2 class="text-lg font-semibold text-gray-900">Информация о клиенте</h2>
                <dl class="mt-4 space-y-2 text-sm text-gray-600">
                    <div><span class="font-semibold text-gray-900">Имя:</span> {{ $order->user->name }}</div>
                    <div><span class="font-semibold text-gray-900">Телефон:</span> +992 {{ $order->user->phone }}</div>
                    <div><span class="font-semibold text-gray-900">Город:</span> {{ $order->city }}</div>
                    <div><span class="font-semibold text-gray-900">Адрес:</span> {{ $order->location }}</div>
                    <div><span class="font-semibold text-gray-900">Оплата:</span> {{ $order->payment }}</div>
                    <div><span class="font-semibold text-gray-900">Доставка:</span> {{ $order->delivery_type }}</div>
                </dl>
            </div>
        </div>
    </div>
</section>
@endsection
