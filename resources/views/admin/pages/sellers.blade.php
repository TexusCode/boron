@extends('admin.layouts.app')

@section('content')
@php
    $sellerTabs = [
        ['route' => 'sellers', 'label' => 'Все продавцы', 'key' => 'all'],
        ['route' => 'peending-sellers', 'label' => 'На модерации', 'key' => 'pending'],
    ];
    $filters = $filters ?? [];
    $activeTab = $activeTab ?? 'all';
    $filterRoute = $activeTab === 'pending' ? route('peending-sellers') : route('sellers');
@endphp

<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Продавцы</p>
                <h1 class="text-3xl font-semibold text-gray-900">Управление партнёрами</h1>
                <p class="text-sm text-gray-500">Следите за статусами магазинов, продажами и документами.</p>
            </div>
            <a href="{{ route('add-seller') }}" class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                + Новый продавец
            </a>
        </div>
        <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold">
            @foreach ($sellerTabs as $tab)
                <a href="{{ route($tab['route']) }}"
                    @class([
                        'rounded-full px-4 py-2 transition',
                        'bg-indigo-600 text-white shadow' => $activeTab === $tab['key'],
                        'bg-gray-100 text-gray-600 hover:bg-gray-200' => $activeTab !== $tab['key'],
                    ])>
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
    </header>

    <form method="GET" action="{{ $filterRoute }}" class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm space-y-4">
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="text-xs font-semibold text-gray-500">Поиск</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Название или телефон"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500">Статус</label>
                <select name="status" class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Все</option>
                    <option value="active" @selected(($filters['status'] ?? '') === 'active')>Активные</option>
                    <option value="inactive" @selected(($filters['status'] ?? '') === 'inactive')>Неактивные</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500">Верификация</label>
                <select name="verified" class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Все</option>
                    <option value="yes" @selected(($filters['verified'] ?? '') === 'yes')>Проверенные</option>
                    <option value="no" @selected(($filters['verified'] ?? '') === 'no')>Без значка</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500">Сортировка</label>
                <select name="sort" class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Сначала новые</option>
                    <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Сначала старые</option>
                    <option value="name_asc" @selected(($filters['sort'] ?? '') === 'name_asc')>Имя A→Я</option>
                    <option value="name_desc" @selected(($filters['sort'] ?? '') === 'name_desc')>Имя Я→A</option>
                </select>
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div>
                <label class="text-xs font-semibold text-gray-500">Дата от</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500">Дата до</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                Применить фильтры
            </button>
            <a href="{{ route($activeTab === 'pending' ? 'peending-sellers' : 'sellers') }}" class="inline-flex items-center rounded-2xl bg-gray-100 px-5 py-2 text-sm font-semibold text-gray-600">
                Сбросить
            </a>
        </div>
    </form>

    <div class="rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3 text-left">Магазин</th>
                        <th class="px-5 py-3 text-left">Кол-во товаров</th>
                        <th class="px-5 py-3 text-left">Продано</th>
                        <th class="px-5 py-3 text-left">Статус</th>
                        <th class="px-5 py-3 text-left">Регистрация</th>
                        <th class="px-5 py-3 text-right">Действия</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($sellers as $seller)
                        @php
                            $logo = $seller->logo ? asset('storage/' . $seller->logo) : asset('images/placeholders/product-empty.svg');
                            $statusBadge = $seller->status
                                ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
                                : 'bg-rose-50 text-rose-700 ring-rose-200';
                            $verifiedBadge = $seller->isverified
                                ? 'bg-indigo-50 text-indigo-600 ring-indigo-200'
                                : 'bg-gray-100 text-gray-500 ring-gray-200';
                        @endphp
                        <tr class="hover:bg-gray-50/70">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-2xl border border-gray-100 bg-gray-50">
                                        <img src="{{ $logo }}" alt="{{ $seller->store_name }}" class="h-full w-full object-cover">
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $seller->store_name }}</p>
                                        <p class="text-xs text-gray-500">+992 {{ $seller->store_phone }}</p>
                                        <span class="mt-1 inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold ring-1 {{ $verifiedBadge }}">
                                            {{ $seller->isverified ? 'Проверен' : 'Не проверен' }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm font-semibold text-gray-900">{{ $seller->products->sum('stock') }} шт.</td>
                            <td class="px-5 py-4 text-sm font-semibold text-gray-900">{{ $seller->products->sum('sell') ?? 0 }} шт.</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $statusBadge }}">
                                    <span>●</span>{{ $seller->status ? 'Активен' : 'Не активен' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm">{{ $seller->register_date ?? '-' }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('activate-seller', $seller->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center rounded-full border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-gray-100">
                                            {{ $seller->status ? 'Заморозить' : 'Активировать' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('show-seller', $seller->id) }}"
                                        class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 hover:bg-indigo-600 hover:text-white">
                                        Подробнее
                                    </a>
                                    <form action="{{ route('delete-seller', $seller->id) }}" method="POST" onsubmit="return confirm('Удалить продавца {{ $seller->store_name }}? Это действие необратимо.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 hover:bg-rose-600 hover:text-white">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-5 py-4">
            {{ $sellers->links('pagination::simple-tailwind') }}
        </div>
    </div>
</section>
@endsection
