@extends('admin.layouts.app')

@section('content')
<div class="w-full h-full bg-gray-50">
    @if($category)
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Изменить категория</h2>
    @else
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Добавить категория</h2>
    @endif

    <!-- Форма добавления категории -->
    <form action="{{ route('add-category', $category->id ?? null) }}" method="POST" enctype="multipart/form-data" class="grid gap-4 p-6 mx-auto bg-white rounded-lg">
        @csrf
        <label class="block">
            <span class="font-semibold text-gray-700">Название категории</span>
            <input type="text" name="name" value="{{ $category->name ?? '' }}" autofocus required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Введите название категории">
        </label>

        <label class="block">
            <span class="font-semibold text-gray-700">Фото категории</span>
            <input type="file" name="photo" class="block w-full mt-1 text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:border-indigo-500 file:bg-indigo-600 file:text-white file:rounded file:py-2 file:px-4">
        </label>

        <button type="submit" class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
            {{ $category ? 'Изменить' : 'Добавить' }} категорию
        </button>
    </form>

    <!-- Список категорий -->
    <div class="mt-8">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Категории</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($categories as $category)
            <div class="flex gap-4 p-2 bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="overflow-hidden rounded-md w-14">
                    <img src="{{ asset('storage/'.$category->photo) }}" alt="Фото категории {{ $category->name }}">


                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-700">{{ $category->name }}</h3>
                    <p class="text-gray-500">{{ $category->products->count() }} товаров</p>
                    <div class="flex gap-4">
                        <form action="{{ route('home-category', $category->id) }}" method="POST">
                            @csrf
                            <select name="sort">
                                <option value="0" {{ $category->sort == 0 ? 'selected' : '' }}>0</option>
                                <option value="1" {{ $category->sort == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $category->sort == 2 ? 'selected' : '' }}>2</option>
                                <option value="3" {{ $category->sort == 3 ? 'selected' : '' }}>3</option>
                                <option value="4" {{ $category->sort == 4 ? 'selected' : '' }}>4</option>
                                <option value="5" {{ $category->sort == 5 ? 'selected' : '' }}>5</option>
                                <option value="6" {{ $category->sort == 6 ? 'selected' : '' }}>6</option>
                                <option value="7" {{ $category->sort == 7 ? 'selected' : '' }}>7</option>
                                <option value="8" {{ $category->sort == 8 ? 'selected' : '' }}>8</option>
                                <option value="9" {{ $category->sort == 9 ? 'selected' : '' }}>9</option>
                                <option value="10" {{ $category->sort == 10 ? 'selected' : '' }}>10</option>
                                <option value="11" {{ $category->sort == 11 ? 'selected' : '' }}>11</option>
                                <option value="12" {{ $category->sort == 12 ? 'selected' : '' }}>12</option>
                            </select>
                            <button type="submit" class="px-3 py-1 text-white rounded-lg {{ $category->ishome ? 'bg-red-600 hover:bg-red-700' : 'bg-primary-600 hover:bg-primary-700' }}">
                                {{ $category->ishome ? 'Не показать на главном' : 'Показать на главном' }}
                            </button>
                        </form>
                        <form action="{{ route('delete-category', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Удалить
                            </button>
                        </form>
                        <a href="{{ route('categories', $category->id) }}" class="px-3 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Изменит
                        </a>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
