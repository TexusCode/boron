@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Каталог</p>
                <h1 class="text-3xl font-semibold text-gray-900">Подкатегории</h1>
                <p class="text-sm text-gray-500">Свяжите категории с более точными направлениями для удобной навигации.</p>
            </div>
            @if($subcategory)
                <a href="{{ route('subcategories') }}" class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    ← Добавить новую
                </a>
            @else
                <button type="button" data-modal-target="subcategory-modal" data-modal-toggle="subcategory-modal"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                    + Добавить подкатегорию
                </button>
            @endif
        </div>
    </header>

    <div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Список</p>
                        <h2 class="text-xl font-semibold text-gray-900">Всего подкатегорий: {{ $subcategories->count() }}</h2>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($subcategories as $sub)
                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 shadow-sm">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="text-xs uppercase text-gray-500">Категория</p>
                                    <p class="font-semibold text-gray-900">{{ $sub->category->name ?? '-' }}</p>
                                </div>
                                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-gray-500">
                                    {{ $sub->products->count() }} товаров
                                </span>
                            </div>
                            <p class="mt-3 text-sm text-gray-700">Подкатегория: <span class="font-semibold">{{ $sub->name }}</span></p>
                            <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold">
                                <a href="{{ route('subcategories', $sub->id) }}"
                                    class="rounded-2xl border border-gray-200 px-3 py-1 text-gray-700 hover:bg-white">
                                    Изменить
                                </a>
                                <form action="{{ route('delete-subcategory', $sub->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="rounded-2xl bg-rose-600 px-3 py-1 text-white hover:bg-rose-500">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<div id="subcategory-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Подкатегория</p>
                <h3 class="text-lg font-semibold text-gray-900">Добавить новую</h3>
            </div>
        </div>
        <form action="{{ route('add-subcategory') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Категория</label>
                <select name="category_id"
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Название подкатегории</label>
                <input type="text" name="name" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="subcategory-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
