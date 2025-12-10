@extends('admin.layouts.app')

@section('content')
<section class="space-y-6">
    <header class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Настройки</p>
                <h1 class="text-3xl font-semibold text-gray-900">Бизнес‑параметры</h1>
                <p class="text-sm text-gray-500">Управляйте налогом, доставкой, оптимизацией изображений и выгрузками.</p>
            </div>
        </div>
    </header>

    <div class="grid gap-6 lg:grid-cols-2">
        <form action="{{ route('tax') }}" method="POST" class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            @csrf
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Налог</p>
            <div>
                <label class="text-sm font-semibold text-gray-700">Процент налога</label>
                <input type="number" step="0.01" name="tax" value="{{ $tax->tax ?? '' }}" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="10">
            </div>
            <button type="submit"
                class="w-full rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Сохранить</button>
        </form>

        <form action="{{ route('delivery') }}" method="POST" class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            @csrf
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Доставка</p>
            <div>
                <label class="text-sm font-semibold text-gray-700">Цена доставки</label>
                <input type="number" step="0.01" name="delivery" value="{{ $delivery->tax ?? '' }}" required
                    class="mt-2 w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="20">
            </div>
            <button type="submit"
                class="w-full rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Сохранить</button>
        </form>

        <form action="{{ route('imageoptomozer') }}" method="POST" class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            @csrf
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Изображения</p>
            <p class="text-sm text-gray-500">Оптимизируйте миниатюры товаров одним нажатием.</p>
            <button type="submit"
                class="w-full rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Запустить оптимизацию</button>
        </form>

        <form action="{{ route('facebook-feeds') }}" method="POST" class="space-y-4 rounded-3xl bg-white p-6 shadow-sm">
            @csrf
            <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Facebook Feeds</p>
            <p class="text-sm text-gray-500">Сгенерируйте или обновите каталог товаров для Facebook/Instagram.</p>
            <button type="submit"
                class="w-full rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-indigo-500">Обновить каталог</button>
        </form>

        <form action="{{ route('truncate') }}" method="POST" class="space-y-4 rounded-3xl bg-white p-6 shadow-sm lg:col-span-2"
            onsubmit="return confirm('Вы уверены, что хотите удалить все товары? Это действие необратимо.');">
            @csrf
            <p class="text-xs uppercase tracking-[0.3em] text-rose-500">Опасная зона</p>
            <p class="text-sm text-gray-500">Удаление всех товаров из каталога. Действие необратимо.</p>
            <button type="submit"
                class="w-full rounded-2xl bg-rose-600 px-5 py-2 text-sm font-semibold text-white shadow hover:bg-rose-500">Удалить все товары</button>
        </form>
    </div>
</section>
@endsection
