@extends('seller.layouts.app')
@section('content')
    <section class="space-y-8 px-3 sm:px-6">
        <header
            class="rounded-3xl bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 px-6 py-8 text-white shadow-2xl">
            <p class="text-xs uppercase tracking-[0.4em] text-white/70">Каталог</p>
            <h1 class="mt-2 text-3xl font-semibold">Добавить новый продукт</h1>
            <p class="mt-2 text-sm text-white/85">Заполните карточку товара, загрузите изображения и закрепите категорию.</p>
        </header>

        <form action="{{ route('add-product-post-selle') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-emerald-50">
                <h2 class="text-lg font-semibold text-gray-900">Основная информация</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div class="space-y-1">
                        <label for="name" class="text-sm font-semibold text-gray-600">Название товара</label>
                        <input type="text" id="name" name="name" required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label for="code" class="text-sm font-semibold text-gray-600">Артикул / код</label>
                        <input type="text" id="code" name="code" required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label for="stock" class="text-sm font-semibold text-gray-600">Количество на складе</label>
                        <input type="number" id="stock" name="stock" required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label for="delivery" class="text-sm font-semibold text-gray-600">Информация о доставке</label>
                        <input type="number" id="delivery" name="delivery" required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-emerald-50">
                <h2 class="text-lg font-semibold text-gray-900">Цены и скидки</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <div class="space-y-1">
                        <label for="price" class="text-sm font-semibold text-gray-600">Цена</label>
                        <input type="number" step="0.01" id="price" name="price" required
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label for="discount" class="text-sm font-semibold text-gray-600">Цена со скидкой</label>
                        <input type="number" step="0.01" id="discount" name="discount"
                            class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-gray-600">Категории</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select id="category_id" name="category_id"
                                class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">Категория</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <select id="subcategory_id" name="subcategory_id"
                                class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">Подкатегория</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }} →
                                        {{ $subcategory->category->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-gray-100 bg-white p-6 shadow-lg shadow-emerald-50">
                <h2 class="text-lg font-semibold text-gray-900">Описание</h2>
                <textarea id="description" name="description" rows="10"
                    class="mt-4 min-h-[220px] w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-900 focus:border-emerald-500 focus:ring-emerald-500">{{ old('description') }}</textarea>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <label
                    class="flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-emerald-200 bg-emerald-50/40 px-4 py-10 text-center text-emerald-700">
                    <span class="text-sm font-semibold">Главное изображение</span>
                    <span class="text-xs text-emerald-500">PNG, JPG до 4 МБ</span>
                    <input type="file" accept="image/*" id="miniature" name="miniature" required class="hidden">
                </label>
                <label
                    class="flex flex-col items-center justify-center rounded-3xl border-2 border-dashed border-gray-200 bg-gray-50 px-4 py-10 text-center text-gray-600">
                    <span class="text-sm font-semibold">Дополнительные изображения</span>
                    <span class="text-xs text-gray-400">Можно добавить несколько файлов</span>
                    <input type="file" accept="image/*" multiple id="otherphotos" name="otherphotos[]" class="hidden">
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="inline-flex items-center rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-6 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-emerald-200 transition hover:shadow-emerald-300">
                    Сохранить товар
                </button>
            </div>
        </form>
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
@endsection
