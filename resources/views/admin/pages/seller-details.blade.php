@extends('admin.layouts.app')

@section('content')
    @php
        $logo = $seller->logo ? asset('storage/' . $seller->logo) : asset('images/placeholders/product-empty.svg');
        $statusBadge = $seller->status
            ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
            : 'bg-rose-50 text-rose-700 ring-rose-200';
        $verifiedBadge = $seller->isverified
            ? 'bg-indigo-50 text-indigo-600 ring-indigo-200'
            : 'bg-gray-100 text-gray-500 ring-gray-200';
        $productsCount = $seller->products->count();
        $stockSum = $seller->products->sum('stock');
        $soldSum = $seller->products->sum('sell');
        $moySkladActive = $seller->moy_sklad ? 'Активирована интеграция' : 'Не подключено';
    @endphp

    <section class="space-y-6">
        <header class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center gap-6">
                <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-3xl border border-gray-100 bg-gray-50">
                    <img src="{{ $logo }}" alt="{{ $seller->store_name }}" class="h-full w-full object-cover">
                </div>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-3">
                        <h1 class="text-3xl font-semibold text-gray-900">{{ $seller->store_name }}</h1>
                        <span
                            class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge }}">
                            {{ $seller->status ? 'Активен' : 'Не активен' }}
                        </span>
                        <span
                            class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $verifiedBadge }}">
                            {{ $seller->isverified ? 'Проверенный магазин' : 'Без верификации' }}
                        </span>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Регистрация: {{ $seller->register_date ?? '—' }}</p>
                    <p class="text-sm text-gray-500">Телефон: <a href="tel:{{ $seller->store_phone }}"
                            class="font-semibold text-indigo-600">{{ $seller->store_phone }}</a></p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row">
                    <form action="{{ route('activate-seller', $seller->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            {{ $seller->status ? 'Приостановить' : 'Активировать' }}
                        </button>
                    </form>
                    <form action="{{ route('verify-seller', $seller->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-2xl {{ $seller->isverified ? 'border border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100' : 'bg-emerald-600 text-white shadow hover:bg-emerald-500' }} px-5 py-2 text-sm font-semibold">
                            {{ $seller->isverified ? 'Снять верификацию' : 'Подтвердить продавца' }}
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-3xl bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Товары</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $productsCount }}</p>
                <p class="text-sm text-gray-500">Активных позиций</p>
            </div>
            <div class="rounded-3xl bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Остаток</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $stockSum }} шт.</p>
                <p class="text-sm text-gray-500">Текущие запасы</p>
            </div>
            <div class="rounded-3xl bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Продажи</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $soldSum ?? 0 }} шт.</p>
                <p class="text-sm text-gray-500">За всё время</p>
            </div>
            <div class="rounded-3xl bg-white p-5 shadow-sm">
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">МойСклад</p>
                <p class="mt-2 text-lg font-semibold text-gray-900">{{ $seller->moy_sklad ? 'Включён' : 'Отключён' }}</p>
                <p class="text-sm text-gray-500">{{ $moySkladActive }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Описание</p>
                    <p class="mt-3 text-sm text-gray-700">{{ $seller->description ?? 'Описание не заполнено.' }}</p>

                    <dl class="mt-6 grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <dt class="text-xs uppercase text-gray-500">Имя владельца</dt>
                            <dd class="text-base font-semibold text-gray-900">{{ $seller->user->name ?? '—' }}</dd>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <dt class="text-xs uppercase text-gray-500">Email</dt>
                            <dd class="text-base font-semibold text-gray-900">{{ $seller->user->email ?? '—' }}</dd>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <dt class="text-xs uppercase text-gray-500">Телефон магазина</dt>
                            <dd class="text-base font-semibold text-gray-900">{{ $seller->store_phone ?? '—' }}</dd>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <dt class="text-xs uppercase text-gray-500">Адрес</dt>
                            <dd class="text-base font-semibold text-gray-900">{{ $seller->location ?? 'Не указан' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Документы</p>
                    <div class="mt-4 grid gap-4 md:grid-cols-3">
                        @php
                            $documents = [
                                ['label' => 'Патент', 'file' => $seller->patent],
                                ['label' => 'Паспорт • лиц', 'file' => $seller->passport_front],
                                ['label' => 'Паспорт • обр', 'file' => $seller->passport_back],
                            ];
                        @endphp
                        @foreach ($documents as $doc)
                            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 text-sm">
                                <p class="font-semibold text-gray-900">{{ $doc['label'] }}</p>
                                @if ($doc['file'])
                                    <a href="{{ asset('storage/' . $doc['file']) }}" target="_blank"
                                        class="mt-2 inline-flex items-center text-sm font-semibold text-indigo-600 hover:underline">
                                        Посмотреть →
                                    </a>
                                @else
                                    <p class="mt-2 text-xs text-gray-400">Файл не загружен</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Быстрые действия</p>
                    <div class="mt-4 space-y-3 text-sm">
                        <a href="mailto:{{ $seller->user->email ?? '' }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-100 p-4 hover:bg-gray-50">
                            <span>Написать письмо</span>
                            <span class="text-xs text-gray-400">Email</span>
                        </a>
                        <a href="tel:{{ $seller->store_phone }}"
                            class="flex items-center justify-between rounded-2xl border border-gray-100 p-4 hover:bg-gray-50">
                            <span>Позвонить</span>
                            <span class="text-xs text-gray-400">{{ $seller->store_phone }}</span>
                        </a>
                        <div class="rounded-2xl border border-gray-100 p-4">
                            <p class="text-xs uppercase text-gray-400">МойСклад</p>
                            <p class="mt-2 text-sm font-semibold text-gray-900">{{ $moySkladActive }}</p>
                            <p class="text-xs text-gray-500">Логин: {{ $seller->moysklad_login ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Товары продавца</p>
                    <h2 class="text-xl font-semibold text-gray-900">Каталог магазина</h2>
                </div>
            </div>
            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($products as $product)
                    @include('admin.partials.product-card', [
                        'product' => $product,
                        'showSelection' => false,
                    ])
                @empty
                    <p class="text-sm text-gray-500">У продавца пока нет товаров.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $products->links('pagination::simple-tailwind') }}
            </div>
        </div>
    </section>
@endsection
