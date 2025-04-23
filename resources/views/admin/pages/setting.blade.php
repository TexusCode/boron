@extends('admin.layouts.app')

@section('content')
    <div class="w-full h-full bg-gray-50">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Настройки</h2>
        <form action="{{ route('tax') }}" method="POST" enctype="multipart/form-data"
            class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
            @csrf
            <label class="block">
                <span class="font-semibold text-gray-700">Процент налог</span>
                <input type="text" name="tax" autofocus required
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="10" value="{{ $tax->tax ?? '' }}">
            </label>
            <button type="submit"
                class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
                Обновить
            </button>
        </form>
        <form action="{{ route('delivery') }}" method="POST" enctype="multipart/form-data"
            class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
            @csrf
            <label class="block">
                <span class="font-semibold text-gray-700">Цена доставка</span>
                <input type="text" name="delivery" autofocus required
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    placeholder="10" value="{{ $delivery->tax ?? '' }}">

            </label>
            <button type="submit"
                class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
                Обновить
            </button>
        </form>

    </div>
    <div class="w-full h-full bg-gray-50">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Оптимизироват изображение для карточки</h2>
        <form action="{{ route('imageoptomozer') }}" method="POST" enctype="multipart/form-data"
            class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
            @csrf
            <button type="submit"
                class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
                Оптимизировать
            </button>
        </form>

    </div>
    <div class="w-full h-full bg-gray-50">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Обновить или создать каталог Facebook Feeds</h2>
        <form action="{{ route('facebook-feeds') }}" method="POST" enctype="multipart/form-data"
            class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
            @csrf
            <button type="submit"
                class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
                Обновить или создать
            </button>
        </form>

    </div>
@endsection
