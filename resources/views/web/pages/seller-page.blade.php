@extends('web.layouts.app')

@section('content')
<section class="">
    <div class="max-w-screen-xl px-2 mx-auto mt-4 mb-12">
        <div class="max-w-screen-xl text-gray-600 sm:text-lg dark:text-gray-400">
            @if ($seller->products->count() > 0)
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Товары от продавца: <span class="text-primary-600">{{ $seller->store_name }}</span></h2>
            @if ($seller->description)
            <p class="mb-6 text-lg text-gray-800">{{ $seller->description }}</p>
            @endif
            {{-- <p class="mb-6 text-lg text-gray-800">Количество товаров: {{ $seller->products->count() }}</p> --}}

            <div class="grid grid-cols-2 gap-1 mb-8 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach ($products as $product)
                @include('web.partials.product-card', ['product' => $product])
                <!-- Передача переменной продукта в компонент -->
                @endforeach
            </div>
            @else
            <div class="max-w-screen-xl px-2 mx-auto my-16 2xl:px-0">
                <div class="max-w-screen-sm mx-auto text-center">
                    <div class="flex justify-center w-full mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/3314/3314413.png" alt="cart" class="w-24 h-24"> <!-- Увеличил размер иконки -->
                    </div>
                    <p class="mb-4 text-3xl font-bold tracking-tight text-gray-900 md:text-4xl dark:text-white">Упс! У продавца нет товаров</p>
                    <p class="mb-4 text-lg font-normal text-gray-700">Не упустите возможность найти уникальные товары! Используйте поиск, чтобы открыть для себя больше интересных предложений.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center justify-center text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4 transition-all">Вернуться на главную страницу</a>
                </div>
            </div>
            @endif
        </div>
        {{ $products->links('pagination::simple-tailwind') }}
    </div>
</section>
@endsection
