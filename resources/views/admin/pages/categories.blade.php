@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Каталог</p>
                <h1 class="text-3xl font-semibold text-gray-900">Категории</h1>
                <p class="text-sm text-gray-500">Создавайте структуры каталога и управляйте отображением на главной.</p>
            </div>
            @if($category)
                <a href="{{ route('categories') }}" class="inline-flex items-center rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    ← Добавить новую
                </a>
            @else
                <button type="button" data-modal-target="category-modal" data-modal-toggle="category-modal"
                    class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                    + Добавить категорию
                </button>
            @endif
        </div>
    </header>

    @if($category)
        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Редактирование</p>
            <h2 class="text-xl font-semibold text-gray-900">Изменить категорию «{{ $category->name }}»</h2>
            <form action="{{ route('add-category', $category->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <label class="text-sm font-semibold text-gray-700">Название</label>
                    <input type="text" name="name" value="{{ $category->name }}" required
                        class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700">Изображение</label>
                    <input type="file" name="photo"
                        class="mt-2 w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-4 text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white">
                </div>
                <div class="md:col-span-2 flex justify-end gap-3">
                    <a href="{{ route('categories') }}" class="rounded-2xl border border-gray-200 px-5 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                        Отмена
                    </a>
                    <button type="submit" class="rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div>
        <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Список</p>
                        <h2 class="text-xl font-semibold text-gray-900">Всего категорий: {{ $categories->count() }}</h2>
                    </div>
                </div>
                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    @foreach ($categories as $cat)
                        <div class="flex gap-4 rounded-2xl border border-gray-100 bg-gray-50 p-4 shadow-sm">
                            <div class="h-16 w-16 overflow-hidden rounded-2xl bg-white">
                                <img src="{{ asset('storage/'.$cat->photo) }}" alt="{{ $cat->name }}" class="h-full w-full object-cover">
                            </div>
                            <div class="flex-1 space-y-2">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="text-base font-semibold text-gray-900">{{ $cat->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $cat->products->count() }} товаров</p>
                                    </div>
                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $cat->ishome ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-200 text-gray-600' }}">
                                        {{ $cat->ishome ? 'На главной' : 'Скрыта' }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-2 text-sm">
                                    <form action="{{ route('home-category', $cat->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="sort" class="rounded-2xl border border-gray-200 bg-white px-3 py-1 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            @for ($i = 0; $i <= 12; $i++)
                                                <option value="{{ $i }}" @selected($cat->sort == $i)>{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <button type="submit"
                                            class="rounded-2xl px-3 py-1 text-xs font-semibold {{ $cat->ishome ? 'bg-rose-50 text-rose-600' : 'bg-indigo-600 text-white' }}">
                                            {{ $cat->ishome ? 'Убрать' : 'На главную' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('delete-category', $cat->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="rounded-2xl bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-500">
                                            Удалить
                                        </button>
                                    </form>
                                    <a href="{{ route('categories', $cat->id) }}"
                                        class="rounded-2xl border border-gray-200 px-3 py-1 text-xs font-semibold text-gray-700 hover:bg-white">
                                        Изменить
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<div id="category-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Категория</p>
                <h3 class="text-lg font-semibold text-gray-900">Добавить новую</h3>
            </div>
            <button type="button" data-modal-hide="category-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('add-category') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Название</label>
                <input type="text" name="name" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-sm font-semibold text-gray-700">Изображение</label>
                <input type="file" name="photo"
                    class="mt-2 w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-4 text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="category-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit" class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
