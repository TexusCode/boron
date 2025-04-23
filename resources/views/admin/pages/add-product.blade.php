@extends('admin.layouts.app')
@section('content')
<div class="">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Добавить новый продукт</h2>

    <form action="{{ route('add-product-post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:gap-6 lg:grid-cols-5">
            <!-- Name -->
            <div class="col-span-full">
                <label for="name" class="block text-sm font-medium text-gray-700">Название товара</label>
                <input type="text" id="name" name="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Description -->
            <div class="col-span-full">
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <textarea id="description" name="description" rows="20" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required></textarea>
            </div>

            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Код товара</label>
                <input type="text" id="code" name="code" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Количество на складе</label>
                <input type="number" id="stock" name="stock" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                <input type="number" step="0.01" id="price" name="price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Discount -->
            <div>
                <label for="discount" class="block text-sm font-medium text-gray-700">Цена со скидкой <span class="text-xs text-red-500">(не обязательно)</span></label>
                <input type="number" step="0.01" id="discount" name="discount" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Delivery -->
            <div>
                <label for="delivery" class="block text-sm font-medium text-gray-700">Информация о доставке</label>
                <input type="number" id="delivery" name="delivery" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Miniature (Image) -->
            <div>
                <label for="miniature" class="block text-sm font-medium text-gray-700">Изображение продукта</label>
                <input type="file" accept="image/*" id="miniature" name="miniature" class="block w-full mt-1 text-gray-500" required>
            </div>
            <div>
                <label for="otherphotos" class="block text-sm font-medium text-gray-700">Дополнительные изображения продукта</label>
                <input type="file" accept="image/*" multiple id="otherphotos" name="otherphotos[]" class="block w-full mt-1 text-gray-500">
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Категория</label>
                <select id="category_id" name="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>
            </div>

            <!-- Subcategory -->
            <div>
                <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Подкатегория</label>
                <select id="subcategory_id" name="subcategory_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option>Выберите подкатегорию</option>
                    @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->category->name ?? '' }}->{{ $subcategory->name }}</option>


                    @endforeach
                </select>
            </div>

            <!-- Seller -->
            <div>
                <label for="seller" class="block text-sm font-medium text-gray-700">Продавец</label>
                <select id="seller" name="seller" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option>Выберите продавца</option>
                    @foreach ($sellers as $seller)
                    <option value="{{ $seller->id }}">{{ $seller->store_name }}</option>
                    @endforeach

                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-start col-span-full">
                <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Добавить продукт
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
