@extends('admin.layouts.app')
@section('content')
<div class="">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Номер заказа</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Телефон клиента</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Дата и время</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Статус</th>
                    <th class="px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Итого</th>
                    <th class="flex justify-end px-4 py-2 font-semibold text-left text-gray-600 whitespace-nowrap">Действия</th>
                </tr>
            </thead>
            <tbody>
                <!-- Пример строки -->
                @foreach ($orders as $order)
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-3 whitespace-nowrap">#{{ $order->id }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">+992 {{ $order->user->phone ?? 'Номер не задано'}}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $order->created_at }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">{{ $order->status }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $order->total }}c</td>
                    <td class="flex justify-end gap-2 px-4 py-3 whitespace-nowrap">
                        <a href="{{ route('order-details', $order->id) }}" class="text-blue-600 hover:underline">Посмотреть</a>
                        <button class="text-red-600 hover:underline">Удалить</button>
                    </td>
                </tr>
                @endforeach
                <!-- Добавьте больше строк здесь -->
            </tbody>
        </table>
    </div>
</div>


@endsection
