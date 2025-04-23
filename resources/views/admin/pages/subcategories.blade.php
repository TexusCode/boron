@extends('admin.layouts.app')

@section('content')
<div class="w-full h-full bg-gray-50">
    <!-- Форма добавления подкатегории -->
    @if($subcategory)

    <h2 class="mb-4 text-2xl font-bold text-gray-800">Изменить подкатегория</h2>
    @else
    <h2 class="mb-4 text-2xl font-bold text-gray-800">Добавить подкатегория</h2>
    @endif


    <form action="{{ route('add-subcategory', $subcategory->id ?? null) }}" method="POST" class="grid gap-4 p-6 mx-auto bg-white rounded-lg shadow-md">


        @csrf
        <label class="block">
            <span class="font-semibold text-gray-700">Выберите категорию</span>
            <select name="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ isset($subcategory->category) && $subcategory->category->name === $category->name ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </label>

        <label class="block">
            <span class="font-semibold text-gray-700">Название подкатегории</span>
            <input type="text" name="name" value="{{ $subcategory->name ?? '' }}" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Введите название подкатегории">



        </label>

        <button type="submit" class="w-full px-4 py-2 font-semibold text-white rounded-md shadow-sm bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-indigo-200 focus:outline-none focus:ring-opacity-50">
            Добавить подкатегорию
        </button>
    </form>

    <!-- Список подкатегорий -->
    <div class="mt-8">
        <h2 class="mb-4 text-2xl font-bold text-gray-800">Подкатегории</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @foreach ($subcategories as $subcategory)
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700">
                    Категория: {{ $subcategory->category->name ?? ''}}
                </h3>
                <p class="text-gray-700">
                    Подкатегория: {{ $subcategory->name }}
                </p>
                <p class="text-gray-500">
                    Количество товаров: {{ $subcategory->products->count() }}
                </p>
                <div class="flex gap-3">

                    <form action="{{ route('delete-subcategory', $subcategory->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Удалить
                        </button>
                    </form>
                    <a href="{{ route('subcategories',$subcategory->id) }}" class="px-3 py-1 text-white bg-red-600 rounded-lg hover:bg-red-700">

                        Изменить
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
