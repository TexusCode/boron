@extends('seller.layouts.app')
@section('content')
<div class="">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Номер заказа</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Дата и время</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Статус</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Цена</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Коль</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Скидка</th>
                    <th class="flex justify-end px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Действия</th>
                </tr>
            </thead>
            <tbody>
                <!-- Пример строки -->
                @foreach ($orders as $order)
                <tr class="border-b border-gray-200">
                    <td class="flex items-center gap-3 px-4 py-3 whitespace-nowrap">#{{ $order->id }}
                        <div>
                            <img src="{{ asset('storage/thumbs/'.$order->product->miniature) }}" alt="" class="object-cover object-center w-12 h-12 overflow-hidden">


                        </div>
                        <div>
                            {{ $order->product->name }}
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $order->created_at }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">{{ $order->status }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $order->price }}c</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $order->count }}шт</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $order->discount ?? 0}}c</td>
                    <td class="flex justify-end gap-2 px-4 py-3 whitespace-nowrap">
                        @livewire('seller.order-confirm',['id'=>$order->id])

                    </td>
                </tr>
                @endforeach
                <!-- Добавьте больше строк здесь -->
            </tbody>
        </table>
    </div>
</div>
{{ $orders->links('pagination::simple-tailwind') }}


@endsection
