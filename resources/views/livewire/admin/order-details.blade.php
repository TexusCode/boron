<div class="">
    <!-- Обертка для основной сетки страницы -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <!-- Левая колонка: Информация о заказе -->
        <div class="p-6 bg-white rounded-lg shadow-md lg:col-span-2">
            <h2 class="mb-4 text-xl font-semibold">Информация о заказе</h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div><span class="font-semibold">Номер заказа:</span> #{{ $order->id }}</div>
                <div><span class="font-semibold">Сумма:</span> {{ $order->subtotal }}c</div>

                <div><span class="font-semibold">Стоимость доставки:</span> {{ $order->delivery_price }}c</div>

                <div><span class="font-semibold">Купон:</span> {{ $order->coupone_code }}</div>

                <div><span class="font-semibold">Налог:</span> {{ $order->tax }}c</div>

                <div><span class="font-semibold">Скидка:</span> {{ $order->discount }}c</div>

                <div><span class="font-semibold">Итог:</span> {{ $order->total }}c</div>

                <div><span class="font-semibold">Тип доставки:</span> {{ $order->delivery_type }}</div>

                <div><span class="font-semibold">Метод оплаты:</span> {{ $order->payment }}</div>
                @if($order->note)
                <div class="md:col-span-2 lg:col-span-3"><span class="font-semibold">Заметка:</span> {{ $order->note }}</div>

                @endif
            </div>
            <div class="p-2 mt-6 bg-white border rounded-lg">
                <h2 class="mb-4 text-xl font-semibold">Список товаров</h2>
                <div class="space-y-4">
                    <!-- Пример товара -->
                    @foreach ($order->suborders as $suborder)
                    <div class="flex items-center justify-between w-full py-2 border-y-2">
                        <div class="flex items-center w-full">
                            <img src="{{ asset('storage/'.$suborder->product->miniature) }}" alt="Фото товара" class="object-cover w-16 h-16 mr-4 rounded-lg">



                            <div class="w-full">
                                <div class="text-lg font-semibold">{{ $suborder->product->name }}</div>

                                <div class="text-sm text-gray-500">Продавец: {{ $suborder->product->seller->store_name }}</div>

                                <div class="text-sm text-gray-500">Цена: {{ $suborder->price }}c</div>
                                <div class="text-sm text-gray-500">Коль: {{ $suborder->count }}шт</div>
                                @if($suborder->status == 'Ожидание')
                                <div class="flex justify-end gap-2">
                                    <button wire:click="confirm({{ $suborder->id }})" type="button" class="text-blue-600 hover:underline">Подтвердить</button>
                                    <button wire:click="cancel({{ $suborder->id }})" type="button" class="text-red-600 hover:underline">Отменить</button>
                                </div>
                                @else
                                <div class="flex justify-end gap-2">
                                    <p class="font-bold text-blue-600 uppercase hover:underline">{{ $suborder->status }}</p>

                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <!-- Повторите блок товара для других товаров -->
                </div>
            </div>

        </div>

        <!-- Правая колонка: Информация о клиенте и выбор доставщика и статуса -->
        <div class="space-y-6">
            <!-- Информация о клиенте -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-xl font-semibold">Информация о клиенте</h2>
                <div class="space-y-2">
                    <div><span class="font-semibold">Имя:</span> {{ $order->user->name }}</div>
                    <div><span class="font-semibold">Телефон:</span>+992 {{ $order->user->phone }}</div>
                    <div><span class="font-semibold">Город:</span> {{ $order->city }}</div>
                    <div><span class="font-semibold">Адрес:</span> {{ $order->location }}</div>
                </div>
            </div>

            <!-- Выбор доставщика и статуса -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <div class="grid grid-cols-1 gap-4">
                    @if($order->delivery_type == 'Доставка курьером')
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700" for="deliveryBoy">Выбор доставщика</label>
                        <select id="deliveryBoy" wire:model.live="deliver" class="w-full p-2 border-gray-300 rounded-lg">
                            @foreach ($delivers as $deliver)
                            <option value="{{ $deliver->id }}">{{ $deliver->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700" for="status">Статус заказа</label>
                        <select id="status" wire:model.live="status" class="w-full p-2 border-gray-300 rounded-lg">
                            <option value="Ожидание">Ожидание</option>
                            <option value="Подтверждено">Подтверждено</option>
                            <option value="Отправлен">Отправлен</option>
                            <option value="Доставлен">Доставлен</option>
                            <option value="Отменен">Отменен</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Список товаров (субзаказы) -->

</div>
