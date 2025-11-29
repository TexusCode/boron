@extends('seller.layouts.app')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-500">Заказ №{{ $order->id }}</p>
            <h1 class="text-2xl font-semibold text-gray-900">Детали заказа</h1>
        </div>
        <a href="{{ url()->previous() ?? route('orders-seller') }}" class="text-sm font-semibold text-primary-600 hover:underline">← Назад к заказам</a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="p-6 bg-white rounded-lg shadow lg:col-span-2">
            <h2 class="mb-4 text-xl font-semibold text-gray-900">Товары</h2>
            <div class="space-y-4">
                @forelse ($order->suborders as $suborder)
                @php
                    $product = $suborder->product;
                    $lineTotal = ($suborder->price * $suborder->count) - ($suborder->discount ?? 0);
                    $miniature = $product->miniature ?? null;
                    $thumbPath = $miniature ? 'thumbs/' . ltrim($miniature, '/') : null;
                    $imagePath = $miniature;
                    if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                        $imagePath = $thumbPath;
                    }
                    $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://via.placeholder.com/160x160?text=No+Image';
                @endphp
                <div class="flex items-start gap-4 py-3 border-b">
                    <div class="w-16 h-16 overflow-hidden border rounded-md">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="object-cover w-16 h-16">
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $product->name ?? 'Товар удалён' }}</p>
                                <p class="text-xs text-gray-500">Артикул: {{ $product->code ?? '—' }}</p>
                            </div>
                            <span class="text-xs font-medium px-2 py-0.5 rounded
                                @class([
                                    'bg-yellow-100 text-yellow-800' => $suborder->status === 'Ожидание',
                                    'bg-green-100 text-green-800' => $suborder->status === 'Подтверждено',
                                    'bg-blue-100 text-blue-800' => $suborder->status === 'Доставлен',
                                    'bg-red-100 text-red-800' => $suborder->status === 'Отменено',
                                    'bg-gray-100 text-gray-800' => ! $suborder->status,
                                ])">
                                {{ $suborder->status ?? '—' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
                            <div>Количество: <span class="font-semibold text-gray-900">{{ $suborder->count }}</span></div>
                            <div>Цена за шт: <span class="font-semibold text-gray-900">{{ number_format($suborder->price, 2, '.', ' ') }} c</span></div>
                            <div>Сумма: <span class="font-semibold text-gray-900">{{ number_format($lineTotal, 2, '.', ' ') }} c</span></div>
                        </div>
                        @if($suborder->discount)
                        <p class="mt-1 text-xs text-rose-600">Скидка: {{ number_format($suborder->discount, 2, '.', ' ') }} c</p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">Нет товаров для отображения.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Информация о заказе</h2>
                <dl class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <dt>Статус заказа</dt>
                        <dd class="font-semibold text-gray-900">{{ $order->status }}</dd>
                    </div>
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

            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-xl font-semibold text-gray-900">Информация о клиенте</h2>
                <dl class="space-y-2 text-sm text-gray-700">
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
</div>
@endsection
