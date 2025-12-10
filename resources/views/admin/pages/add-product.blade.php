@extends('admin.layouts.app')
@section('content')
@php
    $inputClasses = 'w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500';
@endphp
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Товары</p>
        <div class="mt-2 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900">Добавить продукт</h1>
                <p class="text-sm text-gray-500">Заполните информацию о товаре, загрузите изображения и распределите его по категориям.</p>
            </div>
            <a href="{{ route('all-products') }}" class="inline-flex items-center rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                ← Вернуться к списку
            </a>
        </div>
    </header>

    <form action="{{ route('add-product-post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Основное</p>
                            <h2 class="text-xl font-semibold text-gray-900">Информация о товаре</h2>
                        </div>
                    </div>
                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="name" class="text-sm font-semibold text-gray-700">Название товара</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="{{ $inputClasses }}" required>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="code" class="text-sm font-semibold text-gray-700">Код товара</label>
                                <input type="text" id="code" name="code" value="{{ old('code') }}" class="{{ $inputClasses }}" required>
                            </div>
                            <div>
                                <label for="stock" class="text-sm font-semibold text-gray-700">Количество на складе</label>
                                <input type="number" id="stock" name="stock" value="{{ old('stock') }}" class="{{ $inputClasses }}" required>
                            </div>
                        </div>
                        <div>
                            <label for="seller" class="text-sm font-semibold text-gray-700">Продавец</label>
                            <select id="seller" name="seller" class="{{ $inputClasses }}" required>
                                <option value="">Выберите продавца</option>
                                @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}" @selected(old('seller') == $seller->id)>{{ $seller->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Описание</p>
                            <h2 class="text-xl font-semibold text-gray-900">Контент и детали</h2>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">CKEditor</span>
                    </div>
                    <textarea id="description" name="description" rows="20" class="mt-4 min-h-[300px] rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Финансы</p>
                    <h2 class="text-xl font-semibold text-gray-900">Цена и доставка</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="price" class="text-sm font-semibold text-gray-700">Цена</label>
                            <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" class="{{ $inputClasses }}" required>
                        </div>
                        <div>
                            <label for="discount" class="text-sm font-semibold text-gray-700">Цена со скидкой</label>
                            <input type="number" step="0.01" id="discount" name="discount" value="{{ old('discount') }}" class="{{ $inputClasses }}">
                        </div>
                        <div>
                            <label for="delivery" class="text-sm font-semibold text-gray-700">Стоимость доставки</label>
                            <input type="number" id="delivery" name="delivery" value="{{ old('delivery') }}" class="{{ $inputClasses }}" required>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Медиа</p>
                    <h2 class="text-xl font-semibold text-gray-900">Изображения</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        <label class="flex flex-col rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 p-4 text-center text-sm text-gray-500">
                            <span class="font-semibold text-gray-900">Главное изображение</span>
                            <input type="file" accept="image/*" id="miniature" name="miniature" class="mt-3 text-sm text-gray-500" required>
                        </label>
                        <label class="flex flex-col rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 p-4 text-center text-sm text-gray-500">
                            <span class="font-semibold text-gray-900">Галерея</span>
                            <input type="file" accept="image/*" multiple id="otherphotos" name="otherphotos[]" class="mt-3 text-sm text-gray-500">
                        </label>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Категории</p>
                    <h2 class="text-xl font-semibold text-gray-900">Каталогизация</h2>
                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="category_id" class="text-sm font-semibold text-gray-700">Категория</label>
                            <select id="category_id" name="category_id" class="{{ $inputClasses }}">
                                <option value="">Выберите категорию</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="subcategory_id" class="text-sm font-semibold text-gray-700">Подкатегория</label>
                            <select id="subcategory_id" name="subcategory_id" class="{{ $inputClasses }}">
                                <option value="">Выберите подкатегорию</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" @selected(old('subcategory_id') == $subcategory->id)>
                                        {{ $subcategory->category->name ?? '' }} → {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Публикация</p>
                    <h2 class="text-xl font-semibold text-gray-900">Сохранение</h2>
                    <p class="mt-2 text-sm text-gray-500">Проверьте введённые данные перед сохранением. Вы сможете отредактировать товар позже.</p>
                    <div class="mt-6 space-y-3">
                        <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                            Сохранить продукт
                        </button>
                        <a href="{{ route('all-products') }}" class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                            Отменить
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionField = document.querySelector('#description');
        if (!descriptionField) {
            return;
        }

        ClassicEditor
            .create(descriptionField, {
                toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'link', 'bulletedList', 'numberedList', '|', 'blockQuote', 'undo', 'redo']
            })
            .catch(error => console.error('CKEditor init error:', error));
    });
</script>
@endsection
