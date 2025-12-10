@extends('seller.layouts.app')
@section('content')
@php
    $routeName = request()->route()->getName();
    $variants = [
        'all-products-seller' => [
            'title' => 'Все товары',
            'subtitle' => 'Просматривайте и редактируйте весь ассортимент магазина.',
        ],
        'peending-products-selle' => [
            'title' => 'Товары на модерации',
            'subtitle' => 'Эти позиции ждут подтверждения администратором.',
        ],
        'products-not-stock-selle' => [
            'title' => 'Нет в наличии',
            'subtitle' => 'Следите за остатками и пополняйте востребованные товары.',
        ],
        'update-products-selle' => [
            'title' => 'Управление товарами',
            'subtitle' => 'Применяйте массовые действия, фильтры и ищите нужные позиции.',
        ],
    ];

    $tabs = [
        ['route' => 'all-products-seller', 'label' => 'Все'],
        ['route' => 'peending-products-selle', 'label' => 'На модерации'],
        ['route' => 'products-not-stock-selle', 'label' => 'Нет в наличии'],
    ];

    $page = $variants[$routeName] ?? $variants['all-products-seller'];
@endphp

<section class="space-y-8">
    <header class="rounded-3xl bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 px-6 py-8 text-white shadow-lg">
        <div class="flex flex-wrap items-center justify-between gap-6">
            <div>
                <p class="text-xs uppercase tracking-[0.4em] text-white/70">Каталог продавца</p>
                <h1 class="mt-2 text-3xl font-semibold">{{ $page['title'] }}</h1>
                <p class="mt-2 text-sm text-white/80">{{ $page['subtitle'] }}</p>
            </div>
            <a href="{{ route('add-product-selle') }}"
               class="inline-flex items-center rounded-2xl bg-white/15 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg backdrop-blur transition hover:bg-white/25">
                + Добавить товар
            </a>
        </div>
        <div class="mt-6 flex flex-wrap gap-3 text-xs font-semibold">
            @foreach ($tabs as $tab)
                <a href="{{ route($tab['route']) }}"
                   @class([
                       'rounded-full px-5 py-2 transition-all',
                       'bg-white text-slate-900 shadow' => request()->routeIs($tab['route']),
                       'bg-white/15 text-white hover:bg-white/25' => !request()->routeIs($tab['route']),
                   ])>
                    {{ $tab['label'] }}
                </a>
            @endforeach
        </div>
    </header>

    <form action="{{ route('update-products-selle') }}" method="GET" class="space-y-6">
        <div class="rounded-3xl border border-gray-100 bg-white/70 p-6 shadow-lg shadow-indigo-50">
            @livewire('admin.action')
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
            @forelse ($products as $product)
                @include('seller.partials.product-card')
            @empty
                <div class="col-span-full rounded-3xl border border-dashed border-gray-200 bg-white/60 p-12 text-center text-gray-500">
                    Товары не найдены. Попробуйте изменить условия поиска или добавьте новую позицию.
                </div>
            @endforelse
        </div>

        <div class="flex justify-end">
            {{ $products->links('pagination::simple-tailwind') }}
        </div>
    </form>
</section>
@endsection
