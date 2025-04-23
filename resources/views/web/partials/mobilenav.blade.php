<div class="fixed bottom-0 left-0 z-40 w-full bg-white border-t-2 lg:hidden">
    <div class="grid grid-cols-5 p-2">
        <a href="{{ route('home') }}" class="flex flex-col justify-center items-center gap-0.5 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="currentColor" d="M12.664 1.253a1 1 0 0 0-1.328 0l-9 8A1 1 0 0 0 2 10v10a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a2 2 0 1 1 4 0v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V10a1 1 0 0 0-.336-.747l-9-8ZM16 19v-5a4 4 0 0 0-8 0v5H4v-8.55l8-7.112 8 7.111V19h-4Z">
                </path>
            </svg>
            <p class="text-sm">Главная</p>
        </a>
        <button aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-offcanvas-example" aria-label="Toggle navigation" data-hs-overlay="#hs-offcanvas-example" class="flex flex-col justify-center items-center gap-0.5 text-gray-600">


            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="currentColor" fill-rule="evenodd" d="M8 9.5a7.5 7.5 0 1 1 11.738 6.189l3.143 5.837a1 1 0 1 1-1.762.948l-3.168-5.884A7.5 7.5 0 0 1 8 9.5ZM15.5 4a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11Z" clip-rule="evenodd"></path>
                <path fill="currentColor" d="M2 9a1 1 0 0 0 0 2h3a1 1 0 1 0 0-2H2Zm0 5a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2H2Zm0 5a1 1 0 1 0 0 2h9a1 1 0 1 0 0-2H2Z">
                </path>
            </svg>

            <p class="text-sm">Каталог</p>
        </button>
        <a href="{{ route('shopcart') }}" class="flex flex-col justify-center items-center gap-0.5 text-gray-600 relative">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="currentColor" d="M6 6a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2h4a1 1 0 0 1 .986 1.164l-1.582 9.494A4 4 0 0 1 17.46 22H6.54a4 4 0 0 1-3.945-3.342L1.014 9.164A1 1 0 0 1 2 8h4V6Zm2 2h5a1 1 0 1 1 0 2H3.18l1.389 8.329A2 2 0 0 0 6.54 20h10.92a2 2 0 0 0 1.972-1.671L20.82 10H17a1 1 0 0 1-1-1V6a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2Z">
                </path>
            </svg>
            <p class="text-sm">Корзина</p>
            <div class="absolute top-[-8px]">
                @livewire('web.cart-counter')
            </div>
        </a>

        <a href="{{ route('favorites') }}" class="flex flex-col justify-center items-center gap-0.5 text-gray-600 relative">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="currentColor" d="M7 5a4 4 0 0 0-4 4c0 3.552 2.218 6.296 4.621 8.22A21.525 21.525 0 0 0 12 19.91a21.58 21.58 0 0 0 4.377-2.69C18.78 15.294 21 12.551 21 9a4 4 0 0 0-4-4c-1.957 0-3.652 1.396-4.02 3.2a1 1 0 0 1-1.96 0C10.652 6.396 8.957 5 7 5Zm5 17c-.316-.02-.56-.147-.848-.278a23.542 23.542 0 0 1-4.781-2.942C3.777 16.705 1 13.449 1 9a6 6 0 0 1 6-6 6.183 6.183 0 0 1 5 2.568A6.183 6.183 0 0 1 17 3a6 6 0 0 1 6 6c0 4.448-2.78 7.705-5.375 9.78a23.599 23.599 0 0 1-4.78 2.942c-.543.249-.732.278-.845.278Z">
                </path>
            </svg>
            <p class="text-sm">Избранные</p>
            <div class="absolute top-[-8px]">
                @livewire('web.favorite-counter')
            </div>
        </a>
        @guest
        <a href="{{ route('login') }}" class="flex flex-col justify-center items-center gap-0.5 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="currentColor" d="M8 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-8.3 4.286c.016.015.185.165.5.323.376.187.971.391 1.8.391s1.425-.204 1.8-.391c.175-.088.355-.19.5-.323a1 1 0 0 1 1.407 1.421C15.587 16.827 14.357 18 12 18c-2.358 0-3.587-1.173-3.707-1.293A1 1 0 0 1 9.7 15.286"></path>
                <path fill="currentColor" d="M11 2a1 1 0 0 1 1-1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12a11 11 0 0 1 6.23-9.914 1 1 0 0 1 1.36.524c.292.72.69 1.565 1.362 2.233C10.592 5.481 11.524 6 13 6a1 1 0 1 1 0 2c-2.024 0-3.458-.743-4.459-1.74-.6-.596-1.027-1.267-1.34-1.875A9 9 0 1 0 12 3a1 1 0 0 1-1.001-1"></path>
            </svg>
            <p class="text-sm">Войти</p>
        </a>
        @endguest
        @auth
        <button type="button" data-drawer-target="drawer-example" data-drawer-show="drawer-example" aria-controls="drawer-example" class="flex flex-col justify-center items-center gap-0.5 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="currentColor" d="M8 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-8.3 4.286c.016.015.185.165.5.323.376.187.971.391 1.8.391s1.425-.204 1.8-.391c.175-.088.355-.19.5-.323a1 1 0 0 1 1.407 1.421C15.587 16.827 14.357 18 12 18c-2.358 0-3.587-1.173-3.707-1.293A1 1 0 0 1 9.7 15.286"></path>
                <path fill="currentColor" d="M11 2a1 1 0 0 1 1-1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12a11 11 0 0 1 6.23-9.914 1 1 0 0 1 1.36.524c.292.72.69 1.565 1.362 2.233C10.592 5.481 11.524 6 13 6a1 1 0 1 1 0 2c-2.024 0-3.458-.743-4.459-1.74-.6-.596-1.027-1.267-1.34-1.875A9 9 0 1 0 12 3a1 1 0 0 1-1.001-1"></path>
            </svg>
            <p class="text-sm">Профиль</p>
        </button>
        @endauth
    </div>
</div>
<div id="drawer-example" class="fixed top-0 left-0 z-50 h-screen p-2 overflow-y-auto transition-transform -translate-x-full bg-white w-80" tabindex="-1" aria-labelledby="drawer-label">
    <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500"></h5>
    <button type="button" data-drawer-hide="drawer-example" aria-controls="drawer-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center">
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
        <span class="sr-only">Закрыть меню</span>
    </button>

    <div>
        <div class="space-y-0">
            <ul class="text-sm font-medium text-gray-900 text-start dark:text-white">
                <li>
                    <a href="{{ route('my-orders') }}" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">

                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                        </svg>
                        Мои заказы
                    </a>
                </li>

                <li>
                    <a href="{{ route('favorites') }}" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z" />
                        </svg>
                        Избранные @livewire('web\favorite-counter')
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
                    <a href="#" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v3m-3-6V7a3 3 0 1 1 6 0v4m-8 0h10c.6 0 1 .4 1 1v7c0 .6-.4 1-1 1H7a1 1 0 0 1-1-1v-7c0-.6.4-1 1-1Z" />
                        </svg>
                        Политика исползование
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
                    <a href="#" title="" class="flex items-center gap-2 px-3 py-2 text-gray-900 rounded-md group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 text-gray-500 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.5 10a2.5 2.5 0 1 1 5 .2 2.4 2.4 0 0 1-2.5 2.4V14m0 3h0m9-5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Техническая поддержка
                    </a>
                </li>
            </ul>


            <div class="text-sm font-medium text-gray-900 text-start dark:text-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 px-3 py-2 text-sm text-red-600 rounded-md group hover:bg-red-50 dark:text-red-500 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2" />
                        </svg>
                        Выйти из аккаунта
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
