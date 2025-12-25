<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $title ?? 'Boron Manager' }}</title>
    @yield('opengraph')
    @yield('styles')
    @include('global.vite')
</head>

<body>
    <div class="min-h-screen bg-slate-50">
        @php
            $managerUser = Auth::user();
            $managerName = trim($managerUser->name ?? '');
            $initials = 'MN';
            if ($managerName !== '') {
                $parts = preg_split('/\s+/u', $managerName, -1, PREG_SPLIT_NO_EMPTY);
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
                    <button data-drawer-target="manager-drawer" data-drawer-toggle="manager-drawer"
                        class="rounded-xl p-2 text-slate-300 transition hover:bg-white/10 hover:text-white md:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <a href="{{ route('manager.dashboard') }}" class="text-xl font-extrabold uppercase tracking-wide">
                        BORON.TJ • Manager
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <button type="button" id="manager-menu" data-dropdown-toggle="manager-dropdown"
                            class="flex items-center rounded-full bg-white/10 p-1 pr-3 text-sm font-semibold focus:ring-2 focus:ring-white/40">
                            <div
                                class="mr-3 flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 text-base font-bold uppercase">
                                {{ $initials }}
                            </div>
                            <span class="hidden text-left text-xs leading-tight sm:block">
                                {{ $managerUser->name }}<br>
                                <span class="text-white/70">Менеджер</span>
                            </span>
                        </button>
                        <div id="manager-dropdown"
                            class="absolute right-0 z-50 hidden w-64 rounded-2xl border border-white/10 bg-slate-900/95 p-3 text-sm text-white shadow-xl backdrop-blur">
                            <div class="rounded-2xl bg-white/5 p-3">
                                <p class="text-base font-semibold">{{ $managerUser->name }}</p>
                                <p class="text-xs text-white/60">+992 {{ $managerUser->phone }}</p>
                            </div>
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
            <aside id="manager-drawer"
                class="fixed top-0 min-h-screen left-0 z-50 lg:z-30 h-screen w-72 -translate-x-full transform bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 pt-16 text-white shadow-2xl transition-transform md:translate-x-0"
                aria-label="Менеджер меню">
                <div class="flex h-full flex-col overflow-y-auto px-5 pb-8">
                    <div class="mt-5 rounded-3xl border border-white/10 bg-white/5 p-5 text-sm shadow-inner">
                        <p class="text-xs uppercase tracking-[0.3em] text-white/60">Аккаунт</p>
                        <h2 class="mt-2 text-lg font-semibold">{{ $managerUser->name }}</h2>
                        <span
                            class="mt-3 inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-200">
                            <span class="h-2 w-2 rounded-full bg-emerald-300"></span>В сети
                        </span>
                    </div>

                    <ul class="mt-6 space-y-2 text-sm font-medium">
                        <li>
                            <a href="{{ route('manager.dashboard') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs(
                                    'manager.dashboard'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs(
                                    'manager.dashboard'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('manager.dashboard'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 3h18v18H3V3zm3 4h12M6 15h12M6 11h12" />
                                    </svg>
                                </span>
                                <span>Дашборд</span>
                            </a>
                        </li>

                        <li>
                            <button type="button"
                                class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-slate-200 transition hover:bg-white/10"
                                data-collapse-toggle="manager-orders-menu">
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
                            <ul id="manager-orders-menu" class="hidden space-y-1 px-4 py-3 text-xs text-slate-200">
                                <li><a href="{{ route('manager.orders') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs('manager.orders'),
                                    'hover:bg-white/10' => !request()->routeIs('manager.orders'),
                                ])>Все заказы</a>
                                </li>
                                <li><a href="{{ route('manager.orders-peending') }}" @class([
                                    'flex rounded-xl px-3 py-2 transition',
                                    'bg-white text-slate-900 shadow' => request()->routeIs(
                                        'manager.orders-peending'),
                                    'hover:bg-white/10' => !request()->routeIs('manager.orders-peending'),
                                ])>В
                                        ожидании</a></li>
                                <li><a href="{{ route('manager.orders-confirmed') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs(
                                                'manager.orders-confirmed'),
                                            'hover:bg-white/10' => !request()->routeIs('manager.orders-confirmed'),
                                        ])>Подтверждено</a></li>
                                <li><a href="{{ route('manager.orders-sended') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs(
                                                'manager.orders-sended'),
                                            'hover:bg-white/10' => !request()->routeIs('manager.orders-sended'),
                                        ])>Отправлено</a></li>
                                <li><a href="{{ route('manager.orders-delivered') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs(
                                                'manager.orders-delivered'),
                                            'hover:bg-white/10' => !request()->routeIs('manager.orders-delivered'),
                                        ])>Доставлено</a></li>
                                <li><a href="{{ route('manager.orders-cancelled') }}"
                                        @class([
                                            'flex rounded-xl px-3 py-2 transition',
                                            'bg-white text-slate-900 shadow' => request()->routeIs(
                                                'manager.orders-cancelled'),
                                            'hover:bg-white/10' => !request()->routeIs('manager.orders-cancelled'),
                                        ])>Отменено</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('manager.products') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' =>
                                    request()->routeIs('manager.products') ||
                                    request()->routeIs('manager.peending-products') ||
                                    request()->routeIs('manager.products-not-stock'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' =>
                                    !request()->routeIs('manager.products') &&
                                    !request()->routeIs('manager.peending-products') &&
                                    !request()->routeIs('manager.products-not-stock'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' =>
                                        request()->routeIs('manager.products') ||
                                        request()->routeIs('manager.peending-products') ||
                                        request()->routeIs('manager.products-not-stock'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m3.375 7.5 8.25-4.5 8.25 4.5m-8.25-4.5v9.75m8.25-5.25-8.25 4.5-8.25-4.5m0 5.25 8.25 4.5 8.25-4.5m-8.25 4.5V21" />
                                    </svg>
                                </span>
                                <span>Товары</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('manager.sms-page') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs(
                                    'manager.sms-page'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs(
                                    'manager.sms-page'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('manager.sms-page'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 8.25h9m-9 3.75h5.25M4.5 6.75h15A1.5 1.5 0 0 1 21 8.25v7.5A1.5 1.5 0 0 1 19.5 17.25h-9l-4.5 3v-3H4.5A1.5 1.5 0 0 1 3 15.75v-7.5A1.5 1.5 0 0 1 4.5 6.75z" />
                                    </svg>
                                </span>
                                <span>SMS панель</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('manager.cashier.orders.create') }}" @class([
                                'flex items-center gap-3 rounded-2xl px-4 py-3 transition',
                                'bg-white text-slate-900 shadow-lg' => request()->routeIs('manager.cashier.*'),
                                'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs('manager.cashier.*'),
                            ])>
                                <span @class([
                                    'flex h-10 w-10 items-center justify-center rounded-2xl bg-white/10 text-white',
                                    'bg-slate-900/5 text-slate-900' => request()->routeIs('manager.cashier.*'),
                                ])>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 7.5h18M3 12h18M3 16.5h18M7.5 7.5v9m9-9v9" />
                                    </svg>
                                </span>
                                <span>Касса</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <main class="flex-1 px-4 pb-10 pt-24 md:pl-80 md:pr-10">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
    @include('global.scripts')
</body>

</html>
