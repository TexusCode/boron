@extends('admin.layouts.app')
@section('content')
@php
    $inputClasses = 'w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500';
    $imagePath = $product->miniature
        ? (\Illuminate\Support\Str::startsWith($product->miniature, ['http://', 'https://']) ? $product->miniature : asset('storage/' . $product->miniature))
        : asset('images/placeholders/product-empty.svg');
@endphp
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Редактирование</p>
                <h1 class="text-3xl font-semibold text-gray-900">Обновить продукт</h1>
                <p class="text-sm text-gray-500">Измените описание, цены, фотографии и другие параметры товара.</p>
            </div>
            <a href="{{ route('all-products') }}" class="inline-flex items-center rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                ← Назад к товарам
            </a>
        </div>
    </header>

    <form action="{{ route('edit-product-post', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Основное</p>
                            <h2 class="text-xl font-semibold text-gray-900">Информация о товаре</h2>
                        </div>
                        <span class="text-xs font-semibold text-gray-500">ID: #{{ $product->id }}</span>
                    </div>
                    <div class="mt-6 space-y-4">
                        <div>
                            <label for="name" class="text-sm font-semibold text-gray-700">Название товара</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="{{ $inputClasses }}" required>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <label for="code" class="text-sm font-semibold text-gray-700">Код товара</label>
                                <input type="text" id="code" name="code" value="{{ old('code', $product->code) }}" class="{{ $inputClasses }}" required>
                            </div>
                            <div>
                                <label for="stock" class="text-sm font-semibold text-gray-700">Количество на складе</label>
                                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="{{ $inputClasses }}" required>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Продавец</label>
                            <div class="mt-2 rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-semibold text-gray-900">
                                {{ $product->seller->store_name ?? '—' }}
                            </div>
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
                    <textarea id="description" name="description" rows="20" class="mt-4 min-h-[300px] rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Финансы</p>
                    <h2 class="text-xl font-semibold text-gray-900">Цена и доставка</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        <div>
                            <label for="price" class="text-sm font-semibold text-gray-700">Цена</label>
                            <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" class="{{ $inputClasses }}" required>
                        </div>
                        <div>
                            <label for="discount" class="text-sm font-semibold text-gray-700">Цена со скидкой</label>
                            <input type="number" step="0.01" id="discount" name="discount" value="{{ old('discount', $product->discount) }}" class="{{ $inputClasses }}">
                        </div>
                        <div>
                            <label for="delivery" class="text-sm font-semibold text-gray-700">Стоимость доставки</label>
                            <input type="number" id="delivery" name="delivery" value="{{ old('delivery', $product->delivery) }}" class="{{ $inputClasses }}" required>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm">
                    <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Медиа</p>
                    <h2 class="text-xl font-semibold text-gray-900">Изображения</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        <div class="flex flex-col items-center rounded-2xl border border-gray-100 bg-gray-50 p-4 text-center">
                            <p class="text-xs uppercase text-gray-500">Текущее</p>
                            <img src="{{ $imagePath }}" alt="{{ $product->name }}" class="mt-3 h-24 w-24 rounded-2xl object-cover">
                        </div>
                        <label class="col-span-2 flex flex-col rounded-2xl border-2 border-dashed border-gray-200 bg-white p-4 text-center text-sm text-gray-500">
                            <span class="font-semibold text-gray-900">Обновить главное изображение</span>
                            <input type="file" accept="image/*" id="miniature" name="miniature" class="mt-3 text-sm text-gray-500">
                        </label>
                        <label class="col-span-3 flex flex-col rounded-2xl border-2 border-dashed border-gray-200 bg-white p-4 text-center text-sm text-gray-500">
                            <span class="font-semibold text-gray-900">Добавить изображения в галерею</span>
                            <input type="file" accept="image/*" multiple id="otherphotos" name="otherphotos[]" class="mt-3 text-sm text-gray-500">
                        </label>
                    </div>
                    @if ($product->otherphotos)
                        <div class="mt-6 rounded-2xl border border-gray-100 bg-gray-50 p-4">
                            @livewire('admin.product-photos', ['id' => $product->id])
                        </div>
                    @endif
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
                                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="subcategory_id" class="text-sm font-semibold text-gray-700">Подкатегория</label>
                            <select id="subcategory_id" name="subcategory_id" class="{{ $inputClasses }}">
                                <option value="">Выберите подкатегорию</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" @selected(old('subcategory_id', $product->subcategory_id) == $subcategory->id)>
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
                    <p class="mt-2 text-sm text-gray-500">После сохранения изменения моментально появятся на витрине и в карточке товара.</p>
                    <div class="mt-6 space-y-3">
                        <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                            Обновить продукт
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
                    toolbar: ['heading', '|', 'bold', 'italic', 'underline', '|', 'link', 'bulletedList',
                        'numberedList', '|', 'blockQuote', 'undo', 'redo'
                    ]
                })
                .catch(error => console.error('CKEditor init error:', error));
        });
    </script>
@endsection
