@extends('admin.layouts.app')
@section('content')
<div class="">
    <h2 class="mb-6 text-2xl font-semibold text-gray-800">Обновить продукт</h2>

    <form action="{{ route('edit-product-post',$product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:gap-6 lg:grid-cols-5">

            <!-- Name -->
            <div class="col-span-full">
                <label for="name" class="block text-sm font-medium text-gray-700">Название товара</label>
                <input type="text" value="{{ $product->name }}" id="name" name="name" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <!-- Description -->
            <div class="col-span-full">
                <label for="description" class="block text-sm font-medium text-gray-700">Описание</label>
                <textarea value="{{ $product->description }}" id="description" name="description" rows="4" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ $product->description }}</textarea>


            </div>

            <!-- Code -->
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Код товара</label>
                <input type="text" value="{{ $product->code }}" id="code" name="code" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>

            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Количество на складе</label>
                <input type="number" value="{{ $product->stock }}" id="stock" name="stock" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>

            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Цена</label>
                <input type="number" value="{{ $product->price }}" step="0.01" id="price" name="price" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>

            </div>

            <!-- Discount -->
            <div>
                <label for="discount" class="block text-sm font-medium text-gray-700">Цена со скидкой <span class="text-xs text-red-500">(не обязательно)</span></label>
                <input type="number" value="{{ $product->discount }}" step="0.01" id="discount" name="discount" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

            </div>

            <!-- Delivery -->
            <div>
                <label for="delivery" class="block text-sm font-medium text-gray-700">Информация о доставке</label>
                <input type="number" value="{{ $product->delivery }}" id="delivery" name="delivery" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>

            </div>

            <!-- Miniature (Image) -->
            <div>
                <label for="miniature" class="block text-sm font-medium text-gray-700">Изображение продукта</label>
                <input type="file" accept="image/*" id="miniature" name="miniature" class="block w-full mt-1 text-gray-500">
            </div>
            <div>
                <label for="otherphotos" class="block text-sm font-medium text-gray-700">Дополнительные изображения продукта</label>
                <input type="file" accept="image/*" multiple id="otherphotos" name="otherphotos[]" class="block w-full mt-1 text-gray-500">
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Категория</label>
                <select id="category_id" name="category_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option disabled>Выберите категорию</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id ==$category->id ? 'selected':'' }}>{{ $category->name }}</option>


                    @endforeach

                </select>
            </div>

            <!-- Subcategory -->
            <div>
                <label for="subcategory_id" class="block text-sm font-medium text-gray-700">Подкатегория</label>
                <select id="subcategory_id" name="subcategory_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option disabled>Выберите подкатегорию</option>
                    @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}" {{ $product->subcategory_id ==$subcategory->id ? 'selected':'' }}>{{ $subcategory->name }}->{{ $subcategory->category->name ?? '' }}</option>

                    @endforeach
                </select>
            </div>

            @if($product->otherphotos)
            <div class="col-span-full">
                @livewire('admin.product-photos', ['id'=>$product->id])
            </div>
            @endif

            <!-- Submit Button -->
            <div class="flex justify-start col-span-full">
                <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Обновить продукт
                </button>
            </div>
        </div>
    </form>
</div>

@endsection
