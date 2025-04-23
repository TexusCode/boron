@extends('admin.layouts.app')

@section('content')
<div class="w-full h-full bg-gray-50">
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Добавить слайдер</h2>

    <!-- Форма добавления категории -->
    <form action="{{ route('slider-add') }}" method="POST" enctype="multipart/form-data" class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
        @csrf
        <label class="block">
            <span class="font-semibold text-gray-700">Ссылка слайдера</span>
            <input type="text" name="link" value="" autofocus required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="http://">

        </label>

        <label class="block">
            <span class="font-semibold text-gray-700">Фото слайдера</span>
            <input type="file" name="image" class="block w-full mt-1 text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-indigo-500 file:bg-indigo-600 file:text-white file:rounded file:py-2 file:px-4">

        </label>

        <button type="submit" class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
            Добавить слайдер
        </button>
    </form>

    <!-- Список категорий -->
    <div class="mt-8">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Слайдеры</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($sliders as $slider)
            <div class="flex gap-4 p-2 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="overflow-hidden rounded-md w-14">
                    <img src="{{ asset('storage/'.$slider->image) }}" alt="Фото категории {{ $slider->link }}">
                </div>
                <form action="{{ route('slider-del', $slider->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700">
                        Удалить
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
