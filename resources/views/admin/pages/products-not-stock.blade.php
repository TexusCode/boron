@extends('admin.layouts.app')
@section('content')
<form action="{{ route('update-products') }}" method="POST">
    @csrf
    <div class="flex flex-col gap-4 lg:flex-row">
        <div class="w-full">
            <label for="action" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите действия</label>
            <select id="action" name="action" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option selected>Выберите действия</option>
                <option value="delete">Удалить выбранные</option>
                <option value="activate">Активироват выбранные</option>
                <option value="deactivate">Деактивировать выбранные</option>
            </select>
        </div>
        <div class="w-full">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Категория</label>
            <select id="category" name="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected>Выберите категория</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full">
            <label for="subcategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Под категория</label>
            <select id="subcategory" name="subcategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="" selected>Выберите под категория</option>
                @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end w-full">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 w-full">Обновить</button>
        </div>

    </div>
    <div class="grid grid-cols-2 gap-2 my-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6">

        @foreach ($products as $product)
        @include('admin.partials.product-card')
        @endforeach

    </div>
    {{ $products->links('pagination::simple-tailwind') }}
</form>

@endsection
