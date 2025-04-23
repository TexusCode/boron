@extends('web.layouts.app')
@section('content')
<section class="bg-white">
    <div class="max-w-screen-xl px-2 mx-auto mt-4 mb-12">
        <div class="max-w-screen-xl text-gray-500 sm:text-lg dark:text-gray-400">
            @if (Auth::user()->favorites->isNotEmpty())
            <h2 class="mb-4 text-4xl font-bold tracking-tight text-gray-900">Избранные товары</h2>
            <div class="grid grid-cols-2 gap-1 mb-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach (Auth::user()->favorites as $favorite)
                @include('web.partials.product-card', ['product' => $favorite->product])
                <!-- Изменено на $favorite->product -->
                @endforeach

            </div>
            @else
            <div class="max-w-screen-xl px-2 mx-auto my-16 2xl:px-0">
                <div class="max-w-screen-sm mx-auto text-center">
                    <div class="flex justify-center w-full mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/3314/3314413.png" alt="cart" class="size-36">


                    </div>


                    <p class="mb-4 text-3xl font-bold tracking-tight text-gray-900 md:text-4xl dark:text-white">Ваши избранные продукты отсутствуют</p>


                    <p class="mb-4 text-lg font-normal text-gray-700">Воспользуйтесь поиском, чтобы найти всё, что нужно, и добавьте в избранные, чтобы они появились здесь.</p>


                    <a href="{{ route('home') }}" class="inline-flex text-white bg-primary-600 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4">Вернуться на главную страницу</a>

                </div>

            </div>

            @endif
        </div>
    </div>
</section>

@endsection
