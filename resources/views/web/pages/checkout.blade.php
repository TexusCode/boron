@extends('web.layouts.app')
@section('content')
<section class="py-4 antialiased bg-white">
    <form action="{{ route('checkout-post') }}" method="POST" class="max-w-screen-xl px-2 mx-auto">
        @csrf
        <div class=" lg:flex lg:items-start lg:gap-4">
            <div class="flex-1 min-w-0 space-y-4">
                <div class="space-y-2">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Детали доставки</h2>

                    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">
                        <div>
                            <label for="your_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Имя</label>
                            <input type="text" id="your_name" name="name" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Иван Иванов" value="{{ Auth::check() ? Auth::user()->name : '' }}" required />
                        </div>

                        <div>
                            <label for="your_phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Номер телефона</label>
                            <div class="flex">
                                <span class="block p-2 text-base text-gray-900 border border-r-0 border-gray-300 rounded-l-lg bg-gray-50 w-min">+992</span>
                                <input type="text" name="phone" id="your_phone" class="block w-full p-2 text-base text-gray-900 border border-gray-300 rounded-r-lg bg-gray-50 focus:ring-primary-600 focus:border-primary-600" placeholder="931234567" minlength="9" maxlength="9" {{ Auth::check() ? 'value='.Auth::user()->phone : '' }} {{ Auth::check() ? 'disabled' : '' }} required>

                            </div>
                        </div>

                        <div>
                            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Город</label>
                            <select id="city" name="city" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" required>
                                <option value="" disabled selected>Выберите город</option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->name }}">{{ $city->name }}</option>

                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Адрес</label>
                            <input type="text" name="location" id="address" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" placeholder="Улица Пушкина, дом 10" required />

                        </div>
                    </div>
                </div>



                <div class="space-y-2">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Оплата</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="cash-payment" aria-describedby="cash-payment-text" type="radio" name="payment" value="Наличные" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" checked />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="cash-payment" class="font-medium leading-none text-gray-900 dark:text-white"> Наличные </label>
                                    <p id="cash-payment-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Оплата наличными при получении</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="alif-mobi" aria-describedby="alif-mobi-text" type="radio" name="payment" value="Алиф Моби" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="alif-mobi" class="font-medium leading-none text-gray-900 dark:text-white"> Алиф Моби </label>
                                    <p id="alif-mobi-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Через приложение Alif Mobi</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="dushanbe-city" aria-describedby="dushanbe-city-text" type="radio" name="payment" value="Душанбе Сити" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="dushanbe-city" class="font-medium leading-none text-gray-900 dark:text-white"> Душанбе Сити </label>
                                    <p id="dushanbe-city-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Оплата через Душанбе Сити</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="korti-milli" aria-describedby="korti-milli-text" type="radio" name="payment" value="Корти Милли" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="korti-milli" class="font-medium leading-none text-gray-900 dark:text-white"> Корти Милли </label>
                                    <p id="korti-milli-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Оплата через Корти Милли</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="visa-card" aria-describedby="visa-card-text" type="radio" name="payment" value="Карта Visa" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="visa-card" class="font-medium leading-none text-gray-900 dark:text-white"> Карта Visa </label>
                                    <p id="visa-card-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Оплата картой Visa</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="salom-installment" aria-describedby="salom-installment-text" type="radio" name="payment" value="Карта Салом (рассрочка)" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="salom-installment" class="font-medium leading-none text-gray-900 dark:text-white"> Карта Салом (рассрочка) </label>
                                    <p id="salom-installment-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Оплата в рассрочку через карту Салом</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Доставка</h3>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="courier-delivery" aria-describedby="courier-delivery-text" type="radio" name="delivery_type" value="Доставка курьером" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" checked />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="courier-delivery" class="font-medium leading-none text-gray-900 dark:text-white"> Доставка курьером </label>
                                    <p id="courier-delivery-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Прямо к вашему порогу</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="self-pickup" aria-describedby="self-pickup-text" type="radio" name="delivery_type" value="Самовывоз" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />

                                </div>
                                <div class="text-sm ms-4">
                                    <label for="self-pickup" class="font-medium leading-none text-gray-900 dark:text-white"> Самовывоз </label>
                                    <p id="self-pickup-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Заберите товар самостоятельно</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 border border-gray-200 rounded-lg bg-gray-50 ps-4 dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="dushanbe-metro" aria-describedby="dushanbe-metro-text" type="radio" name="delivery_type" value="Через таксисты" class="w-4 h-4 bg-white border-gray-300 text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                                </div>
                                <div class="text-sm ms-4">
                                    <label for="dushanbe-metro" class="font-medium leading-none text-gray-900 dark:text-white"> Через таксисты </label>
                                    <p id="dushanbe-metro-text" class="mt-1 text-xs font-normal text-gray-500 dark:text-gray-400">Доставка через таксисты</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="sticky w-full p-4 mt-6 space-y-6 bg-gray-100 lg:max-w-xs xl:max-w-md rounded-xl top-24">
                <div class="flow-root">
                    <div class="-my-3 divide-y divide-gray-200">
                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Подытог</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $ordercheckout->subtotal }}c</dd>

                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Скидка</dt>
                            <dd class="text-base font-medium text-green-500">{{ $ordercheckout->discount }}</dd>

                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Доставка</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $ordercheckout->delivery_price }}c</dd>

                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-2">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Налог</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white">{{ $ordercheckout->tax }}c</dd>

                        </dl>

                        <dl class="flex items-center justify-between gap-4 py-3">
                            <dt class="text-base font-bold text-gray-900 dark:text-white">Итого</dt>
                            <dd class="text-base font-bold text-gray-900 dark:text-white">{{ $ordercheckout->total }}c</dd>

                        </dl>
                    </div>
                </div>



                <div class="space-y-3">
                    <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4  focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Подтвердить телефон</button>

                </div>
            </div>
        </div>
    </form>
</section>

@endsection
