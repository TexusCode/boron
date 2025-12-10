@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Каталог</p>
                <h1 class="text-3xl font-semibold text-gray-900">Города доставки</h1>
                <p class="text-sm text-gray-500">Укажите населённые пункты, где доступна доставка и курьеры.</p>
            </div>
            <button type="button" data-modal-target="city-modal" data-modal-toggle="city-modal"
                class="inline-flex items-center rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">
                + Добавить город
            </button>
        </div>
    </header>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Список</p>
                <h2 class="text-xl font-semibold text-gray-900">Всего городов: {{ $cities->count() }}</h2>
            </div>
        </div>
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @foreach ($cities as $city)
                <div class="flex items-center justify-between rounded-2xl border border-gray-100 bg-gray-50 px-4 py-3 shadow-sm">
                    <div>
                        <p class="text-base font-semibold text-gray-900">{{ $city->name }}</p>
                        <p class="text-xs text-gray-500">ID: {{ $city->id }}</p>
                    </div>
                    <form action="{{ route('city-del', $city->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="rounded-full bg-rose-600 px-3 py-1 text-xs font-semibold text-white hover:bg-rose-500">
                            Удалить
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</section>

<div id="city-modal" tabindex="-1" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Город</p>
                <h3 class="text-lg font-semibold text-gray-900">Новая запись</h3>
            </div>
            <button type="button" data-modal-hide="city-modal" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <form action="{{ route('city-add') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-gray-700">Название города</label>
                <input type="text" name="city" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Например, Хуҷанд">
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" data-modal-hide="city-modal"
                    class="rounded-2xl border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-50">Отмена</button>
                <button type="submit"
                    class="rounded-2xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Добавить</button>
            </div>
        </form>
    </div>
</div>
@endsection
