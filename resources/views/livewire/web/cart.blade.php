<section class="py-4 antialiased bg-white">

    @if($user->count() > 0)
    <div class="max-w-screen-xl px-2 mx-auto 2xl:px-0">
        <h2 class="flex items-center gap-2 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Корзина @livewire('web.cart-counter')</h2>
        <div class="mt-4 md:gap-6 lg:flex lg:items-start xl:gap-8">
            <div class="flex-none w-full mx-auto lg:max-w-2xl xl:max-w-4xl">
                <div class="space-y-2">
                    @foreach ($user as $cart)
                    <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex gap-2">
                            <a href="{{ route('details', $cart->product->id) }}" class="shrink-0">
                                <img class="object-cover object-center w-20 h-20 border border-black rounded-lg" src="{{ asset('storage/thumbs/'.$cart->product->miniature) }}" alt="{{ $cart->product->name }}" />


                            </a>
                            <div class="flex flex-col justify-between w-full">
                                <div class="w-full min-w-0">
                                    <a href="{{ route('details', $cart->product->id) }}" class="text-base font-medium text-gray-900 hover:underline line-clamp-1">{{ $cart->product->name }}</a>


                                    <div class="flex w-full gap-4 text-base font-normal text-gray-900 line-clamp-1">
                                        <p>Магазин: <span class="font-bold">{{ $cart->product->seller->store_name}}</span></p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-[-2px]">
                                    <div class="flex items-center">
                                        <button type="button" wire:click="minus({{ $cart['id'] }})" class="inline-flex items-center justify-center w-5 h-5 bg-gray-100 border border-gray-300 rounded-md shrink-0 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">

                                            <svg class="h-2.5 w-2.5 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                            </svg>
                                        </button>
                                        <input type="text" class="w-10 text-sm font-medium text-center text-gray-900 bg-transparent border-0 shrink-0 focus:outline-none focus:ring-0" placeholder="" value="{{ $cart->count }}" required />
                                        <button type="button" wire:click="plus({{ $cart['id'] }})" class="inline-flex items-center justify-center w-5 h-5 bg-gray-100 border border-gray-300 rounded-md shrink-0 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                            <svg class="h-2.5 w-2.5 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="flex gap-4 p-0 text-end">
                                        <p class="text-base font-bold text-gray-900 dark:text-white">
                                            @if($cart->product->discount)

                                            {{ $cart->product->discount*$cart->count }}
                                            @else
                                            {{ $cart->product->price*$cart->count }}
                                            @endif
                                            c</p>


                                        <button type="button" wire:click="delete({{ $cart->id }})" class="text-base font-bold text-red-500 dark:text-white">Удалит</button>


                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>

            </div>

            <div class="sticky flex-1 mx-auto mt-6 space-y-4 lg:mt-0 lg:w-full top-32">
                <div class="p-4 space-y-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                    <p class="text-xl font-semibold text-gray-900 dark:text-white">Сводка заказа</p>

                    <div class="space-y-2">
                        <div class="space-y-1">
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Подытог</dt>

                                <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $subtotal }}c</dd>

                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Доставка</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $delivery }}с</dd>
                            </dl>

                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Налог</dt>
                                <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $tax }}с - <span class="text-green-500">{{ round($tax/$subtotal*100) }}%</span></dd>
                            </dl>
                            @if($coupone)
                            <dl class="flex items-center justify-between gap-4">
                                <dt class="text-base font-normal text-gray-500">Скидка</dt>
                                <dd class="text-base font-medium text-gray-900">{{ round($coupone) }}с </span></dd>
                            </dl>
                            @endif
                            @if($coupone==0)
                            <div>
                                <label for="voucher" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Введите подарочную карту, ваучер или промокод</label>

                                <div class="flex items-center max-w-md gap-4">
                                    <input type="text" wire:model="couponeinput" id="voucher" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="" required />
                                    <button type="button" wire:click="couponebutton" class="flex items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Применить</button>
                                </div>
                            </div>
                            @endif

                        </div>

                        <dl class="items-center justify-between hidden gap-4 pt-2 border-t border-gray-200 lg:flex dark:border-gray-700">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Итого</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $total }}c</dd>
                        </dl>
                    </div>

                    <button type="button" wire:click="checkout" class="lg:flex w-full hidden items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Перейти к оформлению</button>

                    <div class="fixed left-0 block w-full h-24 px-2 bg-white border-t-2 bottom-16 lg:hidden">
                        <dl class="flex items-center justify-between gap-4 pt-2 border-t border-gray-200 dark:border-gray-700">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Итого</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $total }}c</dd>
                        </dl>
                        <button type="button" wire:click="checkout" class="flex mt-2 w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Перейти к оформлению</button>


                        {{-- <a href="{{ route('checkout') }}" class="flex mt-2 w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Перейти к оформлению</a> --}}
                    </div>
                    <div class="items-center justify-center hidden gap-2 lg:flex">
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">или</span>
                        <a href="#" title="" class="inline-flex items-center gap-2 text-sm font-medium underline text-primary-700 hover:no-underline dark:text-primary-500">
                            Продолжить покупку
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
    @else
    <div class="max-w-screen-xl px-2 mx-auto my-16 2xl:px-0">
        <div class="max-w-screen-sm mx-auto text-center">
            <div class="flex justify-center w-full mb-4">
                <img src="https://static.thenounproject.com/png/3592847-512.png" alt="cart" class="size-36">

            </div>


            <p class="mb-4 text-3xl font-bold tracking-tight text-gray-900 md:text-4xl dark:text-white">Корзина пуста</p>

            <p class="mb-4 text-lg font-normal text-gray-700">Воспользуйтесь поиском, чтобы найти всё, что нужно, и добавьте в корзину, чтобы они появились здесь.</p>

            <a href="{{ route('home') }}" class="inline-flex text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4">Вернуться на главную страницу</a>

        </div>

    </div>
    @endif
</section>
