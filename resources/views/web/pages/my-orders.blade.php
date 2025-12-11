@extends('web.layouts.app')
@section('content')
<section class="py-4 antialiased bg-white">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="mx-auto max-w-7xl">
            <div class="gap-4 sm:flex sm:items-center sm:justify-between">
                <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">Мои заказы</h2>
            </div>

            <div class="flow-root">
                @if (Auth::user()->orders->isEmpty())
                <p class="mt-4 text-gray-600">Заказы пока нет.</p>
                @else
                @foreach (Auth::user()->orders as $order)
                <div class="mb-6 divide-y divide-gray-200">
                    <div class="flex flex-wrap items-center py-4 gap-y-4">
                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium">Заказ:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900">
                                <a href="#" class="hover:underline">#{{ $order->id }}</a>
                            </dd>
                        </dl>

                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium">Дата и время:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900">{{ $order->created_at }}</dd>
                        </dl>

                        <dl class="w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium">Итог:</dt>
                            <dd class="mt-1.5 text-base font-semibold text-gray-900">{{ $order->total }}c</dd>
                        </dl>

                        <dl class="justify-end w-1/2 sm:w-1/4 lg:w-auto lg:flex-1">
                            <dt class="text-base font-medium">Статус:</dt>
                            @if($order->status == 'Ожидание')
                            <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-primary-100 px-2.5 py-0.5 text-xs font-medium text-primary-800">
                                <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z" />
                                </svg>
                                {{ $order->status }}
                            </dd>
                            @elseif($order->status == 'Подтверждено')
                            <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-500">
                                <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd" />
                                </svg>
                                {{ $order->status }}
                            </dd>
                            @elseif($order->status == 'Доставлен')
                            <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-500">
                                <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v9a1 1 0 0 0 1 1h.535a3.5 3.5 0 1 0 6.93 0h3.07a3.5 3.5 0 1 0 6.93 0H21a1 1 0 0 0 1-1v-4a.999.999 0 0 0-.106-.447l-2-4A1 1 0 0 0 19 6h-5a2 2 0 0 0-2-2H4Zm14.192 11.59.016.02a1.5 1.5 0 1 1-.016-.021Zm-10 0 .016.02a1.5 1.5 0 1 1-.016-.021Zm5.806-5.572v-2.02h4.396l1 2.02h-5.396Z" clip-rule="evenodd" />
                                </svg>
                                {{ $order->status }}
                            </dd>
                            @elseif($order->status == 'Доставлен')
                            <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-500">
                                <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 0 0-2 2v9a1 1 0 0 0 1 1h.535a3.5 3.5 0 1 0 6.93 0h3.07a3.5 3.5 0 1 0 6.93 0H21a1 1 0 0 0 1-1v-4a.999.999 0 0 0-.106-.447l-2-4A1 1 0 0 0 19 6h-5a2 2 0 0 0-2-2H4Zm14.192 11.59.016.02a1.5 1.5 0 1 1-.016-.021Zm-10 0 .016.02a1.5 1.5 0 1 1-.016-.021Zm5.806-5.572v-2.02h4.396l1 2.02h-5.396Z" clip-rule="evenodd" />
                                </svg>
                                {{ $order->status }}
                            </dd>
                            @elseif($order->status == 'Отменен' && $order->status == 'Отменено')

                            <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-500">
                                <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd" />
                                </svg>
                                {{ $order->status }}
                            </dd>
                            @else
                            <dd class="me-2 mt-1.5 inline-flex items-center rounded bg-teal-100 px-2.5 py-0.5 text-xs font-medium text-teal-500">
                                {{ $order->status }}
                            </dd>
                            @endif
                        </dl>
                        <div class="grid w-full gap-4 sm:grid-cols-2 lg:flex lg:w-64 lg:items-center lg:justify-end">
                            @if($order->status == 'Ожидание')
                            <form action="{{ route('cancel-order', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full px-3 py-2 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:bg-red-700 hover:text-white focus:outline-none focus:ring-4 focus:ring-red-300 whitespace-nowrap lg:w-auto">Отменить заказ</button>
                            </form>
                            @endif
                            @if($order->status == 'Доставлен')
                            <p class="px-2 py-2 text-green-500 bg-green-100 rounded-lg whitespace-nowrap">Спасибо за покупку!</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        @foreach ($order->suborders as $suborder)
                        @php
                        $product = $suborder->product;
                        $imageUrl = $product && $product->miniature
                            ? url('storage/app/public/' . $product->miniature)
                            : 'https://via.placeholder.com/160x160?text=No+Image';
                        $productName = $product->name ?? 'Товар недоступен';
                        @endphp
                        <div class="relative overflow-x-auto border-b border-gray-200 dark:border-gray-800">
                            <table class="w-full text-base text-left text-gray-900 dark:text-white md:table-fixed">
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                    <tr>
                                        <td class="py-4 w-96 min-w-56 whitespace-nowrap">
                                            <a href="#" class="flex items-center gap-4 font-medium hover:underline">
                                                <div class="w-10 h-10 aspect-square shrink-0">
                                                    <img class="w-full h-full dark:hidden" src="{{ $imageUrl }}" alt="product image" />

                                                </div>
                                                {{ $productName }}


                                            </a>
                                        </td>

                                        <td class="p-4 text-base font-bold text-gray-900 text-end dark:text-white">x{{ $suborder->count }}</td>
                                        <td class="p-4 text-base font-bold text-gray-900 text-end dark:text-white">{{ $suborder->price }}c</td>
                                        <td class="p-4 text-base font-bold text-gray-900 text-end">{{ $suborder->status}}</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>


                        @endforeach
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
