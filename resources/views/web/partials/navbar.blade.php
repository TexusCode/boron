<nav class="sticky top-0 z-30 antialiased bg-white dark:bg-gray-800">
    <div class="py-2 lg:border-b lg:border-gray-200 dark:border-gray-700 bg-primary-700">
        <div class="max-w-screen-xl px-2 mx-auto 2xl:px-0">
            <div class="flex flex-wrap items-center justify-between gap-x-16 gap-y-4 md:gap-x-8 lg:flex-nowrap">
                <div class="flex shrink-0 md:order-1 lg:gap-10">
                    <a href="{{ route('home') }}" title="" class="">
                        <img class="w-auto h-8 sm:flex" src="{{ asset('assets/logo.webp') }}" alt="">
                    </a>
                    <button
                        class="hidden px-3 py-1 text-lg font-bold uppercase duration-150 bg-white rounded-lg text-primary-700 hover:text-white hover:bg-primary-700 hover:ring-2 hover:ring-white lg:flex lg:gap-2 lg:items-center"
                        aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-large-modal"
                        data-hs-overlay="#hs-large-modal">

                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-category">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M4 4h6v6h-6z" />
                            <path d="M14 4h6v6h-6z" />
                            <path d="M4 14h6v6h-6z" />
                            <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        </svg>

                        <span>Каталог</span>

                    </button>

                </div>

                <div class="flex items-center justify-end md:order-3 lg:space-x-2">
                    <a href="{{ route('shopcart') }}"
                        class="items-center justify-center hidden p-2 text-sm font-medium leading-none text-white duration-150 rounded-lg lg:inline-flex hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-700 dark:text-white">


                        <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                        </svg>
                        <span class="hidden sm:flex me-1.5">Корзина</span>
                        @livewire('web.cart-counter')

                    </a>


                    <div class="hidden lg:block">
                        @guest
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center p-2 text-sm font-medium leading-none text-white duration-150 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-700 dark:text-white">

                                <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="hidden lg:block">
                                    Войти / Регистрация
                                </span>
                            </a>

                        @endguest
                        @auth

                            <button id="accountDropdownButton5" data-dropdown-toggle="accountDropdown5" type="button"
                                class="inline-flex items-center justify-center p-2 text-sm font-medium leading-none text-white duration-150 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-700 dark:text-white">

                                <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2"
                                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="hidden lg:block">
                                    Профил
                                </span>
                                <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">

                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 9-7 7-7-7"></path>
                                </svg>
                            </button>
                        @endauth

                        <!-- Dropdown Menu -->
                        <div id="accountDropdown5"
                            class="z-50 hidden overflow-hidden overflow-y-auto antialiased bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:divide-gray-600 dark:bg-gray-700">
                            <div class="space-y-0">
                                <ul class="text-sm font-medium text-gray-900 text-start dark:text-white">
                                    <li>
                                        <a href="{{ route('my-orders') }}" title=""
                                            class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                                            </svg>
                                            Мои заказы
                                        </a>
                                    </li>

                                    <li>
                                        <a href="{{ route('favorites') }}" title=""
                                            class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z" />
                                            </svg>
                                            Избранные @livewire('web.favorite-counter')
                                        </a>
                                    </li>
                                    {{-- <li>
                                    <a href="#" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 9H8a5 5 0 0 0 0 10h9m4-10-4-4m4 4-4 4" />
                                        </svg>
                                        My Returns
                                    </a>
                                </li> --}}
                                    {{-- <li>
                                    <a href="#" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21v-9m3-4H7.5a2.5 2.5 0 1 1 0-5c1.5 0 2.9 1.3 3.9 2.5M14 21v-9m-9 0h14v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-8ZM4 8h16a1 1 0 0 1 1 1v3H3V9a1 1 0 0 1 1-1Zm12.2-5c-3 0-5.5 5-5.5 5h5.5a2.5 2.5 0 0 0 0-5Z" />
                                        </svg>
                                        Gift Cards
                                    </a>
                                </li> --}}
                                </ul>

                                <ul class="text-sm font-medium text-gray-900 text-start dark:text-white">
                                    {{-- <li>
                                    <a href="#" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M7 17v1c0 .6.4 1 1 1h8c.6 0 1-.4 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        Настройка аккаунта
                                    </a>
                                </li> --}}
                                    <li>
                                        <a href="{{ route('policy') }}" title="Политика использования"
                                            class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10c.6 0 1 .4 1 1v7c0 .6-.4 1-1 1H7a1 1 0 0 1-1-1v-7c0-.6.4-1 1-1Z" />
                                            </svg>
                                            Политика использования
                                        </a>
                                    </li>
                                    {{-- <li>
                                    <a href="#" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5.4V3m0 2.4a5.3 5.3 0 0 1 5.1 5.3v1.8c0 2.4 1.9 3 1.9 4.2 0 .6 0 1.3-.5 1.3h-13c-.5 0-.5-.7-.5-1.3 0-1.2 1.9-1.8 1.9-4.2v-1.8A5.3 5.3 0 0 1 12 5.4ZM8.7 18c.1.9.3 1.5 1 2.1a3.5 3.5 0 0 0 4.6 0c.7-.6 1.3-1.2 1.4-2.1h-7Z" />
                                        </svg>
                                        Уведомлении
                                    </a>
                                </li> --}}
                                </ul>

                                <ul class="text-sm font-medium text-gray-900 text-start dark:text-white">
                                    <li>
                                        <a href="{{ route('support') }}" title="Техническая поддержка"
                                            class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M9.5 10a2.5 2.5 0 1 1 5 .2 2.4 2.4 0 0 1-2.5 2.4V14m0 3h0m9-5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            Техническая поддержка
                                        </a>
                                    </li>
                                </ul>
                                @if (Auth::check() && Auth::user()->role == 'admin')
                                    <ul class="text-sm font-medium text-gray-900 text-start dark:text-white">
                                        <li>
                                            <a href="{{ route('admin-dashboard') }}" title="Техническая поддержка"
                                                class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                                <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M9.5 10a2.5 2.5 0 1 1 5 .2 2.4 2.4 0 0 1-2.5 2.4V14m0 3h0m9-5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                Войдите в админку
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                                @if (Auth::check() && Auth::user()->role == 'seller')
                                    <ul class="text-sm font-medium text-gray-900 text-start dark:text-white">
                                        <li>
                                            <a href="{{ route('seller-dashboard') }}" title="Техническая поддержка"
                                                class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                                                <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M9.5 10a2.5 2.5 0 1 1 5 .2 2.4 2.4 0 0 1-2.5 2.4V14m0 3h0m9-5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                Войдите в админку
                                            </a>
                                        </li>
                                    </ul>
                                @endif


                                <div class="text-sm font-medium text-gray-900 text-start dark:text-white">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 rounded-md group hover:bg-red-50 dark:text-red-500 dark:hover:bg-gray-600">
                                            <svg class="w-4 h-4" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                                            </svg>
                                            Выйти из аккаунта
                                        </button>
                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="relative md:hidden">
                        <button type="button" data-collapse-toggle="ecommerce-navbar-menu-5"
                            class="inline-flex items-center justify-center p-2 text-sm font-medium leading-none text-white rounded-lg hover:text-primary-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span class="sr-only">
                                Menu
                            </span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M5 7h14M5 12h14M5 17h14" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form class="w-full md:w-auto md:flex-1 md:order-2" action="{{ route('search') }}">
                    <label for="default-search"
                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input name="search" value="{{ request('search') }}" type="search" id="default-search"
                            class="block w-full h-full px-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Что ишете..." />

                        <button type="submit"
                            class="absolute px-4 py-1 text-sm font-medium text-white rounded-md end-1 bottom-1 bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Искать</button>
                    </div>
                </form>

                <div id="ecommerce-navbar-menu-5"
                    class="hidden w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                    <ul class="space-y-3 text-sm font-medium text-gray-900 dark:text-white">
                        <li>
                            <a href="{{ route('home') }}"
                                class="hover:text-primary-700 dark:hover:text-primary-500">Главная</a>
                        </li>
                        <li>
                            <a href="{{ route('filters') }}"
                                class="hover:text-primary-700 dark:hover:text-primary-500">Все товары</a>
                        </li>
                        <li>
                            <a href="{{ route('discounted-products') }}"
                                class="hover:text-primary-700 dark:hover:text-primary-500">Товары со скидкой</a>
                        </li>
                        <li>
                            <a href="{{ route('all-sellers') }}"
                                class="hover:text-primary-700 dark:hover:text-primary-500">Все продавцы</a>
                        </li>
                        <li>
                            <a href="{{ route('become-a-seller') }}"
                                class="hover:text-primary-700 dark:hover:text-primary-500">Стать продавцом</a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden py-1 border-b-2 lg:block">
        <div class="flex items-center justify-between max-w-screen-xl px-2 mx-auto 2xl:px-0">
            <ul class="flex items-center gap-8">
                <li class="hidden sm:flex">
                    <a href="{{ route('filters') }}" title=""
                        class="inline-flex items-center gap-1 text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">

                        Все товары
                    </a>
                </li>
                <li class="hidden sm:flex">
                    <a href="{{ route('discounted-products') }}"
                        class="inline-flex items-center gap-1 text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                        Товары со скидкой
                    </a>
                </li>
                <li class="hidden sm:flex">
                    <a href="{{ route('all-sellers') }}"
                        class="inline-flex items-center gap-1 text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">

                        Все продавцы
                    </a>
                </li>

                <li class="hidden md:flex">
                    <a href="{{ route('become-a-seller') }}"
                        class="items-center hidden gap-1 text-sm font-medium text-gray-900 lg:inline-flex hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                        Стать продавцом
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="hs-large-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none"
    role="dialog" tabindex="-1" aria-labelledby="hs-large-modal-label">
    @include('web.partials.categories-modal')
</div>
