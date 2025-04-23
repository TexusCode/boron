@extends('admin.layouts.app')
@section('content')
<div>
    <section class="">
        <div class="">
            <div class="">
                <div class="flex flex-col space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                    <div class="flex items-center flex-1 space-x-4">
                        <h5>
                            <span class="text-gray-500">Все продавцы:</span>
                            <span class="">{{ $sellers->count() }}</span>
                        </h5>
                    </div>
                    <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                        <a href="{{ route('add-seller') }}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 focus:outline-none">
                            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Добавить новый продавец
                        </a>
                    </div>
                </div>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 ">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                            <tr>
                                <th scope="col" class="px-4 py-3">Название</th>
                                <th scope="col" class="px-4 py-3">Товары</th>
                                <th scope="col" class="px-4 py-3">Продажи</th>
                                <th scope="col" class="px-4 py-3">Статус</th>
                                <th scope="col" class="px-4 py-3">Дата регистрация</th>
                                <th scope="col" class="flex justify-end px-4 py-3">Дейстивия</th>

                            </tr>
                        </thead>
                        <tbody class="">
                            @foreach ($sellers as $seller)
                            <tr class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">

                                <th scope="row" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap ">
                                    <img src="{{ 'http://boron.tj/storage/app/public/'.$seller->logo }}" alt="{{ $seller->store_name }}" class="w-auto h-8 mr-3">

                                    {{ $seller->store_name }}
                                </th>
                                <td class="px-4 py-2">
                                    {{ $seller->products->sum('stock') }}шт
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap ">{{ $seller->products->sum('sell') }}шт</td>

                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap ">
                                    <div class="flex items-center">
                                        @if($seller->status == 1)
                                        <div class="inline-block w-4 h-4 mr-2 bg-green-700 rounded-full"></div>
                                        Активно
                                        @else
                                        <div class="inline-block w-4 h-4 mr-2 bg-red-700 rounded-full"></div>
                                        Не активно

                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap ">{{ $seller->register_date }}</td>
                                <td class="px-4 py-2 font-medium text-gray-900 w-min whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <a href="">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('show-seller',$seller->id) }}">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd" />
                                                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>

</div>
@endsection
