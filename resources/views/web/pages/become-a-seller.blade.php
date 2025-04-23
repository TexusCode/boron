@extends('web.layouts.app')
@section('content')
<form action="{{ route('seller-register') }}" method="POST" enctype="multipart/form-data" class="p-2 mx-auto mt-6 mb-24 rounded lg:p-0 lg:grid lg:grid-cols-2 lg:gap-4 max-w-7xl">
    @csrf
    <div class="col-span-full">
        <h1 class="mb-4 text-3xl font-bold text-gray-800">Регистрация продавца</h1>

        <!-- Подзаголовок с приветствием -->
        <p class="mb-4 text-lg text-gray-600">
            Добро пожаловать! Мы рады, что вы решили присоединиться к нашему сообществу продавцов.
        </p>

        <!-- Описание шагов регистрации -->
        <p class="mb-6 text-gray-700">
            Пожалуйста, заполните форму ниже, чтобы завершить регистрацию. Укажите информацию о вашем магазине, добавьте необходимые документы и примите условия использования. После регистрации вам будет доступен личный кабинет для управления товарами и заказами.
        </p>

    </div>
    <!-- Название магазина -->
    <div class="mb-2">
        <label for="store_name" class="block mb-2 font-bold text-gray-700">Название магазина</label>
        <input type="text" name="store_name" id="store_name" required placeholder="Введите название магазина" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
    </div>

    <!-- Телефон магазина -->
    <div class="mb-2">
        <label for="store_phone" class="block mb-2 font-bold text-gray-700">Телефон магазина</label>
        <div class="flex">
            <span class="block p-2 text-base border border-r-0 border-black rounded-l-lg w-min">+992</span>

            <input type="text" name="store_phone" class="block w-full p-2 text-base border rounded-r-lg focus:outline-none focus:ring focus:ring-blue-200" placeholder="931234567" minlength="9" maxlength="9" required>


        </div>

        {{-- <input type="text" name="store_phone" id="store_phone" required placeholder="Введите телефон магазина" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200"> --}}
    </div>

    <!-- Описание -->
    <div class="mb-2 col-span-full">
        <label for="description" class="block mb-2 font-bold text-gray-700">Описание</label>
        <textarea name="description" id="description" placeholder="Введите краткое описание" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200"></textarea>
    </div>

    <!-- Логотип -->
    <div class="mb-2">
        <label for="logo" class="block mb-2 font-bold text-gray-700">Логотип магазина</label>
        <input type="file" name="logo" id="logo" class="w-full px-6 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
    </div>

    <!-- Патент -->
    <div class="mb-2">
        <label for="patent" class="block mb-2 font-bold text-gray-700">Документ патента</label>
        <input type="file" name="patent" id="patent" class="w-full px-6 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
    </div>

    <!-- Паспорт (лицевая сторона) -->
    <div class="mb-2">
        <label for="passport_front" class="block mb-2 font-bold text-gray-700">Паспорт (лицевая сторона)</label>
        <input type="file" name="passport_front" id="passport_front" class="w-full px-6 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
    </div>

    <!-- Паспорт (обратная сторона) -->
    <div class="mb-2">
        <label for="passport_back" class="block mb-2 font-bold text-gray-700">Паспорт (обратная сторона)</label>
        <input type="file" name="passport_back" id="passport_back" class="w-full px-6 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" {{ Auth::check() && Auth::user()->role == 'admin' ? '' : 'required' }}>
    </div>

    <!-- Чекбокс "Согласие с условиями" -->
    <div class="flex items-center mb-6 col-span-full">
        <input type="checkbox" name="terms" required id="terms" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
        <label for="terms" class="block ml-2 text-gray-700">Я согласен с условиями</label>
    </div>

    <!-- Кнопка отправки -->
    <div class="flex justify-center lg:justify-start">
        <button type="submit" class="w-full px-6 py-2 font-semibold text-white bg-blue-600 rounded-lg lg:w-min hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200">Регистрация</button>
    </div>
</form>
@endsection
