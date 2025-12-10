@extends('seller.layouts.app')
@section('content')
    @php
        $routeName = request()->route()->getName();
        $pages = [
            'orders-seller' => [
                'title' => 'Все заказы',
                'subtitle' => 'Полный список всех заказов вашего магазина.',
            ],
            'orders-peending-seller' => [
                'title' => 'Заказы в ожидании',
                'subtitle' => 'Подтвердите новые заказы, чтобы приступить к сборке.',
            ],
            'orders-confirmed-seller' => [
                'title' => 'Подтвержденные заказы',
                'subtitle' => 'Заказы, которые готовы к упаковке и отправке.',
            ],
            'orders-delivered-seller' => [
                'title' => 'Доставленные заказы',
                'subtitle' => 'История завершенных доставок и выручка.',
            ],
            'orders-cancelled-seller' => [
                'title' => 'Отмененные заказы',
                'subtitle' => 'Отслеживайте отмены, чтобы улучшать процессы.',
            ],
        ];

        $tabs = [
            ['route' => 'orders-seller', 'label' => 'Все'],
            ['route' => 'orders-peending-seller', 'label' => 'В ожидании'],
            ['route' => 'orders-confirmed-seller', 'label' => 'Подтверждено'],
            ['route' => 'orders-delivered-seller', 'label' => 'Доставлено'],
            ['route' => 'orders-cancelled-seller', 'label' => 'Отменено'],
        ];

        $page = $pages[$routeName] ?? $pages['orders-seller'];
    @endphp

    <section class="space-y-6">
        <header class="rounded-3xl bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-500 px-6 py-8 text-white shadow-lg">
            <p class="text-xs uppercase tracking-[0.4em] text-white/70">Управление заказами</p>
            <h1 class="mt-3 text-3xl font-semibold">{{ $page['title'] }}</h1>
            <p class="mt-2 text-sm text-white/80">{{ $page['subtitle'] }}</p>
            <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold">
                @foreach ($tabs as $tab)
                    <a href="{{ route($tab['route']) }}" @class([
                        'rounded-full px-5 py-2 transition-all',
                        'bg-white text-slate-900 shadow' => request()->routeIs($tab['route']),
                        'bg-white/10 text-white hover:bg-white/20' => !request()->routeIs(
                            $tab['route']),
                    ])>
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>
        </header>

        <div class="rounded-3xl border border-gray-100 bg-white shadow-xl shadow-indigo-50/50">
            <div class="border-b border-gray-100 px-6 py-4">
                <h2 class="text-lg font-semibold text-gray-900">Текущие заказы</h2>
                <p class="text-sm text-gray-500">Обновлено {{ now()->format('d.m.Y H:i') }}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-6 py-3 text-left">№ заказа</th>
                            <th class="px-6 py-3 text-left">Товар</th>
                            <th class="px-6 py-3 text-left">Дата</th>
                            <th class="px-6 py-3 text-left">Статус</th>
                            <th class="px-6 py-3 text-left">Сумма</th>
                            <th class="px-6 py-3 text-left">Скидка</th>
                            <th class="px-6 py-3 text-right">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white text-sm text-gray-700">
                        @forelse ($orders as $suborder)
                            @php
                                $product = $suborder->product;
                                $mainOrder = $suborder->order;
                                $lineTotal = $suborder->price * $suborder->count - ($suborder->discount ?? 0);
                                $miniature = $product->miniature ?? null;
                                $thumbPath = $miniature ? 'thumbs/' . ltrim($miniature, '/') : null;
                                $imagePath = $miniature;
                                if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                                    $imagePath = $thumbPath;
                                }
                                $imageUrl = $imagePath
                                    ? asset('storage/' . $imagePath)
                                    : 'https://via.placeholder.com/120x120?text=No+Image';
                                $imageState = 'placeholder';
                                $imageUrl = asset('images/placeholders/product-empty.svg');

                                if ($miniature) {
                                    $imageState = 'missing';
                                }

                                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                                    $imageUrl = asset('storage/' . $imagePath);
                                    $imageState = 'normal';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50/70">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">#{{ $mainOrder->id ?? '—' }}</p>
                                    <p class="text-xs text-gray-500">Субзаказ #{{ $suborder->id }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="relative h-16 w-16 overflow-hidden rounded-2xl border shadow
                                            @class([
                                                'border-rose-200 bg-rose-50' => $imageState === 'missing',
                                                'border-gray-100 bg-gray-50' => $imageState !== 'missing',
                                            ])">
                                            <img src="{{ $imageUrl }}" alt="{{ $product->name ?? 'Плейсхолдер' }}"
                                                class="h-full w-full object-cover @if($imageState !== 'normal') object-contain p-2 @endif">
                                            @if($imageState === 'missing')
                                                <span class="absolute inset-x-0 bottom-1 text-center text-[10px] font-semibold text-rose-500">Удалён</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900 line-clamp-1">
                                                {{ $product->name ?? 'Товар удалён' }}</p>
                                            <p class="text-xs text-gray-500">{{ $suborder->count }} шт</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">
                                        {{ optional($suborder->created_at)->format('d.m.Y H:i') ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusMap = [
                                            'Ожидание' => ['bg' => 'bg-amber-50 border-amber-200 text-amber-700', 'icon' => '⏳'],
                                            'Подтверждено' => ['bg' => 'bg-emerald-50 border-emerald-200 text-emerald-700', 'icon' => '✅'],
                                            'Доставлен' => ['bg' => 'bg-blue-50 border-blue-200 text-blue-700', 'icon' => '🚚'],
                                            'Отменено' => ['bg' => 'bg-rose-50 border-rose-200 text-rose-700', 'icon' => '✖'],
                                        ];
                                        $statusStyles = $statusMap[$suborder->status] ?? ['bg' => 'bg-gray-50 border-gray-200 text-gray-600', 'icon' => '•'];
                                    @endphp
                                    <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs font-semibold {{ $statusStyles['bg'] }} {{ $statusStyles['text'] ?? '' }}">
                                        <span>{{ $statusStyles['icon'] }}</span>
                                        {{ $suborder->status ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    {{ number_format($lineTotal, 2, '.', ' ') }} c
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ number_format($suborder->discount ?? 0, 2, '.', ' ') }} c
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('order-details-seller', $suborder->order_id) }}"
                                            class="inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2 text-xs font-semibold text-indigo-600 shadow-sm ring-1 ring-indigo-100 transition hover:bg-indigo-600 hover:text-white">
                                            <span>Подробнее</span>
                                        </a>
                                        <div
                                            class="inline-flex items-center gap-3 rounded-2xl bg-gray-50 px-4 py-2 text-xs font-semibold text-gray-700 ring-1 ring-gray-100">
                                            @livewire('seller.order-confirm', ['id' => $suborder->id], key('suborder-' . $suborder->id))
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                                    Заказы не найдены.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end">
            {{ $orders->links('pagination::simple-tailwind') }}
        </div>
    </section>
@endsection
