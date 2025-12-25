@extends('manager.layouts.app')

@section('content')
@php
    $productTabs = [
        ['route' => 'manager.products', 'label' => 'Все товары'],
        ['route' => 'manager.peending-products', 'label' => 'На модерации'],
        ['route' => 'manager.products-not-stock', 'label' => 'Нет в наличии'],
    ];
@endphp

<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Товары</p>
                <h1 class="text-3xl font-semibold text-gray-900">Каталог продукции</h1>
                <p class="text-sm text-gray-500">Просматривайте товары и контролируйте остатки без изменения данных.</p>
            </div>
        </div>
        <div class="mt-4 flex flex-wrap gap-3 text-xs font-semibold">
            @foreach ($productTabs as $tab)
                <a href="{{ route($tab['route']) }}"
                    @class([
                        'rounded-full px-4 py-2 transition',
                        'bg-emerald-600 text-white shadow' => request()->routeIs($tab['route']),
                        'bg-gray-100 text-gray-600 hover:bg-gray-200' => !request()->routeIs($tab['route']),
                    ])>
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
    </header>

    <form method="GET" class="space-y-6">
        <div class="rounded-3xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <label class="text-xs font-semibold text-gray-500">Категория</label>
                    <select name="category" class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Все категории</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">Подкатегория</label>
                    <select name="subcategory" class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        <option value="">Все подкатегории</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}" @selected(request('subcategory') == $subcategory->id)>
                                {{ $subcategory->category->name ?? '' }} → {{ $subcategory->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">Поиск</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Название или код"
                        class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
            <div class="mt-4 flex flex-wrap gap-3">
                <button type="submit" class="inline-flex items-center rounded-2xl bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow">
                    Применить фильтры
                </button>
                <a href="{{ route('manager.products') }}" class="inline-flex items-center rounded-2xl bg-gray-100 px-5 py-2 text-sm font-semibold text-gray-600">
                    Сбросить
                </a>
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
            @foreach ($products as $product)
                @include('manager.partials.product-card', ['product' => $product])
            @endforeach
        </div>

        <div class="rounded-3xl border border-gray-100 bg-white px-5 py-4 shadow-sm">
            {{ $products->links('pagination::simple-tailwind') }}
        </div>
    </form>
</section>
@endsection
