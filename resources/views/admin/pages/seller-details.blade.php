@extends('admin.layouts.app')
@section('content')
<div class="">

    <!-- Seller Details Card -->
    <div class="overflow-hidden lg:flex lg:items-start">

        <!-- Store Logo -->
        <div class="flex-shrink-0 p-4 lg:w-1/4">
            <img class="object-cover w-full h-full lg:w-full lg:h-auto" src="{{ asset('storage/'.$seller->logo) }}" alt="Логотип магазина">

        </div>

        <!-- Store Info -->
        <div class="lg:flex-1">

            <!-- Store Name and Status -->
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">{{ $seller->store_name }}</h2>
                @if($seller->status == 1)
                <span class="text-lg font-semibold text-green-500">
                    Активен
                </span>
                @else
                <span class="text-lg font-semibold text-red-500">
                    Не активен
                </span>

                @endif
            </div>

            <!-- Store Contact Information -->
            <p class="mt-2 text-gray-600">
                Телефон: <a href="tel:{{ $seller->store_phone }}" class="text-blue-600 hover:underline">{{ $seller->store_phone }}</a>
            </p>

            <!-- Verification Status -->
            <p class="mt-1 text-gray-600">
                Верифицирован:
                @if($seller->isverified == 1)
                <span class="font-semibold">
                    Да
                </span>
                @else
                <span class="font-semibold">
                    Нет
                </span>
                @endif
            </p>

            <!-- Description -->
            <p class="mt-4 text-gray-700">
                Описание магазина: {{$seller->description}}
            </p>

            <!-- Moy Sklad ID -->
            <p class="mt-4 text-gray-600">
                МойСклад: <span class="text-gray-800">{{ $seller->moy_sklad == 1 ? 'есть':'нет' }}</span>
            </p>

            <!-- Store Documents -->
            <div class="mt-4">
                <h3 class="text-lg font-semibold text-gray-800">Документы</h3>
                <div class="flex mt-2 space-x-4">
                    <a href="{{ asset('storage/'.$seller->patent )}}" target="_blank" class="text-blue-600 hover:underline">Патент</a>
                    <a href="{{ asset('storage/'.$seller->passport_front) }}" target="_blank" class="text-blue-600 hover:underline">Паспорт (лицевая сторона)</a>
                    <a href="{{ asset('storage/'.$seller->passport_back) }}" target="_blank" class="text-blue-600 hover:underline">Паспорт (обратная сторона)</a>
                </div>
            </div>

            <!-- Registration Date -->
            <p class="mt-4 text-gray-600">
                Дата регистрации: <span class="text-gray-800">{{ $seller->register_date }}</span>
            </p>

            <!-- Action Buttons -->
            <div class="flex mt-6 space-x-4">
                <form action="{{ route('activate-seller', $seller->id) }}" method="POST">

                    @csrf
                    @if($seller->status == true)
                    <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Приостановить работу продавца</button>

                    @else
                    <button type="submit" class="px-4 py-2 text-white bg-teal-600 rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">Подтвердить продавца</button>
                    @endif
                </form>
                <form action="{{ route('verify-seller', $seller->id) }}" method="POST">
                    @csrf
                    @if($seller->isverified == true)

                    <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">Отключить значок проверенного продавца</button>
                    @else
                    <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-600">Включить значок проверенного продавца</button>
                    @endif
                </form>
            </div>

        </div>
    </div>

</div>
<div class="grid grid-cols-2 gap-2 my-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">
    @foreach ($products as $product)
    @include('web.partials.product-card')
    @endforeach
</div>
{{ $products->links('pagination::simple-tailwind') }}


@endsection
