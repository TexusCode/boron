<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $title ?? 'Boron Marketplace' }}</title>
    @yield('opengraph')
    @yield('styles')
    @include('global.vite')
</head>

<body>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        {{-- Navbar --}}
        <nav
            class="bg-gradient-to-r from-slate-900 via-slate-900 to-slate-800 border-b border-white/10 px-4 py-2.5 text-white fixed left-0 right-0 top-0 z-50 shadow-lg">
            <div class="flex flex-wrap items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation"
                        aria-controls="drawer-navigation"
                        class="p-2 mr-2 text-slate-200 rounded-lg cursor-pointer md:hidden hover:text-white hover:bg-white/10 focus:bg-white/10 focus:ring-2 focus:ring-white/30">
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg aria-hidden="true" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>
                    <a href="{{ route('seller-dashboard') }}" class="flex items-center justify-between mr-4 text-white">
                        <span class="self-center text-2xl font-extrabold uppercase tracking-wide">boron.tj</span>
                    </a>

                </div>
                <div class="flex items-center lg:order-2">
                    <!-- Notifications -->
                    {{-- <button type="button" data-dropdown-toggle="notification-dropdown" class="p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">View notifications</span>
                        <!-- Bell icon -->
                        <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 shadow-lg dark:divide-gray-600 dark:bg-gray-700 rounded-xl" id="notification-dropdown">
                        <div class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-600 dark:text-gray-300">
                            Notifications
                        </div>
                        <div>
                            <a href="#" class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/bonnie-green.png" alt="Bonnie Green avatar" />
                                    <div class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 border border-white rounded-full bg-primary-700 dark:border-gray-700">
                                        <svg aria-hidden="true" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
                                            <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        New message from
                                        <span class="font-semibold text-gray-900 dark:text-white">Bonnie Green</span>: "Hey, what's up? All set for the presentation?"
                                    </div>
                                    <div class="text-xs font-medium text-primary-600 dark:text-primary-500">
                                        a few moments ago
                                    </div>
                                </div>
                            </a>

                        </div>
                        <a href="#" class="block py-2 font-medium text-center text-gray-900 text-md bg-gray-50 hover:bg-gray-100 dark:bg-gray-600 dark:text-white dark:hover:underline">
                            <div class="inline-flex items-center">
                                <svg aria-hidden="true" class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                View all
                            </div>
                        </a>
                    </div> --}}

                    <button type="button"
                        class="flex mx-3 text-sm bg-white/10 rounded-full md:mr-0 focus:ring-4 focus:ring-white/30"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                        <span class="sr-only">Open user menu</span>
                        @php
                            $sellerUser = Auth::user();
                            $sellerName = trim($sellerUser->name ?? '');
                            $initials = '??';

                            if ($sellerName !== '') {
                                $parts = preg_split('/\s+/u', $sellerName, -1, PREG_SPLIT_NO_EMPTY);
                                $firstChar = mb_substr($parts[0], 0, 1);
                                $secondChar = isset($parts[1])
                                    ? mb_substr($parts[1], 0, 1)
                                    : (mb_strlen($parts[0]) > 1
                                        ? mb_substr($parts[0], 1, 1)
                                        : '');
                                $initials = mb_strtoupper($firstChar . $secondChar);
                            }
                        @endphp
                        <div
                            class="flex items-center justify-center w-8 h-8 font-semibold text-white uppercase rounded-full bg-gradient-to-r from-indigo-500 to-purple-500">
                            {{ $initials }}
                        </div>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden w-56 my-4 text-base list-none bg-white divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
                        id="dropdown">
                        <div class="px-4 py-3">
                            <span
                                class="block text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            <span class="block text-sm text-gray-900 truncate dark:text-white">+992
                                {{ Auth::user()->phone }}</span>
                        </div>
                        {{-- <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">My profile</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">Account settings</a>
                            </li>
                        </ul> --}}

                        <ul class="py-1 text-gray-700 dark:text-gray-300" aria-labelledby="dropdown">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="block w-full px-4 py-2 text-sm font-bold text-red-500 uppercase hover:bg-red-100">Выйти
                                    из аккаунта</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Sidebar -->
        @php
            $sellerProfile = Auth::user()->seller;
            $ordersRoutes = [
                'orders-seller',
                'orders-peending-seller',
                'orders-confirmed-seller',
                'orders-delivered-seller',
                'orders-cancelled-seller',
            ];
            $productsRoutes = [
                'all-products-seller',
                'peending-products-selle',
                'products-not-stock-selle',
                'add-product-selle',
            ];
        @endphp
        <aside
            class="fixed top-0 left-0 z-50 lg:z-40 w-64 h-screen transition-transform -translate-x-full bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 text-white shadow-2xl pt-14 md:translate-x-0"
            aria-label="Sidenav" id="drawer-navigation">
            <div class="flex flex-col h-full px-4 pb-6 overflow-y-auto mt-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-sm backdrop-blur-md">
                    <p class="text-xs uppercase tracking-[0.25em] text-slate-300">Ваш магазин</p>
                    <h2 class="mt-2 text-lg font-semibold">{{ $sellerProfile->store_name ?? 'Без названия' }}</h2>
                    <p class="text-xs text-slate-300">ID продавца: {{ $sellerProfile->id ?? '—' }}</p>
                    <div
                        class="mt-3 flex items-center gap-2 rounded-xl bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-200">
                        <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                        {{ $sellerProfile && $sellerProfile->status ? 'Активен' : 'На проверке' }}
                    </div>
                </div>

                {{-- Menu --}}
                <ul class="mt-6 space-y-2 text-sm font-medium">
                    {{-- Dashboard --}}
                    <li>
                        <a href="{{ route('seller-dashboard') }}" @class([
                            'flex items-center gap-3 rounded-2xl px-4 py-3 transition-all duration-200',
                            'bg-white text-slate-900 shadow-lg' => request()->routeIs(
                                'seller-dashboard'),
                            'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs(
                                'seller-dashboard'),
                        ])>
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span>Панель управления</span>
                        </a>
                    </li>

                    {{-- Orders --}}
                    <li>
                        <div class="rounded-2xl bg-white/5">
                            <button type="button"
                                class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-slate-100 transition hover:bg-white/10"
                                aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="flex-1">Заказы</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul id="dropdown-pages" class="hidden space-y-1 px-4 py-3 text-xs text-slate-200">
                                <li>
                                    <a href="{{ route('orders-seller') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs('orders-seller'),
                                        'hover:bg-white/10' => !request()->routeIs('orders-seller'),
                                    ])>
                                        Все заказы
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('orders-peending-seller') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'orders-peending-seller'),
                                        'hover:bg-white/10' => !request()->routeIs('orders-peending-seller'),
                                    ])>
                                        В ожидании
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('orders-confirmed-seller') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'orders-confirmed-seller'),
                                        'hover:bg-white/10' => !request()->routeIs('orders-confirmed-seller'),
                                    ])>
                                        Подтверждено
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('orders-delivered-seller') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'orders-delivered-seller'),
                                        'hover:bg-white/10' => !request()->routeIs('orders-delivered-seller'),
                                    ])>
                                        Доставлено
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('orders-cancelled-seller') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'orders-cancelled-seller'),
                                        'hover:bg-white/10' => !request()->routeIs('orders-cancelled-seller'),
                                    ])>
                                        Отменено
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Products --}}
                    <li>
                        <div class="rounded-2xl bg-white/5">
                            <button type="button"
                                class="flex w-full items-center gap-3 rounded-2xl px-4 py-3 text-left text-slate-100 transition hover:bg-white/10"
                                aria-controls="dropdown-sales" data-collapse-toggle="dropdown-sales">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M5 3a1 1 0 0 0 0 2h.687L7.82 15.24A3 3 0 1 0 11.83 17h2.34A3 3 0 1 0 17 15H9.813l-.208-1h8.145a1 1 0 0 0 .979-.796l1.25-6A1 1 0 0 0 19 6h-2.268A2 2 0 0 1 15 9a2 2 0 1 1-4 0 2 2 0 0 1-1.732-3h-1.33L7.48 3.796A1 1 0 0 0 6.5 3H5Z"
                                        clip-rule="evenodd" />
                                    <path fill-rule="evenodd"
                                        d="M14 5a1 1 0 1 0-2 0v1h-1a1 1 0 1 0 0 2h1v1a1 1 0 1 0 2 0V8h1a1 1 0 1 0 0-2h-1V5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="flex-1">Товары</span>
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <ul id="dropdown-sales" class="hidden space-y-1 px-4 py-3 text-xs text-slate-200">
                                <li>
                                    <a href="{{ route('all-products-seller') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'all-products-seller'),
                                        'hover:bg-white/10' => !request()->routeIs('all-products-seller'),
                                    ])>
                                        Все товары
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('peending-products-selle') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'peending-products-selle'),
                                        'hover:bg-white/10' => !request()->routeIs('peending-products-selle'),
                                    ])>
                                        В ожидании
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products-not-stock-selle') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs(
                                            'products-not-stock-selle'),
                                        'hover:bg-white/10' => !request()->routeIs('products-not-stock-selle'),
                                    ])>
                                        Нет в наличии
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('add-product-selle') }}" @class([
                                        'flex items-center rounded-xl px-3 py-2 transition',
                                        'bg-white text-slate-900 shadow' => request()->routeIs('add-product-selle'),
                                        'hover:bg-white/10' => !request()->routeIs('add-product-selle'),
                                    ])>
                                        Добавить новый
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="{{ route('seller.settings') }}" @class([
                            'flex items-center gap-3 rounded-2xl px-4 py-3 transition-all duration-200',
                            'bg-white text-slate-900 shadow-lg' => request()->routeIs(
                                'seller.settings'),
                            'text-slate-200 hover:bg-white/10 hover:text-white' => !request()->routeIs(
                                'seller.settings'),
                        ])>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M10.83 5a3.001 3.001 0 0 0-5.66 0H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17ZM4 11h9.17a3.001 3.001 0 0 1 5.66 0H20a1 1 0 1 1 0 2h-1.17a3.001 3.001 0 0 1-5.66 0H4a1 1 0 1 1 0-2Zm1.17 6H4a1 1 0 1 0 0 2h1.17a3.001 3.001 0 0 0 5.66 0H20a1 1 0 1 0 0-2h-9.17a3.001 3.001 0 0 0-5.66 0Z" />
                            </svg>
                            <span>Настройки</span>
                        </a>
                    </li>

                    @livewire('seller.moy-sklad-togle')
                </ul>
            </div>
        </aside>

        <main class="h-auto p-4 pt-20 md:ml-64">
            @yield('content')
        </main>

    </div>

    @yield('scripts')
    @include('global.scripts')
</body>

</html>
