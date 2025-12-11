<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $title ?? 'Boron Admin' }}</title>
    @yield('opengraph')
    @yield('styles')
    @include('global.vite')
</head>

<body>
    <div class="min-h-screen bg-slate-50">
        @php
            $adminUser = Auth::user();
            $adminName = trim($adminUser->name ?? '');
            $initials = 'AD';
            if ($adminName !== '') {
                $parts = preg_split('/\s+/u', $adminName, -1, PREG_SPLIT_NO_EMPTY);
                $firstChar = mb_substr($parts[0], 0, 1);
                $secondChar = isset($parts[1])
                    ? mb_substr($parts[1], 0, 1)
                    : (mb_strlen($parts[0]) > 1
                        ? mb_substr($parts[0], 1, 1)
                        : '');
                $initials = mb_strtoupper($firstChar . $secondChar);
            }
        @endphp

        <nav
            class="fixed inset-x-0 top-0 z-40 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 px-6 py-3 text-white shadow-lg">
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button data-drawer-target="admin-drawer" data-drawer-toggle="admin-drawer"
                        class="rounded-xl p-2 text-slate-300 transition hover:bg-white/10 hover:text-white md:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <a href="{{ route('admin-dashboard') }}" class="text-xl font-extrabold uppercase tracking-wide">
                        BORON.TJ • Admin
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button type="button" id="admin-menu" data-dropdown-toggle="admin-dropdown"
                            class="flex items-center rounded-full bg-white/10 p-1 pr-3 text-sm font-semibold focus:ring-2 focus:ring-white/40">
                            <div
                                class="mr-3 flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 text-base font-bold uppercase">
                                {{ $initials }}
                            </div>
                            <span class="hidden text-left text-xs leading-tight sm:block">
                                {{ $adminUser->name }}<br>
                                <span class="text-white/70">Администратор</span>
                            </span>
                        </button>
                        <div id="admin-dropdown"
                            class="absolute right-0 z-50 hidden w-64 rounded-2xl border border-white/10 bg-slate-900/95 p-3 text-sm text-white shadow-xl backdrop-blur">
                            <div class="rounded-2xl bg-white/5 p-3">
                                <p class="text-base font-semibold">{{ $adminUser->name }}</p>
                                <p class="text-xs text-white/60">+992 {{ $adminUser->phone }}</p>
                            </div>
                            <ul class="mt-3 space-y-1">
                                <li>
                                    <a href="{{ route('admin.account') }}"
                                        class="flex items-center gap-2 rounded-xl px-3 py-2 hover:bg-white/10">
                                        <span>Настройки аккаунта</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('setting') }}"
                                        class="flex items-center gap-2 rounded-xl px-3 py-2 hover:bg-white/10">
                                        <span>Системные настройки</span>
                                    </a>
                                </li>
                            </ul>
                            <form class="mt-3" action="{{ route('logout') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex w-full items-center justify-center rounded-xl bg-rose-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-rose-200 hover:bg-rose-500/20">
                                    Выйти
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <aside id="admin-drawer"
                class="fixed top-0 left-0 z-50 lg:z-30 h-screen w-72 -translate-x-full transform bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 pt-16 text-white shadow-2xl transition-transform md:translate-x-0"
                aria-label="Админ меню">
                <div class="flex h-full flex-col overflow-y-auto px-5 pb-8">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 text-sm shadow-inner mt-5">
                        <p class="text-xs uppercase tracking-[0.3em] text-white/60">Аккаунт</p>
                        <h2 class="mt-2 text-lg font-semibold">{{ $adminUser->name }}</h2>
                        <span
                            class="mt-3 inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-300"></span>В сети
                        </span>
                    </div>

                    <ul class="mt-6 space-y-2 text-sm font-medium">
                        <li>
                            <a href="{{ route('admin-dashboard') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('admin-dashboard'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin-dashboard'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('admin-dashboard'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 9.75A2.25 2.25 0 0 1 5.25 7.5h3a2.25 2.25 0 0 1 2.25 2.25v3A2.25 2.25 0 0 1 8.25 15h-3A2.25 2.25 0 0 1 3 12.75zM13.5 4.5h3A2.25 2.25 0 0 1 18.75 6.75v3a2.25 2.25 0 0 1-2.25 2.25h-3a2.25 2.25 0 0 1-2.25-2.25v-3A2.25 2.25 0 0 1 13.5 4.5zM3 15.75A2.25 2.25 0 0 1 5.25 13.5h3a2.25 2.25 0 0 1 2.25 2.25v3A2.25 2.25 0 0 1 8.25 21h-3A2.25 2.25 0 0 1 3 18.75zM13.5 13.5h3a2.25 2.25 0 0 1 2.25 2.25v3A2.25 2.25 0 0 1 16.5 21h-3a2.25 2.25 0 0 1-2.25-2.25v-3A2.25 2.25 0 0 1 13.5 13.5z" />
                                    </svg>
                                </span>
                                <span>Панель управления</span>
                            </a>
                        </li>

                        <li>
                            <button type="button"
                                class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-slate-200 transition hover:bg-white/10"
                                data-collapse-toggle="orders-menu">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 7h16M4 12h16M4 17h16" />
                                    </svg>
                                </span>
                                <span class="flex-1">Заказы</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <ul id="orders-menu" class="hidden space-y-1 px-4 py-3 text-xs text-slate-200">
                                <li><a href="{{ route('orders') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('orders'),
                                    'hover:bg-white/10' => !request()->routeIs('orders'),
                                ])>Все заказы</a></li>
                                <li><a href="{{ route('orders-peending') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('orders-peending'),
                                    'hover:bg-white/10' => !request()->routeIs('orders-peending'),
                                ])>В
                                        ожидании</a></li>
                                <li><a href="{{ route('orders-confirmed') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs('orders-confirmed'),
                                            'hover:bg-white/10' => !request()->routeIs('orders-confirmed'),
                                        ])>Подтверждено</a></li>
                                <li><a href="{{ route('orders-sended') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('orders-sended'),
                                    'hover:bg-white/10' => !request()->routeIs('orders-sended'),
                                ])>Отправлено</a>
                                </li>
                                <li><a href="{{ route('orders-delivered') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs('orders-delivered'),
                                            'hover:bg-white/10' => !request()->routeIs('orders-delivered'),
                                        ])>Доставлено</a></li>
                                <li><a href="{{ route('orders-cancelled') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('orders-cancelled'),
                                    'hover:bg-white/10' => !request()->routeIs('orders-cancelled'),
                                ])>Отменено</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <button type="button"
                                class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-slate-200 transition hover:bg-white/10"
                                data-collapse-toggle="products-menu">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m3.375 7.5 8.25-4.5 8.25 4.5m-8.25-4.5v9.75m8.25-5.25-8.25 4.5-8.25-4.5m0 5.25 8.25 4.5 8.25-4.5m-8.25 4.5V21" />
                                    </svg>
                                </span>
                                <span class="flex-1">Товары</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <ul id="products-menu" class="hidden space-y-1 px-4 py-3 text-xs text-slate-200">
                                <li><a href="{{ route('all-products') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('all-products'),
                                    'hover:bg-white/10' => !request()->routeIs('all-products'),
                                ])>Все товары</a>
                                </li>
                                <li><a href="{{ route('peending-products') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('peending-products'),
                                    'hover:bg-white/10' => !request()->routeIs('peending-products'),
                                ])>На
                                        модерации</a></li>
                                <li><a href="{{ route('products-not-stock') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs(
                                        'products-not-stock'),
                                    'hover:bg-white/10' => !request()->routeIs('products-not-stock'),
                                ])>Нет в
                                        наличии</a></li>
                                <li><a href="{{ route('add-product') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('add-product'),
                                    'hover:bg-white/10' => !request()->routeIs('add-product'),
                                ])>Добавить</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <button type="button"
                                class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-slate-200 transition hover:bg-white/10"
                                data-collapse-toggle="catalog-menu">
                                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 7h16M4 12h16M4 17h16" />
                                    </svg>
                                </span>
                                <span class="flex-1">Каталог</span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <ul id="catalog-menu" class="hidden space-y-1 px-4 py-3 text-xs text-slate-200">
                                <li><a href="{{ route('categories') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('categories'),
                                    'hover:bg-white/10' => !request()->routeIs('categories'),
                                ])>Категории</a>
                                </li>
                                <li><a href="{{ route('subcategories') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs('subcategories'),
                                            'hover:bg-white/10' => !request()->routeIs('subcategories'),
                                        ])>Подкатегории</a></li>
                                <li><a href="{{ route('cities') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('cities'),
                                    'hover:bg-white/10' => !request()->routeIs('cities'),
                                ])>Города</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('sellers') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('sellers') || request()->routeIs('peending-sellers'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('sellers') && !request()->routeIs('peending-sellers'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('sellers') || request()->routeIs('peending-sellers'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 19.125A3.375 3.375 0 0 0 11.625 15.75H6.375A3.375 3.375 0 0 0 3 19.125v.375A1.5 1.5 0 0 0 4.5 21h9a1.5 1.5 0 0 0 1.5-1.5zM8.25 12.75A3.375 3.375 0 1 0 8.25 6a3.375 3.375 0 0 0 0 6.75zM17.25 13.5c1.591 0 2.625-1.17 2.625-2.625S18.841 8.25 17.25 8.25" />
                                    </svg>
                                </span>
                                <span>Продавцы</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('delivers') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('delivers'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('delivers'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('delivers'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.375 6.75h13.5M3.375 12h13.5M3.375 17.25h13.5M17.25 12h3.375M17.25 17.25H21M7.5 21A2.25 2.25 0 0 1 5.25 18.75V6.75" />
                                    </svg>
                                </span>
                                <span>Доставщики</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('empliyones') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('empliyones'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('empliyones'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('empliyones'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.125 4.5 8.25 7.125M13.875 4.5 15.75 7.125M6.75 9h10.5M4.5 18.75v-7.5a1.5 1.5 0 0 1 1.5-1.5h12a1.5 1.5 0 0 1 1.5 1.5v7.5" />
                                    </svg>
                                </span>
                                <span>Сотрудники</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('coupones') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('coupones'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('coupones'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('coupones'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9V3m0 6a3 3 0 1 0 0 6m0-6a3 3 0 1 1 0 6m0 6v-6" />
                                    </svg>
                                </span>
                                <span>Купоны</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('sliders') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('sliders'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('sliders'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('sliders'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.5 8.25h15m-12 4.5h9m-6 4.5h3" />
                                    </svg>
                                </span>
                                <span>Слайдеры</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('setting') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('setting'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('setting'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('setting'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.5 6.75h3M12 5.25v3M12 15.75v3m-1.5-1.5h3M5.25 12h3m-1.5-1.5v3m10.5-1.5h3m-1.5-1.5v3" />
                                    </svg>
                                </span>
                                <span>Настройка бизнеса</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('sms-page') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('sms-page'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('sms-page'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('sms-page'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-5.25-.75H12v3" />
                                    </svg>
                                </span>
                                <span>SMS панель</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.account') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('admin.account'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin.account'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('admin.account'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0zM4.5 20.25a8.25 8.25 0 0 1 15 0" />
                                    </svg>
                                </span>
                                <span>Настройки аккаунта</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <main class="w-full pt-24 md:ml-72">
                <div class="mx-auto max-w-6xl px-4 pb-10">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
    @include('global.scripts')
</body>

</html>
